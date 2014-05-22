<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/22
 * Time: 9:09
 */
namespace Yusuke\HimatanBundle\Command\AdminCommand;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;

class deleteUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('himatan:deleteUser')
            ->setDescription('delete specified user')
            ->addArgument('userId',InputArgument::REQUIRED,'Who do you want to delete?')
        ;
    }

    protected function execute(InputInterface $input , OutputInterface $output)
    {
        $blacklistService = $this->getContainer()->get('BlacklistService');
        $blacklistService->deleteUser($input->getArgument('userId'));
        $output->writeln('<info>User Delete DONE</info>');
    }
}