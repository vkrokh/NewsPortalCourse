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
    private $repositoty;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $doctrine = $this->container->get('doctrine');
        $this->userRepository = $doctrine->getRepository('AppBundle:User');
    }

    public function getUserById(int $userId)
    {
        return $this->repositoty->findOneById($userId);
    }


    public function deleteUser(int $userId)
    {
        $this->repositoty->deleteUserFromDataBase($userId);
    }

    public function saveUser(User $user)
    {
        $this->repositoty->sendToDataBase($user);
    }


}