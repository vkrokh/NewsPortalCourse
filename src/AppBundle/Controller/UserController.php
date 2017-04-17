<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\EditType;
use AppBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{


    /**
     * @Route("/login", name="user_login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registerService = $this->get('app.security.register');
            $registerService->registerUser($user);
            return $this->redirectToRoute('user_login');
        }
        $errors = (string) $form->getErrors(true);
        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView(),
                'errors'=>$errors)
        );
    }

    /**
     * @Route("/activate/{token}", name="user_activate")
     */
    public function activateAction(string $token)
    {
        $activateService = $this->get('app.security.activator');
        $activateService->activation($token);
        return $this->redirect($this->generateUrl('user_login'));
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/edit", name="user_edit")
     */
    public function editUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(EditType::class, $user);
        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $registerService = $this->get('app.security.register');
//            $registerService->registerUser($user);
//            return $this->redirectToRoute('user_login');
//        }
        $errors = (string) $form->getErrors(true);
        return $this->render(
            'user/edit.html.twig',
            array('form' => $form->createView(),
                'errors'=>$errors)
        );
    }




}
