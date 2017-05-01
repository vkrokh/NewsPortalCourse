<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\CheckboxTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class,
            ['label' => 'form.user.email', 'error_bubbling' => true,])
            ->add('name', TextType::class, ['label' => 'name', 'error_bubbling' => true,])
            ->add('enabled', CheckboxType::class, ['label' => 'enabled', 'required' => false])
            ->add('dispatch', CheckboxType::class, ['label' => 'dispatch', 'required' => false])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'USER' => 'ROLE_USER',
                    'CONTENT MANAGER' => 'ROLE_CONTENT_MANAGER',
                    'ADMIN' => 'ROLE_ADMIN'
                ],
                'multiple' => false,
                'label' => 'user.roles',
                'error_bubbling' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
