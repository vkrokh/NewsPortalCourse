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


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function saveNews(News $news)
    {
        $doctrine = $this->container->get('doctrine');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        $newsRepository->sendToDataBase($news);
    }

    public function deleteNews(int $id)
    {
        $doctrine = $this->container->get('doctrine');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        $newsRepository->deleteNewsFromDataBase($id);
    }

    public function showNews(int $id)
    {
        $doctrine = $this->container->get('doctrine');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        $news = $newsRepository->getNews($id);
        return $news;
    }

    public function getAllNews(string $category)
    {
        $doctrine = $this->container->get('doctrine');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        return $newsRepository->getAllNews($category);
    }

}