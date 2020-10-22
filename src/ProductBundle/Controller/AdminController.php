<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\ImageProduct;
use ProductBundle\Entity\Product;
use ProductBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin/product")
 */
class AdminController extends Controller
{
    /**
     * @Route ("/", name="admin-product-index")
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()->getManager()->getRepository('ProductBundle:Product')->findAll();
        return $this->render('back/product/index.html.twig', compact('products'));
    }

    /**
     * @Route ("/new", name="admin-product-new")
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $createPicture = $this->get('home.createpicture');
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($product);
            $files = $request->files->get('productbundle_product')['images'];
            if($files) {
                foreach ($files as $file) {
                    $imageRea = new ImageProduct();
                    $imageRea->setName($createPicture->createPicture($file, 'products', $product->getSlug()));
                    $imageRea->setProduct($product);
                    $em->persist($imageRea);
                }
            } else {
                $this->addFlash('warning', "Veuillez remplir le champ 'Images'");
                return $this->redirectToRoute('admin-product-new');
            }
            $em->flush();
            $this->addFlash('success', 'Votre produit a bien été ajoutée');
            return $this->redirectToRoute('admin-product-index');
        }
        return $this->render('back/product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/edit/{id}", name="admin-product-edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $createPicture = $this->get('home.createpicture');
        $product = $em->getRepository('ProductBundle:Product')->find($id);
        $form = $this->createForm(ProductType::class, $product);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $files = $request->files->get('productbundle_product')['images'];
            if ($files) {
                foreach ($files as $file) {
                    $imageRea = new ImageProduct();
                    $imageRea->setName($createPicture->createPicture($file, 'products', $product->getSlug()));
                    $imageRea->setProduct($product);
                    $em->persist($imageRea);
                }
            }
            $em->flush();
            $this->addFlash('success', 'Votre produit a bien été modifiée');
            return $this->redirectToRoute('admin-product-index');
        }
        return $this->render('back/product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    /**
     * @Route ("/delete/{id}", name="admin-product-delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductBundle:Product')->find($id);

        if(!$product) {
            $this->addFlash('warning', 'Ce produit n\'existe pas');
        } else {
            $images = $product->getImages();
            foreach ($images as $image) {
                unlink($this->getParameter('image_products') .'/'.  $image->getName());
            }
            $em->remove($product);
            $em->flush();
            $this->addFlash('success', 'Votre produit a bien été supprimée');
        }
        return $this->redirectToRoute('admin-product-index');
    }

    /**
     * @Route ("/image/delete/{id},{productId}", name="admin-product-image-delete")
     */
    public function imageDeleteAction($id,$productId)
    {
        $em = $this->getDoctrine()->getManager();
        $imageProduct = $em->getRepository('ProductBundle:ImageProduct')->find($id);
        $product = $em->getRepository('ProductBundle:Product')->find($productId);
        if ($imageProduct !== null && $product !== null) {
            $product->removeImage($imageProduct);
            $em->persist($product);
            $em->flush();
            unlink($this->getParameter('image_products') .'/'. $imageProduct->getName());
        } else {
            $this->addFlash('warning', 'Cette image n\'existe pas !');
        }
        return $this->redirectToRoute('admin-product-edit', ['id' => $productId]);
    }
}