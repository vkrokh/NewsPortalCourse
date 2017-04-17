<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 11/04/17
 * Time: 23:47
 */

namespace AppBundle\Utils;


class TokenGeneratorUtils
{
    public function generateToken()
    {
        $length = 16;
        $token = bin2hex(random_bytes($length));
        return $token;
    }
}