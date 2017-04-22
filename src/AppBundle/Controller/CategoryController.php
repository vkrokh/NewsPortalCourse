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
     * @Route("/category/{categoryId}/{page}", name="category")
     */
    public function showCategory(int $categoryId = 1, int $page = 1)
    {
        $categoryService = $this->get('app.security.showcategory');
        $news = $categoryService->showCategory($categoryId);
        $category = $categoryService->getCategory($categoryId);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($news, $page, 5
        );
        return $this->render(':category:subcategory.html.twig',
            array('news' => $pagination, 'category' => $category->getSubCategory()));
    }


}