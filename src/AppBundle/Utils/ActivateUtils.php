<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 12/04/17
 * Time: 00:38
 */

namespace AppBundle\Utils;


use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ActivateUtils
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function dispatching(User $user)
    {
        $userRepository = $this->getRepository('AppBundle:User');
        $user->setDispatch(!($user->getDispatch()));
        $userRepository->sendToDataBase($user);
    }

    public function activation(string $token)
    {
        $tokenRepository = $this->getRepository('AppBundle:Token');
        return $tokenRepository->activateUserByToken($token);
    }

    public function getRepository(string $repository)
    {
        $doctrine = $this->container->get('doctrine');
        return $doctrine->getRepository($repository);
    }


}