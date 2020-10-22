<?php

namespace SlideBundle\Controller;

use SlideBundle\Entity\Slider;
use SlideBundle\Form\SliderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin/slider")
 */
class DefaultController extends Controller
{
    /**
     * @Route ("/", name="admin-slider-index")
     */
    public function indexAction()
    {
        $sliders = $this->getDoctrine()->getManager()->getRepository('SlideBundle:Slider')->findBy([], ['position' => 'ASC']);
        return $this->render('back/slide/indexSlider.html.twig', compact('sliders'));
    }

    /**
     * @Route ("/ajax/sort", name="admin-slider-ajax-sort")
     */
    public function adminAjaxSortAction(Request $request)
    {
        $item = $request->request->get('tab');

        $em = $this->getDoctrine()->getManager();
        $i = 1;
        foreach ($item as $id) {
            $actu = $em->getRepository('SlideBundle:Slider')->find($id);
            $actu->setPosition($i++);
            $em->flush();
        }
        $response = new Response();
        return $response;
    }

    /**
     * @Route ("/new", name="admin-slider-new")
     */
    public function newAction(Request $request)
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $createPicture = $this->get('home.createpicture');
        $em = $this->getDoctrine()->getManager();
        $positionMax = $em->getRepository('SlideBundle:Slider')->getPositionMax();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $imageFile = $form['picture']->getData();
            if ($imageFile) {
                $slider->setPicture($createPicture->createPicture($imageFile, 'sliders', $slider->getTitle()));
            }
            $slider->setPosition($positionMax + 1);
            $em->persist($slider);
            $em->flush();
            $this->addFlash('success', 'Votre slide a bien été ajoutée');
            return $this->redirectToRoute('admin-slider-index');
        }
        return $this->render('back/slide/newSlider.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/edit/{id}", name="admin-slider-edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('SlideBundle:Slider')->find($id);
        $firstPicture = $slider->getPicture();
        $createPicture = $this->get('home.createpicture');
        $form = $this->createForm(SliderType::class, $slider);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            if ($slider->getPicture() !== null) {
                if ($firstPicture) {
                    unlink($this->getParameter('image_sliders') . '/' . $firstPicture);
                }
                $imageFile = $form['picture']->getData();
                if ($imageFile) {
                    $slider->setPicture($createPicture->createPicture($imageFile, 'sliders', $slider->getTitle()));
                }
            } else {
                $slider->setPicture($firstPicture);
            }
            $em->flush();
            $this->addFlash('success', 'Votre Slide a bien été modifiée');
            return $this->redirectToRoute('admin-slider-index');
        }
        return $this->render('back/slide/editSlider.html.twig', [
            'form' => $form->createView(),
            'slider' => $slider
        ]);
    }

    /**
     * @Route ("/delete/{id}", name="admin-slider-delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('SlideBundle:Slider')->find($id);
        if ($post->getPicture()) {
            unlink($this->getParameter('image_sliders') . '/' . $post->getPicture());
        }
        $em->remove($post);
        $em->flush();
        $this->addFlash('success', 'Votre slide a bien été supprimée');
        return $this->redirectToRoute('admin-slider-index');
    }
}