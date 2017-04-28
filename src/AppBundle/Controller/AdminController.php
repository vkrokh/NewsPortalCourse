<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 22/04/17
 * Time: 17:22
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

/**
 * @Route("/admin/{_locale}")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_page")
     */
    public function adminPageAction(Request $request)
    {
       var_dump($request->headers->get('referer'));
        return $this->render('admin/adminPageView.html.twig');
    }

}