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
     * @Route("/category/{categoryId}", name="category")
     */
    public function showCategory(int $categoryId = 1)
    {
        $categoryService = $this->get('app.security.showcategory');
        $news = $categoryService->showCategory($categoryId);
        $category = $categoryService->getCategory($categoryId);
        return $this->render(':category:subcategory.html.twig', array('news'=> $news, 'category'=>$category->getSubCategory()));
    }



}