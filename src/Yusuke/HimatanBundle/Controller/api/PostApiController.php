<?php

namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Entity\Post;

/**
 * PostApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/post")
 */

class PostApiController extends ApiController
{
    /**
     * @Route("/setPost",defaults={"_format"="json"},name="api_post_setPost")
     * @Template
     */
    public function setPostAction(Request $request)
    {
        $post = new Post();
        if('POST' === $request->getMethod()){
            $user = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
                ->findOneBy(array('id'=>$request->get('userId')));
            if(!$user) throw new ClientErrorException('invalidPostValue');

            $post->setUser($user)
                 ->setText($request->get('text'))
                 ->setAreaId1($request->get('areaId1'))
                 ->setAreaId2($request->get('areaId2'))
                 ->setAreaId3($request->get('areaId3'));
            $validator = $this->get('validator');
            $errors = $validator->validate($post,array('setPost'));

            if(count($errors)>0){
                throw new ClientErrorException('invalidPostValue');
            }else{
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($post);
                $em->flush();
                return array();
            }
        }


        return array();
    }

    /**
     * @Route("/getTimeline",defaults={"_format"="json"},name="api_post_getTimeline")
     * @Template
     */
    public function getTimelineAction(Request $request)
    {
        return array();
    }

}