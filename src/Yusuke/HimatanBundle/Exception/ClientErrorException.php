<?php
namespace Yusuke\HimatanBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/15
 * Time: 14:33
 */

class ClientErrorException extends HttpException implements ExceptionInterface
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
        parent::__construct(200,$message,null,array(),0);
    }

    public function getExceptionMessage()
    {
        return $this->message;
    }
}