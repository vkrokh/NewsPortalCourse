<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 22/04/17
 * Time: 17:24
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserRecovery;
use AppBundle\Form\RecoveryType;
use AppBundle\Form\RecoveryViewType;
use AppBundle\Form\EditType;
use AppBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/{_locale}")
 */
class SecurityController extends Controller
{

    /**
     * @Route("/login", name="user_login")
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('category');
        }
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(
            'user/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('category');
        }
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registerService = $this->get('app.security.register');
            $registerService->registerUser($user);
            $this->addFlash('message', $this->get('translator')->trans('mail.check'));
            return $this->redirectToRoute('user_login');
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'user/register.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors
            )
        );
    }

    /**
     * @Route("/activate/{token}", name="user_activate")
     */
    public function activateAction(string $token)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('category');
        }
        $activateService = $this->get('app.security.activator');
        if ($activateService->activation($token)) {
            $this->addFlash('message', $this->get('translator')->trans('successful.activation'));
        } else {
            $this->addFlash('message', $this->get('translator')->trans('failed.activation'));
        }
        return $this->redirect($this->generateUrl('user_login'));
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/restore", name="user_restore_view")
     */
    public function recoveryViewAction(Request $request)
    {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('category');
        }
        $user = new UserRecovery();
        $form = $this->createForm(RecoveryViewType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restoreService = $this->get('app.security.restore');
            if ($restoreService->isEmailExist($user->getEmail())) {
                $this->addFlash('message', $this->get('translator')->trans('mail.check'));
                return $this->redirectToRoute('user_login');
            }
            $this->addFlash('message', $this->get('translator')->trans('account.lock'));
            return $this->render(
                'user/restoreEmailView.html.twig',
                array(
                    'form' => $form->createView(),
                    'errors' => ''
                )
            );
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'user/restoreEmailView.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors
            )
        );
    }

    /**
     * @Route("/restore/{token}", name="user_restore")
     */
    public function recoveryAction(Request $request, string $token)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('category');
        }
        $user = new UserRecovery();
        $restoreService = $this->get('app.security.restore');
        if ($fullyToken = $restoreService->checkTokenInDataBase($token)) {
            $form = $this->createForm(RecoveryType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $restoreService->recoveryPassword(
                    $user->getPlainPassword(),
                    $fullyToken
                );
                $this->addFlash('message', $this->get('translator')->trans('new.password'));
                return $this->redirectToRoute('user_login');
            }
            $errors = (string)$form->getErrors(true);
            return $this->render(
                'user/restorePasswordView.html.twig',
                array(
                    'form' => $form->createView(),
                    'errors' => $errors
                )
            );
        }
        $this->addFlash('message', $this->get('translator')->trans('Token too old'));
        return $this->redirectToRoute('user_login');
    }

}