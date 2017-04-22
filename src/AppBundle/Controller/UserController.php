<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\EditType;
use AppBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * @Route("/", name="user_profile")
     */
    public function profilePageAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('user/profile.html.twig', ['user' => $user]);
    }


    /**
     * @Route("/dispatch", name="user_dispatch")
     */
    public function dispatchChangeAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $this->get('app.security.activator')->dispatching($user);
        return $this->redirect($this->generateUrl('user_profile'));
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
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'user/edit.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors
            )
        );
    }


}
