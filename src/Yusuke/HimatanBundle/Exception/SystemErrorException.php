<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/18
 * Time: 18:34
 */

namespace Yusuke\HimatanBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;


/**
 * SystemErrorException.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 */
class SystemErrorException extends HttpException implements ExceptionInterface
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
