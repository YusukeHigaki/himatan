<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/13
 * Time: 16:19
 */

namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\bundle\FrameworkBundle\Controller\Controller;
use Yusuke\HimatanBundle\Controller\AppController;
use Yusuke\HimatanBundle\Exception\ClientErrorException;


/**
 * ApiController.
 *
 */

abstract class ApiController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkRestMethod(Request $request){
        if('POST' !== $request->getMethod()) throw new ClientErrorException('invalidRESTMethod');
    }
}
