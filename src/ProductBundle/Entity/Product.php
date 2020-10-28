<?php

namespace ProductBundle\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ProductBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @ORM\Column(name="date_at", type="datetime")
     */
    private $dateAt;

    /**
     * @ORM\Column(name="solde", type="integer", nullable=true)
     */
    private $solde;

    /**
     * @ORM\OneToMany(targetEntity="ProductBundle\Entity\ImageProduct", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="ProductBundle\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return (new Slugify())->slugify($this->name);
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDateAt()
    {
        return $this->dateAt;
    }

    /**
     * @param mixed $dateAt
     */
    public function setDateAt($dateAt)
    {
        $this->dateAt = $dateAt;
    }

    /**
     * @return mixed
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param mixed $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateAt = new \DateTime();
    }

    /**
     * Add image.
     *
     * @param \ProductBundle\Entity\ImageProduct $image
     *
     * @return Product
     */
    public function addImage(\ProductBundle\Entity\ImageProduct $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image.
     *
     * @param \ProductBundle\Entity\ImageProduct $image
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeImage(\ProductBundle\Entity\ImageProduct $image)
    {
        return $this->images->removeElement($image);
    }

    /**
     * Get images.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set category.
     *
     * @param \ProductBundle\Entity\Category|null $category
     *
     * @return Product
     */
    public function setCategory(\ProductBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return \ProductBundle\Entity\Category|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function newProd()
    {
        if (new \DateTime() <= $this->getDateAt()->add(new \DateInterval('P30D'))){
            return true;
        } else {
            return false;
        }
    }

    public function getNewPrice()
    {
        return round(($this->getPrice() * (1-($this->getSolde() / 100 ))), 2);
    }


}
