<?php
namespace Yusuke\HimatanBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yusuke\HimatanBundle\Controller\Admin\AdminRootController;
use Yusuke\HimatanBundle\Entity\User;
use Yusuke\HimatanBundle\Form\Admin\DeleteUserType;

/**
 * AdminController.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 *
 * @Route("/admin")
 */
class AdminController extends AdminRootController
{
    /**
     * @Route("/",name="admin_home")
     * @Template
     */
    public function homeAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/deleteUser",name="admin_delete_user")
     * @Template
     */
    public function deleteUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new DeleteUserType() , $user);
        $flag = false;

        if('POST' === $request->getMethod()){
            $form->bind($request);
            if($form->isValid()){
                $blacklistService = $this->get('blacklist_service');
                $blacklistService->deleteUser($user->getId());
                $flag = true;
            }
        }

        return array(
            'flag' => $flag,
            'form' => $form->createView(),
        );
    }


}
