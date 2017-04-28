<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/16/17
 * Time: 8:03 PM
 */

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/{_locale}/news")
 */
class NewsControler extends Controller
{
    /**
     * @Route("/{newsId}", name="news")
     */
    public function showNews(int $newsId, Request $request)
    {
        $showNewsService = $this->get('app.security.shownews');
        $news = $showNewsService->showNews($newsId);
        $similarNews = $showNewsService->getSimilar($news->getSimilarNewsId());
        $lastPage = $request->headers->get('referer');//TODO: no last page
        return $this->render('news/news.html.twig', array('news' => $news,'similar'=>$similarNews, 'lastPage'=>$lastPage));
    }

}