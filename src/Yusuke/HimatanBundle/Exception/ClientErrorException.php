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
    const HTTP_SUCCESS = 200;
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
        parent::__construct(self::HTTP_SUCCESS,$message,null,array(),0);
    }

    public function getExceptionMessage()
    {
        return $this->message;
    }
}
