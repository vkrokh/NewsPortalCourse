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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository=$em->getRepository('AppBundle:News');
        $page=$request->get('page');
        $perpage=$request->get('perpage');
        $count=0;
        if ($request->get('sortbyfield'))
        {
            $products = $repository->createQueryBuilder('p')
                ->orderBy('p.'.$request->get('sortbyfield'),$request->get('order'))
                ->getQuery()->getResult();
        } elseif ($request->get('filterbyfield')) {
            if (($request->get('filterbyfield') == 'dateOfCreation') || ($request->get('filterbyfield') == 'dateOfLastUpdate')){
                $date = date_create($request->get('pattern'));
                if ($date) {
                    $products = $repository->createQueryBuilder('p')
                        ->where('p.' . $request->get('filterbyfield') . ' >= :pattern')
                        ->setParameter('pattern', date_format($date, 'Y-m-d H:i:s'))
                        ->getQuery()->getResult();
                }
            } else {
                $products = $repository->createQueryBuilder('p')
                    ->where('p.' . $request->get('filterbyfield') . ' LIKE :pattern')
                    ->setParameter('pattern', '%' .$request->get('pattern') . '%')
                    ->getQuery()->getResult();
            }
        } else {
            $products = $repository->findAll();
        }
        $responseProducts = array();
        if (isset($products)) {
            $count=count($products);
            $products=array_slice($products,($page-1)*$perpage,$perpage);
            foreach ($products as $product) {
                $responseProducts[] = array(
                    'id'=>$product->getId(),
                    'name'=>$product->getName(),
                    'description'=>mb_substr($product->getDescription(), 0, 240) . '...',
                    'dateOfCreation'=>$product->getCreatedAt(),
                    'views'=>$product->getNumberOfViews(),
                );
            }
        }
        $response = new JsonResponse(array('news'=>$responseProducts,'count'=>$count));
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8000');
        return $response;
    }

}
