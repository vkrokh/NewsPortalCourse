<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/12/17
 * Time: 1:19 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/{_locale}/category")
 */
class CategoryController extends Controller
{

    /**
     * @Route("/edit/{categoryId}/", name="category_edit")
     */
    public function editCategory(Request $request, int $categoryId)
    {
        $categoryService = $this->get('app.security.showcategory');
        $category = $categoryService->getCategory($categoryId);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryService->addCategory($category);
            return $this->redirect($this->generateUrl('admin_category'));
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'category/categoryCreate.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors,
                'id' => $categoryId
            )
        );
    }


    /**
     * @Route("/delete/{categoryId}/", name="category_delete")
     */
    public function deleteCategory(int $categoryId)
    {
        $categoryService = $this->get('app.security.showcategory');
        $categoryService->deleteCategory($categoryId);
        return $this->redirect($this->generateUrl('admin_category'));
    }

    /**
     * @Route("/create/", name="category_create")
     */
    public function createCategory(Request $request)
    {
        $categoryService = $this->get('app.security.showcategory');
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryService->addCategory($category);
            return $this->redirect($this->generateUrl('admin_category'));
        }
        $errors = (string)$form->getErrors(true);
        return $this->render(
            'category/categoryCreate.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $errors,
                'id' => ''
            )
        );
    }


    /**
     * @Route("/{categoryId}/{page}/{sortField}/{sortType}", name="category")
     */
    public function showCategory(
        int $categoryId = 1,
        int $page = 1,
        string $sortField = 'date',
        string $sortType = 'DESC'
    ) {
        $categoryService = $this->get('app.security.showcategory');
        $news = $categoryService->showCategory($categoryId, $sortField, $sortType);
        $category = $categoryService->getCategory($categoryId);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($news, $page, 5
        );
        return $this->render(':category:subcategory.html.twig',
            array('news' => $pagination, 'category' => $category));
    }


}