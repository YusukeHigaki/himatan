<?php

namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Entity\Message;
use Yusuke\HimatanBundle\Component\ImageFile;


/**
 * MessageApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/message")
 */
class MessageApiController extends ApiController
{
    /**
     * @Route("/setMessage",defaults={"_format"="json"},name="api_message_setMessage")
     * @Template
     */
    public function setMessageAction(Request $request)
    {
        $this->checkRestMethod($request);

        $message = new Message();
        $from = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array('id'=>$request->get('fromId')));
        $to = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array('id'=>$request->get('toId')));
        if(!$from || !$to || !$request->get('text')){
            throw new ClientErrorException('invalidPostValue');
        }

        $message
            ->setFrom($from)
            ->setTo($to)
            ->setText($request->get('text'))
            ->setType(1);
        $validator = $this->get('validator');
        $errors = $validator->validate($message,'setMessage');

        if(count($errors)>0){
            throw new ClientErrorException('invalidPostValue');
        }else{
            $em = $this->get('doctrine')->getEntityManager();
            $em->persist($message);
            $em->flush();
            return array();
        }
    }

    /**
     * @Route("/setImage",defaults={"_format"="json"},name="api_message_setImage")
     * @Template
     */
    public function setImageAction(Request $request)
    {
        $this->checkRestMethod($request);

        $message = new Message();
        $from = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array('id'=>$request->get('fromId')));
        $to = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array('id'=>$request->get('toId')));
        $img = $request->files->get('img');
        if (!$from || !$to || empty($img)) {
            throw new ClientErrorException('invalidPostValue');
        }

        $s3uploadService = $this->get('s3_upload_service');
        $img = new ImageFile($request->files->get('img'));
        $dir = $this->container->getParameter('amazon_s3_dir') . 'message/';
        $s3uploadService->upload($img,$dir);
        $img->remove();

        $message
            ->setFrom($from)
            ->setTo($to)
            ->setText($this->container->getParameter('amazon_s3_base_url').$dir.$img->getFileName())
            ->setType(2)
        ;
        $validator = $this->get('validator');
        $errors = $validator->validate($message,'setImage');
        if(count($errors)>0){
            throw new ClientErrorException('invalidPostValue');
        }else{
            $em = $this->get('doctrine')->getEntityManager();
            $em->persist($message);
            $em->flush();
        }

        return array();
    }

    /**
     * @Route("/getMessage",defaults={"_format"="json"},name="api_message_getMessage")
     * @Template
     */
    public function getMessageAction(Request $request)
    {
        $this->checkRestMethod($request);

        $messageService = $this->get('message_service');
        ($request->get('messageId'))?$messageId = $request->get('messageId'):$messageId = 0;
        $messages = $messageService->fetchNewMessages($request->get('toId'),$messageId);
        return array(
            'Messages'=>$messages
        );
    }

}