<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\Category;
use ProductBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route ("/", name="admin-category-index")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('ProductBundle:Category')->findAll();
        return $this->render('back/category/index.html.twig', compact('categories'));
    }

    /**
     * @Route ("/new", name="admin-category-new")
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Votre catégorie a bien été ajoutée');
            return $this->redirectToRoute('admin-category-index');
        }
        return $this->render('back/category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/edit/{id}", name="admin-category-edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ProductBundle:Category')->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Votre catégorie a bien été modifiée');
            return $this->redirectToRoute('admin-category-index');
        }
        return $this->render('back/category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * @Route ("/delete/{id}", name="admin-category-delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('ProductBundle:Category')->find($id);
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'Votre produit a bien été supprimée');
        return $this->redirectToRoute('admin-category-index');
    }

}