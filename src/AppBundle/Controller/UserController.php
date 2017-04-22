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
        return new Response('', 200);
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
