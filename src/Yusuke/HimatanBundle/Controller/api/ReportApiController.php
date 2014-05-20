<?php

namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Entity\report;
use Yusuke\HimatanBundle\Service\BlacklistService;

/**
 * ReportApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/report")
 */
class ReportApiController extends ApiController
{
    /**
     * @Route("/setReport",defaults={"_format"="json"},name="api_post_setReport")
     * @Template
     */
    public function setReportAction(Request $request)
    {
        $this->checkRestMethod($request);

        $report = new report();
        $to = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array(
                'id' => $request->get('to'),
                'deleteFlag' => 0,
            ));
        if(!$to) throw new ClientErrorException('invalidPostValue');

        $from = $this->getDoctrine()->getRepository('YusukeHimatanBundle:User')
            ->findOneBy(array(
                'id' => $request->get('from'),
                'deleteFlag' => 0,
            ));
        if(!$from) throw new ClientErrorException('invalidPostValue');

        $report
            ->setFrom($from)
            ->setTo($to)
        ;
        $validator = $this->get('validator');
        $errors = $validator->validate($report,'setreportApi');
        if(count($errors)>0) throw new ClientErrorException('invalidPostValue');

        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($report);
        $em->flush();

        $cntReport = $to->getCntReport();
        $cntReport++;

        if($cntReport>$this->container->getParameter('delete_user_num')){
            $BlacklistService = $this->get('blacklist_service');
            $BlacklistService->deleteUser($to);
        }

        $to->setCntReport($cntReport);
        $em->persist($to);
        $em->flush();

        return array();
    }

}