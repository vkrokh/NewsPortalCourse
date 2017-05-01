<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{
    /**
     * @Route("/{_locale}/",name="homepage")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('category');
    }
}
