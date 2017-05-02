<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 11/04/17
 * Time: 23:46
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'form.user.name'])
            ->add('email', EmailType::class, ['label' => 'form.user.email', 'error_bubbling' => true])
            ->add(
                'plainPassword', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'form.user.password'],
                    'second_options' => ['label' => 'form.user.cpassword'],
                    'invalid_message' => 'password.not.match',
                    'error_bubbling' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => User::class,
            )
        );
    }
}