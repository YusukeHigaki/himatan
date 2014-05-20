<?php
/**
 * Created by PhpStorm.
 * User: higakiyuusuke
 * Date: 2014/05/13
 * Time: 16:27
 */

namespace Yusuke\HimatanBundle\Controller\Api;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Entity\User;
use Yusuke\HimatanBundle\Exception\ClientErrorException;
use Yusuke\HimatanBundle\Component\ImageFile;

/**
 * UserApiController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/api/user")
 */

class UserApiController extends ApiController
{
    /**
     * @Route("/setUser",defaults={"_format"="json"},name="api_user_setUser")
     * @Template
     */
    public function setUserAction(Request $request)
    {
        $this->checkRestMethod($request);

        if(!$request->get('device') || !$request->get('version')) throw new ClientErrorException('invalidPostValue');

        $user = new User();
        $user->setDevice((int)$request->get('device'))
            ->setVersion((int)$request->get('version'))
            ->setToken($request->get('token'));
        $validator = $this->get('validator');
        $errors = $validator->validate($user,array('setUserApi'));

        if(count($errors)>0){
            throw new ClientErrorException('inValidPostValue');
        }else{
            $em = $this->get('doctrine')->getEntityManager();
            $em->persist($user);
            $em->flush();
            return array(
                'id' => $user->getId(),
            );
        }

    }

    /**
     * @Route("/getUser",defaults={"_format"="json"},name="api_user_getUser")
     * @Template
     */
    public function getUserAction(Request $request)
    {
        $this->checkRestMethod($request);

        $user = $this->getDoctrine()->getRepository('YusukeHimatanBundle:user')
            ->findOneBy(array(
                'id' => $request->get('id'),
                'deleteFlag' => 0,
            ));

        if(!$user) throw new ClientErrorException('invalidPostValue');

        return array(
            'User' => $user
        );
    }

    /**
     * @Route("/updateUser",defaults={"_format"="json"},name="api_user_updateUser")
     * @Template
     */
    public function updateUserAction(Request $request)
    {
        $this->checkRestMethod($request);

        $user = $this->get('doctrine')->getRepository('YusukeHimatanBundle:User')->findOneBy(array(
            'id' => (int)$request->request->get('id'),
            'deleteFlag' => 0,
        ));
        if(!$user){
            throw new ClientErrorException('inValidPostValue');
        }

        $validator = $this->get('validator');

        if($request->get('token')){
            $user->setToken($request->get('token'));
            $errors = $validator->validate($user,array('updateTokenApi'));
        }else{
            $user
                ->setName($request->get('name'))
                ->setSex((int)$request->get('sex'))
                ->setAge((int)$request->get('age'))
                ->setAreaId((int)$request->get('areaId'))
                ->setintroduction($request->get('introduction'));

            $s3uploadService = $this->get('s3_upload_service');
            $picFileParams = array('pic1','pic2','pic3','pic4');
            foreach($picFileParams as $params){
                $file = $request->files->get($params);
                if($file){
                    $iconImg = new ImageFile($file);
                    switch($params){
                        case('pic1') : $user->setPic1($iconImg->getFileName()); break;
                        case('pic2') : $user->setPic2($iconImg->getFileName()); break;
                        case('pic3') : $user->setPic3($iconImg->getFileName()); break;
                        case('pic4') : $user->setPic4($iconImg->getFileName()); break;
                    }
                    $dir = $this->container->getParameter('amazon_s3_dir') . 'user/';
                    $s3uploadService->upload($iconImg,$dir);
                    $iconImg->remove();
                }
            }
            $errors = $validator->validate($user,array('updateUserApi'));
        }
        if(count($errors)>0){
            throw new ClientErrorException('inValidPostValue');
        }else{
            $em = $this->get('doctrine')->getEntityManager();
            $em->flush();
            return array();
        }
    }


}