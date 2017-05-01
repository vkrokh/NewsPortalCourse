<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegisterType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/{_locale}")
 */
class UserController extends Controller
{

    /**
     * @Route("/user", name="user_profile")
     */
    public function profilePageAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('user/profile.html.twig', ['user' => $user]);
    }


    /**
     * @Route("/user/dispatch", name="user_dispatch")
     */
    public function dispatchChangeAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $this->get('app.security.activator')->dispatching($user);
        return $this->redirect($this->generateUrl('user_profile'));
    }


    /**
     * @Route("/user/edit/{userId}", name="user_edit")
     */
    public function editUserAction(Request $request, int $userId)
    {
        $userService = $this->get('app.security.users');
        $user = $userService->getUserById($userId);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userService->saveUser($user);
            return $this->redirect($this->generateUrl('admin_users'));
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'user/userEdit.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors,
                'id' => $userId
            )
        );
    }


    /**
     * @Route("/user/delete/{userId}", name="user_delete")
     */
    public function deleteUserAction(int $userId)
    {
        $userService = $this->get('app.security.users');
        $userService->deleteUser($userId);
        return $this->redirect($this->generateUrl('admin_users'));
    }

    /**
     * @Route("/user/create/", name="user_create")
     */
    public function createUserAction(Request $request)
    {
        //TODO fix shit
        $userService = $this->get('app.security.users');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->add(
            'plainPassword', RepeatedType::class,
            [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'form.user.password'],
                'second_options' => ['label' => 'form.user.cpassword'],
                'invalid_message' => 'password.not.match',
                'error_bubbling' => true,
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $userService->saveUser($user);
            return $this->redirect($this->generateUrl('admin_users'));
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'user/userCreate.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors,
                'id' => ''
            )
        );
    }

}
