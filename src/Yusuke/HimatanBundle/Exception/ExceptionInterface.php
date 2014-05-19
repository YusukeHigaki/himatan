<?php
namespace Yusuke\HimatanBundle\Exception;

/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/15
 * Time: 14:30
 */


interface ExceptionInterface
{
    /**
     * get exception message
     *
     * @return string Exception Message
     */
    public function getExceptionMessage();
}