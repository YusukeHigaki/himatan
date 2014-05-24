<?php

namespace Yusuke\HimatanBundle\Exception\Output;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Dzb\BoloBundle\Exception\ClientErrorException;

/**
 * abstract ClientErrorExceptionOutput Class
 *
 * @author Kyosuke Nakajima <kyosuke.nakajima@dzb.jp>
 */
abstract class ClientErrorOutput implements ErrorOutputInterface
{
    /**
     * @var ClientErrorException $exception
     */
    protected $exception;

    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @var TwigEngine $templating
     */
    protected $templating;

    /**
     * abstract createProdEnvironmentResponse
     *
     * @return Response
     */
    abstract protected function createProdEnvironmentResponse();

    /**
     * abstract createDevEnvironmentResponse
     *
     * @return Response
     */
    abstract protected function createDevEnvironmentResponse();

    /**
     * Constructor.
     *
     * @param ClientErrorException $exception
     * @param ContainerInterface $container
     * @param TwigEngine $templating
     */
    public function __construct(ClientErrorException $exception, ContainerInterface $container, TwigEngine $templating)
    {
        $this->exception = $exception;
        $this->container = $container;
        $this->templating = $templating;
    }

    /**
     * final getResponse
     *
     * return Response
     */
    final public function getResponse()
    {
        $environment = $this->container->getParameter('kernel.environment');
        switch ($environment) {
            case 'prod':
                $response = $this->createProdEnvironmentResponse();
                break;
            case 'dev':
                $response = $this->createDevEnvironmentResponse();
                break;
            default:
                $response = new Response('no valid response method found for this environment in ClientErrorOutput class. please register one.');
                break;
        }
        return $response;
    }
}
