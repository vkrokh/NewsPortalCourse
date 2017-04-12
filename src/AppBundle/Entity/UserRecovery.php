<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 12/04/17
 * Time: 12:28
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class UserRecovery
{
    /**
     * @Assert\Email()
     */
    protected $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @Assert\Length(max=4096, min=6, minMessage = "Password can not be shorter than 6 characters.")
     */
    protected $plainPassword;

}