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
    private $repository;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $doctrine = $this->container->get('doctrine');
        $this->repository = $doctrine->getRepository('AppBundle:Category');
    }

    public function deleteCategory(int $categoryId)
    {
        $this->repository->deleteFromDataBase($categoryId);
    }


    public function addCategory(Category $category)
    {
        $this->repository->sendToDataBase($category);
    }

    public function showCategory(int $category, string $sortField, string $sortType)
    {
        return $this->repository->getCategoryNews($category, $sortField, $sortType);
    }

    public function getCategory(int $id)
    {
        return $this->repository->getCategory($id);
    }


}