<?php
namespace Yusuke\HimatanBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * DeleteUserType.
 *
 * @author Yusuke Higaki <yusuke.higaki@dzb.jp>
 */
class DeleteUserType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder , array $options)
    {
        $builder->add('id')
        ;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'delete_user';
    }
}