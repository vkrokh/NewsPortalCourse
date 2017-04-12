<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 11/04/17
 * Time: 23:47
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Token;
use AppBundle\Entity\User;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationUtils
{
    private $container;
    private $mailer;
    private $tokenGenerator;
    private $render;
    private $router;

    public function __construct(ContainerInterface $container, TokenGeneratorUtils $tokenGenerator, \Swift_Mailer $mailer, TwigEngine $render, Router $router)
    {
        $this->container = $container;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->render = $render;
        $this->router = $router;
    }

    public function registerUser(User $user)
    {
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setEnabled(false);
        $user->setRoles('ROLE_USER');
        $this->sendUserToDataBase($user);
        $this->generateActivateToken($user);
    }

    private function sendUserToDataBase(User $user)
    {
        $doctrine = $this->container->get('doctrine');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $userRepository->sendToDataBase($user);
    }

    private function generateActivateToken(User $user)
    {
        $token = new Token();
        $token->setToken($this->tokenGenerator->generateToken());
        $token->setUser($user);
        $token->setDate(date_create(date('Y-m-d H:i:s')));
        $this->sendTokenToDataBase($token);
        $this->sendEmailToUser($user->getEmail(), $token->getToken());
    }

    private function sendEmailToUser(string $userEmail, string $token)
    {
        $message = \Swift_Message::newInstance(null)
            ->setSubject('Welcome')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($userEmail)
            ->setBody(
                $this->render->render(
                    'user/mail.html.twig',
                    array
                    (
                        'url' => $this->router->generate(
                            'user_activate',
                            array('token' => $token),
                            UrlGeneratorInterface::ABSOLUTE_PATH
                        )
                    )
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    private function sendTokenToDataBase(Token $token)
    {
        $doctrine = $this->container->get('doctrine');
        $userRepository = $doctrine->getRepository('AppBundle:Token');
        $userRepository->sendToDataBase($token);
    }

}