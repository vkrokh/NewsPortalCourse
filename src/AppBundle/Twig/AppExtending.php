<?php

namespace AppBundle\Twig;

use \Twig_Extension;
use \Twig_Filter_Method;
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/17/17
 * Time: 4:21 PM
 */
class AppExtending extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('descriptionFilter', [$this, 'clipDescription']),
        );
    }

    public function clipDescription(string $text)
    {
        return substr($text, 0, 240) . '...';
    }


}