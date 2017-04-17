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
    public function showCategory(int $categoryName = 1)
    {
        $showCategoryService = $this->get('app.security.showcategory');
        $news = $showCategoryService->showCategory($categoryName);
        return $this->render(':category:subcategory.html.twig', array('news'=> $news));
    }



}