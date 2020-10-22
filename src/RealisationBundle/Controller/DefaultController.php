<?php

namespace RealisationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route ("/realisations", name="realisations")
     */
    public function realisationsAction()
    {
        $realisations = $this->getDoctrine()->getManager()->getRepository('RealisationBundle:Realisation')->findAll();

        return $this->render('front/realisations.html.twig', ['realisations' => $realisations]);
    }

    /**
     * @Route ("/realisation/{slug}-{id}", name="realisation-fiche", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function realisationFicheAction($slug, $id)
    {
        $realisation = $this->getDoctrine()->getManager()->getRepository('RealisationBundle:Realisation')->find($id);
        if ($realisation->getSlug() !== $slug) {
            return $this->redirectToRoute('realisation-fiche', [
                'id' => $realisation->getId(),
                'slug' => $realisation->getSlug()
            ], 301);
        }
        return $this->render('front/realisation-fiche.html.twig', compact('realisation'));
    }
}