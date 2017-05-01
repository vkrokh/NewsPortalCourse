<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/13/17
 * Time: 1:27 PM
 */

namespace AppBundle\Utils;

use AppBundle\Entity\Category;
use AppBundle\Entity\News;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsUtils
{
    private $container;
    private $repository;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $doctrine = $this->container->get('doctrine');
        $this->repository = $doctrine->getRepository('AppBundle:News');
    }

    public function saveNews(News $news)
    {
        $this->repository->sendToDataBase($news);
    }

    public function deleteNews(int $id)
    {
        $this->repository->deleteNewsFromDataBase($id);
    }

    public function showNews(int $id)
    {
        $news = $this->repository->getNews($id);
        return $news;
    }

    public function getAllNews(string $category)
    {
        return $this->repository->getAllNews($category);
    }

}