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
        $this->checkRestMethod($request);

        $post = new Post();
        $user = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array(
                'id' => $request->get('userId')
            ));

        if(!$user ||!$request->get('areaId1')) throw new ClientErrorException('invalidPostValue');

        $post->setUser($user)
            ->setText($request->get('text'))
            ->setAreaId1((int)$request->get('areaId1'))
            ->setAreaId2((int)$request->get('areaId2'))
            ->setAreaId3((int)$request->get('areaId3'));
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

    /**
     * @Route("/getTimeline",defaults={"_format"="json"},name="api_post_getTimeline")
     * @Template
     */
    public function getTimelineAction(Request $request)
    {
        $this->checkRestMethod($request);

        $postService = $this->get('post_service');
        ($request->get('postId'))?$postId = $request->get('postId'):$postId = null;
        $posts = $postService->fetchTimelinePosts($postId , $this->container->getParameter('post_num'));
        return array(
            'Posts'=>$posts
        );
    }

}
