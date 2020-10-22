<?php

namespace RealisationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Cocur\Slugify\Slugify;

/**
 * Realisation
 *
 * @ORM\Table(name="realisation")
 * @ORM\Entity(repositoryClass="RealisationBundle\Repository\RealisationRepository")
 */
class Realisation
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
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 255,
     * )
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 10000,
     * )
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\OneToMany(targetEntity="RealisationBundle\Entity\ImageRealisation", mappedBy="realisation", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Realisation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return (new Slugify())->slugify($this->title);
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Realisation
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
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Realisation
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Realisation constructor.
     */
    public function __construct()
    {
        $this->dateCreate = new \DateTime();
        $this->images = new ArrayCollection();
    }

    /**
     * Add image
     *
     * @param \RealisationBundle\Entity\ImageRealisation $image
     *
     * @return Realisation
     */
    public function addImage(\RealisationBundle\Entity\ImageRealisation $image)
    {
        $this->images[] = $image;
        $image->setRealisation($this);

        return $this;
    }

    /**
     * Remove image
     *
     * @param \RealisationBundle\Entity\ImageRealisation $image
     */
    public function removeImage(\RealisationBundle\Entity\ImageRealisation $image)
    {
        $this->images->removeElement($image);
        if ($image->getRealisation() === $this) {
            $image->setRealisation(null);
        }
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
