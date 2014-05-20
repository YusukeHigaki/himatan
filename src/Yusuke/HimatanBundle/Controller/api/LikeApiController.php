<?php

namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Entity\Like;
use Yusuke\HimatanBundle\Entity\User;

/**
 * LikeApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/like")
 */
class LikeApiController extends ApiController
{
    /**
     * @Route("/setLike",defaults={"_format"="json"},name="api_post_setLike")
     * @Template
     */
    public function setLikeAction(Request $request)
    {
        $this->checkRestMethod($request);

        $like = new Like();
        $to = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array(
                'id' => $request->get('to'),
                'deleteFlag' => 0,
            ));
        if(!$to) throw new ClientErrorException('invalidPostValue');

        $from = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array(
                'id' => $request->get('from'),
                'deleteFlag' => 0,
            ));
        if(!$from) throw new ClientErrorException('invalidPostValue');

        $like
            ->setFrom($from)
            ->setTo($to)
        ;
        $validator = $this->get('validator');
        $errors = $validator->validate($like,'setLikeApi');
        if(count($errors)>0) throw new ClientErrorException('invalidPostValue');

        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($like);
        $em->flush();

        $cntHeart = $to->getCntHeart();
        $cntHeart++;
        $to->setCntHeart($cntHeart);
        $em->persist($to);
        $em->flush();

        return array();
    }

}