<?php
/**
 * Created by PhpStorm.
 * User: vkrokh
 * Date: 4/13/17
 * Time: 1:16 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\NewsRepository")
 * @ORM\Table(name="news")
 * @UniqueEntity(fields="name", message="This news name is already in use")
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
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="views", type="integer")
     */
    private $numberOfViews = 0;

    /**
     * @ManyToMany(targetEntity="Category", mappedBy="news")
     */
    private $parentCategories;

    /**
     * @ORM\Column(name="user_name", type="string" , length = 255)
     */
    private $user;


    /**
     * @ManyToMany(targetEntity="News")
     * @JoinTable(name="news_similar",
     *      joinColumns={@JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="similar_id", referencedColumnName="id")}
     *      )
     * @Assert\Count(max = 5,
     * maxMessage = "You cannot specify more than {{ limit }} news")
     */
    private $similarNews;



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
        if($this->createdAt)
            return $this->createdAt->format('Y-m-d H:i:s');
        return null;
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


    public function setParentCategories($parentCategory)
    {
        $this->parentCategories[] = $parentCategory;

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


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parentCategories = new ArrayCollection();
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
     * Set user
     *
     * @param string $user
     *
     * @return News
     */
    public function setUser(string $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }




    /**
     * Add similarNews
     *
     * @param \AppBundle\Entity\News $similarNews
     *
     * @return News
     */
    public function addSimilarNews(\AppBundle\Entity\News $similarNews)
    {
        $this->similarNews[] = $similarNews;

        return $this;
    }

    /**
     * Remove similarNews
     *
     * @param \AppBundle\Entity\News $similarNews
     */
    public function removeSimilarNews(\AppBundle\Entity\News $similarNews)
    {
        $this->similarNews->removeElement($similarNews);
    }

    /**
     * Get similarNews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSimilarNews()
    {
        return $this->similarNews;
    }
}
