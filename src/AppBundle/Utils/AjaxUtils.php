<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 28/04/17
 * Time: 11:28
 */

namespace AppBundle\Utils;


use AppBundle\Entity\NewsRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxUtils
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getJsonResponseNews(Request $request)
    {
        $doctrine = $this->container->get('doctrine');
        $page = $request->get('page');
        $perpage = $request->get('perpage');
        $newsRepository = $doctrine->getRepository('AppBundle:News');
        if ($request->get('sortbyfield')) {
            $news = $this->sortField($newsRepository, $request->get('sortbyfield'), $request->get('order'));
        } elseif ($request->get('filterbyfield')) {
            $news = $this->filterField($newsRepository, $request->get('filterbyfield'), $request->get('pattern'));
        } else {
            $news = $newsRepository->findAll();
        }

        return $this->jsonCreateNews($news, $page, $perpage);

    }

    public function getJsonResponseCategory(Request $request)
    {
        $doctrine = $this->container->get('doctrine');
        $page = $request->get('page');
        $perpage = $request->get('perpage');
        $categoryRepository = $doctrine->getRepository('AppBundle:Category');
        if ($request->get('sortbyfield')) {
            $categories = $this->sortField($categoryRepository, $request->get('sortbyfield'), $request->get('order'));
        } elseif ($request->get('filterbyfield')) {
            $categories = $this->filterField($categoryRepository, $request->get('filterbyfield'), $request->get('pattern'));
        } else {
            $categories = $categoryRepository->findAll();
        }

        return $this->jsonCreateCategory($categories, $page, $perpage);
    }

    public function getJsonResponseUsers(Request $request)
    {
        $doctrine = $this->container->get('doctrine');
        $page = $request->get('page');
        $perpage = $request->get('perpage');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        if ($request->get('sortbyfield')) {
            $users = $this->sortField($userRepository, $request->get('sortbyfield'), $request->get('order'));
        } elseif ($request->get('filterbyfield')) {
            $users = $this->filterField($userRepository, $request->get('filterbyfield'), $request->get('pattern'));
        } else {
            $users = $userRepository->findAll();
        }

        return $this->jsonCreateUser($users, $page, $perpage);
    }


    private function jsonCreateCategory(Array $categories, int $page, int $perpage)
    {
        $response = array();
        if (isset($categories)) {
            $count = count($categories);
            $categories = array_slice($categories, ($page - 1) * $perpage, $perpage);
            foreach ($categories as $category) {
                if(!$category->getParentCategory()){
                    continue;
                }
                $response[] = array(
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'parentCategory' => $category->getParentCategory()->getName(),
                );
            }
        }
        return new JsonResponse(array('category' => $response, 'count' => $count));
    }


    private function jsonCreateUser(Array $users, int $page, int $perpage)
    {
        $response = array();
        if (isset($users)) {
            $count = count($users);
            $users = array_slice($users, ($page - 1) * $perpage, $perpage);
            foreach ($users as $user) {
                $response[] = array(
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'enabled' => $user->getEnabled(),
                    'dispatch' => $user->getDispatch(),
                    'roles' => $user->getRoles()
                );
            }
        }
        return new JsonResponse(array('user' => $response, 'count' => $count));
    }

    private function jsonCreateNews(Array $news, int $page, int $perpage)
    {
        $response = array();
        if (isset($news)) {
            $count = count($news);
            $news = array_slice($news, ($page - 1) * $perpage, $perpage);
            foreach ($news as $oneNews) {
                $response[] = array(
                    'id' => $oneNews->getId(),
                    'name' => $oneNews->getName(),
                    'description' => mb_substr($oneNews->getDescription(), 0, 100) . '...',
                    'createdAt' => $oneNews->getCreatedAt(),
                    'user' => $oneNews->getUser(),
                    'numberOfViews' => $oneNews->getNumberOfViews(),
                );
            }
        }
        return new JsonResponse(array('news' => $response, 'count' => $count));
    }

    private function sortField($repository, string $sortField, string $order)
    {
        return $repository->createQueryBuilder('n')
            ->orderBy('n.' . $sortField, $order)
            ->getQuery()->getResult();
    }


    private function filterField($repository, string $filterField, string $pattern)
    {
        if ($filterField == 'createdAt') {
            $date = date_create($pattern);
            if ($date) {
                return $news = $repository->createQueryBuilder('p')
                    ->where('p.' . $filterField . ' >= :pattern')
                    ->setParameter('pattern', date_format($date, 'Y-m-d H:i:s'))
                    ->getQuery()->getResult();
            }
        } else {
            return $news = $repository->createQueryBuilder('p')
                ->where('p.' . $filterField . ' LIKE :pattern')
                ->setParameter('pattern', '%' . $pattern . '%')
                ->getQuery()->getResult();
        }
    }

}