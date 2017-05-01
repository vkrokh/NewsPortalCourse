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
use Doctrine\Common\Persistence\ObjectRepository;
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

    public function __construct(
        ContainerInterface $container,
        TokenGeneratorUtils $tokenGenerator,
        \Swift_Mailer $mailer,
        TwigEngine $render,
        Router $router
    )
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
        $user = $userRepository->findUserByEmail($email);
        if (isset($user) && $user->isEnabled()) {
            $this->createToken($user);
            return true;
        }
        return null;
    }

    public function checkTokenInDataBase(string $token)
    {
        $doctrine = $this->container->get('doctrine');
        $tokenRepository = $doctrine->getRepository('AppBundle:Token');
        $fullyToken = $tokenRepository->getToken($token);
        if ($tokenRepository->checkToken($fullyToken)) {
            return $fullyToken;
        }
        return null;
    }

    public function recoveryPassword(string $plainPassword, Token $token)
    {
        $encoder = $this->container->get('security.password_encoder');
        $user = $token->getUser();
        $password = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $doctrine = $this->container->get('doctrine');
        $tokenRepository = $doctrine->getRepository('AppBundle:Token');
        $tokenRepository->removeToken($token);
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $userRepository->sendToDataBase($user);

    }


    private function createToken(User $user)
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
            ->setSubject('Recovery Password')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($userEmail)
            ->setBody(
                $this->render->render(
                    'mails/restoreMail.html.twig',
                    array(
                        'url' => $this->router->generate(
                            'user_restore',
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
        $this->getRepository('AppBundle:Token')->sendToDataBase($token);
    }

    public function getRepository(string $repository)
    {
        $doctrine = $this->container->get('doctrine');
        return $doctrine->getRepository($repository);
    }

}