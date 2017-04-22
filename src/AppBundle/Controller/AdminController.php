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
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_page")
     */
    public function adminPageAction()
    {
        return new Response('', 200);
    }

}