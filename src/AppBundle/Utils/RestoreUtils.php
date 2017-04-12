<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 12/04/17
 * Time: 12:35
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Token;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RestoreUtils
{

    private $container;
    private $mailer;
    private $tokenGenerator;
    private $render;
    private $router;

    public function __construct(ContainerInterface $container,TokenGeneratorUtils $tokenGenerator, \Swift_Mailer $mailer, TwigEngine $render, Router $router)
    {
        $this->container = $container;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->render = $render;
        $this->router = $router;
    }


    public function isEmailExist(string $email)
    {
        $doctrine = $this->container->get('doctrine');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $userArray = $userRepository->findUserByEmail($email);
        if(count($userArray)!= 0){
            $this->createToken($userArray[0]);
            return true;
        }
        return null;
    }

    private function createToken(User $user)
    {
        $token = new Token();
        $token->setToken($this->tokenGenerator->generateToken());
        $token->setUser($user);
        $token->setDate(date_create(date('Y-m-d H:i:s')));
        $this->sendTokenToDataBase($token);
        $this->sendEmailToUser($user->getEmail(),$token->getToken());
    }

    private function sendEmailToUser(string $userEmail,string $token)
    {
        $message = \Swift_Message::newInstance(null)
            ->setSubject('Recovery Password')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($userEmail)
            ->setBody(
                $this->render->render('user/recoveryMail.html.twig',
                    array('url'=>$this->router->generate('user_recovery',array('token'=>$token),UrlGeneratorInterface::ABSOLUTE_PATH))
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