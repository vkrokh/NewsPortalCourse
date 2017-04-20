<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/16/17
 * Time: 8:03 PM
 */

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NewsControler extends Controller
{
    /**
     * @Route("/news/{newsname}", name="news")
     */
    public function showNews(int $newsname)
    {
        $showCategoryService = $this->get('app.security.shownews');
        $news = $showCategoryService->showNews($newsname);
        return $this->render('news/news.html.twig', array('news' => $news));
    }

}