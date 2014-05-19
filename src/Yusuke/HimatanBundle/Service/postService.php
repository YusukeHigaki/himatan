<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/19
 * Time: 14:11
 */
namespace Yusuke\HimatanBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostService
{
    private $managerRegistry;

    public function __construct(RegistryInterface $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function fetchTimelinePosts($postId = null , $limit)
    {
        $postRepository = $this->managerRegistry->getRepository('YusukeHimatanBundle:Post');

        if(!$postId){
            $query = $postRepository->createQueryBuilder('p')
                ->orderBy('p.id','DESC')
                ->setMaxResults($limit)
                ->getQuery();
        }else{
            $query = $postRepository->createQueryBuilder('p')
                ->where('p.id < :postId')
                ->setParameter('postId', $postId)
                ->orderBy('p.id','DESC')
                ->setMaxResults($limit)
                ->getQuery();
        }
        $posts = $query->getResult();
        return $posts;
    }
}