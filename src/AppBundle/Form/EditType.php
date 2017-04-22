<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/14/17
 * Time: 4:47 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class EditType extends RegisterType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options){
        $builder->add('roles', ChoiceType::class, [
            'choices' => [
                'User' => 'ROLE_USER',
                'Content Manager' => 'ROLE_CONTENT_MANAGER',
                'Admin' => 'ROLE_ADMIN'
            ]
        ])
        };
    }
}