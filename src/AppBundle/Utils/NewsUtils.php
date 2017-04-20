<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/13/17
 * Time: 1:27 PM
 */

namespace AppBundle\Utils;

use AppBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsUtils
{
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function showNews(int $id)
    {
        $doctrine = $this->container->get('doctrine');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        return $newsRepository->getNews($id);
    }

    public function getAllNews(string $category)
    {
        $doctrine = $this->container->get('doctrine');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        return $newsRepository->getAllNews($category);
    }

}