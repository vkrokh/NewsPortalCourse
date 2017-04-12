<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 12/04/17
 * Time: 00:38
 */

namespace AppBundle\Utils;


use Symfony\Component\DependencyInjection\ContainerInterface;

class ActivateUtils
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function activation(string $token)
    {
        $doctrine = $this->container->get('doctrine');
        $tokenRepository = $doctrine->getRepository('AppBundle:Token');
        $tokenRepository->activateUserByToken($token);
    }
}