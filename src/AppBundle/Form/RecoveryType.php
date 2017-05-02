<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 12/04/17
 * Time: 13:32
 */

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Entity\UserRecovery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecoveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'plainPassword', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'form.user.password'],
                    'second_options' => ['label' => 'form.user.cpassword'],
                    'invalid_message' => 'password.not.match',
                    'error_bubbling' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => UserRecovery::class,
            )
        );
    }
}