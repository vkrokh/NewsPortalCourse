<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/12/17
 * Time: 1:19 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    /**
     * @Route("/category/{categoryName}", name="category")
     */
    public function showCategory(string $categoryName)
    {
        $showCategoryService = $this->get('app.security.showcategory');
        $test = $showCategoryService->showCategory($categoryName);
        //var_dump($test->getNews());
        foreach ($test->getNews() as $news){
            var_dump($news->getName());
        }
        return new Response();
    }

    /**
     * @Route("/news/{id}", name="news")
     */
    public function showNews(string $id)
    {
        $showCategoryService = $this->get('app.security.shownews');
        $test = $showCategoryService->showNews($id);
        return new Response('<b>' . $test->getName() . '</b><br>' . $test->getDescription());
    }


}