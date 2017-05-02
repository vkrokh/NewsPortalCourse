<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/16/17
 * Time: 8:03 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
use Doctrine\Common\Collections\ArrayCollection;
use Proxies\__CG__\AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function showNews(int $newsId)
    {
        $showNewsService = $this->get('app.security.shownews');
        $news = $showNewsService->showNews($newsId);
        $similarNews = $news->getSimilarNews();
        return $this->render('news/news.html.twig', array('news' => $news, 'similar' => $similarNews));
    }


    /**
     * @Route("/create/", name="news_create")
     */
    public function createNews(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($news->getParentCategories() as $category) {
                $this->setAllParent($category, $news);
            }
            $news->setCreatedAt(date_create(date('Y-m-d H:i:s')));
            $news->setUser($this->getUser()->getName());
            $this->container->get('app.security.shownews')->saveNews($news);
            return $this->redirect($this->generateUrl('admin_news'));
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'news/newsCreate.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors,
                'id' => ''
            )
        );
    }

    private function setAllParent($category, News $news)
    {
        if (!isset($category)) {
            return;
        }
        if (!in_array($news, $category->getNews()->toArray())) {
            $category->addNews($news);
            $news->addParentCategory($category);
        }
        $this->setAllParent($category->getParentCategory(), $news);
    }


    private function removeOld($category, $news)
    {
        $category->removeNews($news);
        $news->removeParentCategory($category);
    }


    /**
     * @Route("/edit/{newsId}", name="news_edit")
     */
    public function editNews(Request $request, int $newsId)
    {
        $showNewsService = $this->get('app.security.shownews');
        $news = $showNewsService->showNews($newsId);
        $form = $this->createForm(NewsType::class, $news);
        $oldParents = $news->getParentCategories();
        foreach ($oldParents as $old) {
            $this->removeOld($old, $news);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($news->getParentCategories() as $category) {
                $this->setAllParent($category, $news);
            }
            $showNewsService->saveNews($news);
            return $this->redirect($this->generateUrl('admin_news'));
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'news/newsCreate.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors,
                'id' => $newsId
            )
        );
    }

    /**
     * @Route("/delete/{newsId}", name="news_delete")
     */
    public function deleteNews(int $newsId)
    {
        $this->get('app.security.shownews')->deleteNews($newsId);
        return $this->redirect($this->generateUrl('admin_news'));
    }


}