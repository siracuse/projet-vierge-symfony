<?php

namespace RealisationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageRealisation
 *
 * @ORM\Table(name="image_realisation")
 * @ORM\Entity(repositoryClass="RealisationBundle\Repository\ImageRealisationRepository")
 */
class ImageRealisation
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="RealisationBundle\Entity\Realisation", inversedBy="images")
     * @ORM\JoinColumn(name="realisation_id", referencedColumnName="id")
     */
    private $realisation;


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
     * Set name
     *
     * @param string $name
     *
     * @return ImageRealisation
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
     * @return mixed
     */
    public function getRealisation()
    {
        return $this->realisation;
    }

    /**
     * @param mixed $realisation
     */
    public function setRealisation($realisation)
    {
        $this->realisation = $realisation;
    }
}
