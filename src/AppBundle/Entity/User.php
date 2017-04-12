<?php
/**
 * Created by PhpStorm.
 * User: pralolik
 * Date: 11/04/17
 * Time: 23:17
 */

namespace AppBundle\Entity;


use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="This email address is already in use")
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="email",type="string", length=255, unique=true)
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Length(max=16, min=4, minMessage = "Name can not be shorter than 4 characters.",
     *     maxMessage = "Name can not be longer than 16 characters.")
     */
    protected $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;

    /**
     * @ORM\Column(name="password",type="string", length=64)
     */
    protected $password;

    /**
     * @Assert\Length(max=4096, min=6, minMessage = "Password can not be shorter than 6 characters.")
     */
    protected $plainPassword;



    public function isAccountNonExpired()
    {
        return $this->enabled;
    }


    public function isAccountNonLocked()
    {
        return $this->enabled;
    }


    public function isCredentialsNonExpired()
    {
        return $this->enabled;
    }


    public function isEnabled()
    {
        return $this->enabled;
    }


    public function getRoles()
    {
        return $this->roles;
    }


    public function getPassword()
    {
       return $this->password;
    }


    public function getSalt()
    {
        return null;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getUsername()
    {
        return $this->email;
    }


    public function eraseCredentials()
    {
        return $this->enabled;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set roles
     *
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = [$roles];

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
