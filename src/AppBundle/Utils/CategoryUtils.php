<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/12/17
 * Time: 1:22 PM
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CategoryUtils
{
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function addCategory(Category $category)
    {
        $doctrine = $this->container->get('doctrine');
        $categoryRepository = $doctrine->getRepository('AppBundle:Category');
        $categoryRepository->sendToDataBase($category);
    }

    public function showCategory(int $category)
    {
        $doctrine = $this->container->get('doctrine');
        $categoryRepository = $doctrine->getRepository('AppBundle:Category');
        return $categoryRepository->getCategoryNews($category);
    }

    public function getCategory(int $id)
    {
        $doctrine = $this->container->get('doctrine');
        $categoryRepository = $doctrine->getRepository('AppBundle:Category');
        return $categoryRepository->getCategory($id);
    }


}