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
        foreach ($category->getSubCategory() as $subCategory){
            $menu->addChild($subCategory->getName(), array(
                'route' => 'category',
                'routeParameters' => array('category_id' => $subCategory->getId())
            ))
                ->setAttribute('class', 'dropdown')
            ->setChildrenAttribute('class', 'dropdown-menu');
            $this->abc($menu, $subCategory);
        }
        return $menu;
    }

    public function abc($menu, Category $category)
    {

        var_dump($category);
        foreach ($category->getSubCategory() as $subCategory) {
            $menu[$category->getName()]->addChild($subCategory->getName(), array(
                'route' => 'category',
                'routeParameters' => array('category_id' => $subCategory->getId())
            ))
                ->setAttribute('divider_append', true);
            $this->abc($menu, $subCategory);
        }
    }


}