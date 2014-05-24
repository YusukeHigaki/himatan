<?php
namespace Yusuke\HimatanBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\bundle\FrameworkBundle\Controller\Controller;
use Yusuke\HimatanBundle\Controller\AppController;
use Yusuke\HimatanBundle\Exception\ClientErrorException;


/**
 * AdminController.
 */

abstract class AdminRootController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkRestMethod(Request $request){
        if(!'POST' === $request->getMethod()) throw new ClientErrorException('invalidRESTMethod');
    }
}
