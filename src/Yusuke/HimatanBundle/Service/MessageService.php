<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/20
 * Time: 14:27
 */

namespace Yusuke\HimatanBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MessageService
{
    private $managerRegistry;

    public function __construct(RegistryInterface $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function fetchNewMessages($to,$messageId = 0)
    {
        $messageRepository = $this->managerRegistry->getRepository('YusukeHimatanBundle:Message');
        $query = $messageRepository->createQueryBuilder('m')
            ->where('m.to = :to')
            ->andWhere('m.id > :messageId')
            ->orderBy('m.id','DESC')
            ->setParameters(array(
                'to' => $to,
                'messageId' => $messageId,
            ))
            ->getQuery();

        $messages = $query->getResult();

        return $messages;
    }
}