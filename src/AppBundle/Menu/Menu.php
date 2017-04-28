<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/26/17
 * Time: 12:44 PM
 */

namespace AppBundle\Menu;

use AppBundle\Entity\Category;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;


class Menu implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $categoryRepository = $this->container->get('doctrine')->getManager()->getRepository('AppBundle:Category');
        $category = $categoryRepository->find(1);
        $menu->setChildrenAttribute('class', 'nav');
        foreach ($category->getSubCategory() as $subCategory) {
            $nextLevelMenu = $menu->addChild($subCategory->getName(), array(
                'route' => 'category',
                'routeParameters' => array('categoryId' => $subCategory->getId())
            ))
                ->setAttribute('class', 'dropdown')
                ->setChildrenAttribute('class', 'dropdown-menu');
            $this->addDropdownItems($nextLevelMenu, $subCategory);
        }
        $this->addProfileMenu($menu);
        return $menu;
    }

    public function addProfileMenu($menu)
    {
        $menu->addChild('profile', array(
            'route' => 'user_profile'
        ))
            ->setAttribute('class', 'dropdown')
            ->setChildrenAttribute('class', 'dropdown-menu');
        $menu['profile']->addChild('logout', array(
            'route' => 'user_logout'
        ));
    }

    public function addDropdownItems($menu, Category $category)
    {
        foreach ($category->getSubCategory() as $subCategory) {
            $newMenu = $menu->addChild($subCategory->getName(), array(
                'route' => 'category',
                'routeParameters' => array('categoryId' => $subCategory->getId())
            ))->setAttribute('class', 'dropdown')
                ->setChildrenAttribute('class', 'dropdown-submenu');

            $this->abc($newMenu, $subCategory);
        }
    }


}