<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 28/04/17
 * Time: 17:01
 */

namespace AppBundle\Utils;


use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserUtils
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getUserById(int $userId)
    {
        $doctrine = $this->container->get('doctrine');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        return $userRepository->findOneById($userId);
    }


    public function deleteUser(int $userId)
    {
        $doctrine = $this->container->get('doctrine');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $userRepository->deleteUserFromDataBase($userId);
    }

    public function saveUser(User $user)
    {
        $doctrine = $this->container->get('doctrine');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $userRepository->sendToDataBase($user);
    }

}