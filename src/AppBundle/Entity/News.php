<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/13/17
 * Time: 1:16 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\NewsRepository")
 * @ORM\Table(name="news")
 * @UniqueEntity(fields="name", message="This category name is already in use")
 */
class News
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="short_description", type="string", length = 140)
     */
    private $shortDescription;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;



    /**
     * @ORM\Column(name="views", type="integer")
     */
    private $numberOfViews;

    /**
     * @ManyToMany(targetEntity="Category", mappedBy="news")
     */
    private $parentCategories;

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
     * Set name
     *
     * @param string $name
     *
     * @return News
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
     * Set description
     *
     * @param string $description
     *
     * @return News
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return News
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return News
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set numberOfViews
     *
     * @param integer $numberOfViews
     *
     * @return News
     */
    public function setNumberOfViews($numberOfViews)
    {
        $this->numberOfViews = $numberOfViews;

        return $this;
    }

    /**
     * Get numberOfViews
     *
     * @return integer
     */
    public function getNumberOfViews()
    {
        return $this->numberOfViews;
    }




    public function setSimilarNews($similarNews)
    {
        $this->similarNews = $similarNews;

        return $this;
    }

    /**
     * Get similarNews
     *
     * @return array
     */
    public function getSimilarNews()
    {
        return $this->similarNews;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parentCategories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add parentCategory
     *
     * @param \AppBundle\Entity\Category $parentCategory
     *
     * @return News
     */
    public function addParentCategory(\AppBundle\Entity\Category $parentCategory)
    {
        $this->parentCategories[] = $parentCategory;

        return $this;
    }

    /**
     * Remove parentCategory
     *
     * @param \AppBundle\Entity\Category $parentCategory
     */
    public function removeParentCategory(\AppBundle\Entity\Category $parentCategory)
    {
        $this->parentCategories->removeElement($parentCategory);
    }

    /**
     * Get parentCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParentCategories()
    {
        return $this->parentCategories;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return News
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }
}
