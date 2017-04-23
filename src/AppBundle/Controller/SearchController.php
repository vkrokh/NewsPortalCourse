<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 23/04/17
 * Time: 03:43
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

/**
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * @Route("{page}", name="search_page")
     */
    public function adminPageAction(Request $request, int $page = 1)
    {
        $finder = $this->get
        ('fos_elastica.finder.app.news');
        $news = $finder->find($request->get('query'));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($news, $page, 5
        );
        return $this->render(':search:search.html.twig',
            array('news' => $pagination));
    }
}