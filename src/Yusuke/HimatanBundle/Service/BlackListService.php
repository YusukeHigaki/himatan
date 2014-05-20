<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/20
 * Time: 16:26
 */
namespace Yusuke\HimatanBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BlacklistService
{
    private $managerRegistry;

    public function __construct(RegistryInterface $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function deleteUser($user)
    {
        $user->setDeleteFlag(1);
        /*

                $em = $this->managerRegistry->getEntityManager();
                $em->persist($user);
                $em->flush();
          */
    }

    public function AlertMail()
    {

    }
}