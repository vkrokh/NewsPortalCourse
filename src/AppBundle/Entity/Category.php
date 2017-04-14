<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/12/17
 * Time: 12:20 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CategoryRepository")
 * @ORM\Table(name="category")
 * @UniqueEntity(fields="name", message="This category name is already in use")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name" ,type="string", length=32)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subCategory")
     * @ORM\JoinColumn(name="parentCategory", referencedColumnName="id")
     */
    private $parentCategory;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parentCategory")
     */
    private $subCategory;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @param mixed $parentCategory
     */
    public function setParentCategory($parentCategory)
    {
        $this->parentCategory = $parentCategory;
    }

    public function addSubCategory(Category $category)
    {
        array_push($this->subCategory, $category->getName());
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subCategory = new ArrayCollection();
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
     * Remove subCategory
     *
     * @param \AppBundle\Entity\Category $subCategory
     */
    public function removeSubCategory(\AppBundle\Entity\Category $subCategory)
    {
        $this->subCategory->removeElement($subCategory);
    }

    /**
     * Get subCategory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }
}
