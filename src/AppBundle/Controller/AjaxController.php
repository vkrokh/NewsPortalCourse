<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/ajax")
 */
class AjaxController extends Controller
{

    /**
     * @Route("/news",name = "ajax_news")
     */
    public function ajaxNewsAction(Request $request)
    {
        $response = $this->get('app.ajax.json')->getJsonResponseNews($request);
        return $response;
    }

    /**
     * @Route("/category",name = "ajax_category")
     */
    public function ajaxCategoryAction(Request $request)
    {
        $response = $this->get('app.ajax.json')->getJsonResponseCategory($request);
        return $response;
    }

}
