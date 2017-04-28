<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegisterType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


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
            'user/userCreate.html.twig',
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

    }

}
