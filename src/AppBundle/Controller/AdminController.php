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
 * @Route("/{_locale}/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/category", name="admin_category")
     */
    public function adminPageCategoryAction(Request $request)
    {
        return $this->render('admin/adminCategory.html.twig');
    }
    /**
     * @Route("/news", name="admin_news")
     */
    public function adminPageNewsAction(Request $request)
    {

        return $this->render('admin/adminNews.html.twig');
    }
    /**
     * @Route("/user", name="admin_users")
     */
    public function adminPageUsersAction(Request $request)
    {
        return $this->render('admin/adminUsers.html.twig');
    }

}