<?php

namespace HomeBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class CreatePicture
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createPicture($image, $typeImage, $imageName)
    {
        $pictureSafeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $imageName);
        $pictureNewFilename = $pictureSafeFilename . '-' . uniqid() . '.' . $image->guessExtension();
        $image->move($this->container->getParameter('image_' . $typeImage), $pictureNewFilename);
        return $pictureNewFilename;
    }
}