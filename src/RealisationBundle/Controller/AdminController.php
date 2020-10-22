<?php

namespace RealisationBundle\Controller;

use RealisationBundle\Entity\ImageRealisation;
use RealisationBundle\Entity\Realisation;
use RealisationBundle\Form\RealisationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin/realisations")
 */
class AdminController extends Controller
{
    /**
     * @Route ("/", name="admin-realisations-index")
     */
    public function indexAction()
    {
        $realisations = $this->getDoctrine()->getManager()->getRepository('RealisationBundle:Realisation')->findAll();
        return $this->render('back/realisation/index.html.twig', compact('realisations'));
    }

    /**
     * @Route ("/new", name="admin-realisations-new")
     */
    public function newAction(Request $request)
    {
        $realisation = new Realisation();
        $form = $this->createForm(RealisationType::class, $realisation);
        $createPicture = $this->get('home.createpicture');
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($realisation);
            $files = $request->files->get('realisationbundle_realisation')['images'];
            if($files) {
                foreach ($files as $file) {
                    $imageRea = new ImageRealisation();
                    $imageRea->setName($createPicture->createPicture($file, 'realisations', $realisation->getSlug()));
                    $imageRea->setRealisation($realisation);
                    $em->persist($imageRea);
                }
            } else {
                $this->addFlash('warning', "Veuillez remplir le champ 'Images'");
                return $this->redirectToRoute('admin-realisations-new');
            }
            $em->flush();
            $this->addFlash('success', 'Votre réalisation a bien été ajoutée');
            return $this->redirectToRoute('admin-realisations-index');
        }
        return $this->render('back/realisation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/edit/{id}", name="admin-realisations-edit")
     */
    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $createPicture = $this->get('home.createpicture');
        $realisation = $em->getRepository('RealisationBundle:Realisation')->find($id);

        $form = $this->createForm(RealisationType::class, $realisation);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $files = $request->files->get('realisationbundle_realisation')['images'];
            if ($files) {
                foreach ($files as $file) {
                    $imageRea = new ImageRealisation();
                    $imageRea->setName($createPicture->createPicture($file, 'realisations', $realisation->getSlug()));
                    $imageRea->setRealisation($realisation);
                    $em->persist($imageRea);
                }
            }
            $em->flush();
            $this->addFlash('success', 'Votre réalisation a bien été modifiée');
            return $this->redirectToRoute('admin-realisations-index');
        }
        return $this->render('back/realisation/edit.html.twig', [
            'form' => $form->createView(),
            'realisation' => $realisation
        ]);
    }

    /**
     * @Route ("/delete/{id}", name="admin-realisations-delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $realisation = $em->getRepository('RealisationBundle:Realisation')->find($id);

        if(!$realisation) {
            $this->addFlash('warning', 'Cette réalisation n\'existe pas');
        } else {
            $images = $realisation->getImages();
            foreach ($images as $image) {
                unlink($this->getParameter('image_realisations') .'/'.  $image->getName());
            }
            $em->remove($realisation);
            $em->flush();
            $this->addFlash('success', 'Votre realisation a bien été supprimée');
        }
        return $this->redirectToRoute('admin-realisations-index');
    }

    /**
     * @Route ("/image/delete/{id},{realisationId}", name="admin-realisation-image-delete")
     */
    public function imageDeleteAction($id,$realisationId)
    {
        $em = $this->getDoctrine()->getManager();
        $imageRealisation = $em->getRepository('RealisationBundle:ImageRealisation')->find($id);
        $realisation = $em->getRepository('RealisationBundle:Realisation')->find($realisationId);
        if ($imageRealisation !== null && $realisation !== null) {
            $realisation->removeImage($imageRealisation);
            $em->persist($realisation);
            $em->flush();
            unlink($this->getParameter('image_realisations') .'/'. $imageRealisation->getName());
        } else {
            $this->addFlash('warning', 'Cette image n\'existe pas !');
        }
        return $this->redirectToRoute('admin-realisations-edit', ['id' => $realisationId]);
    }
}