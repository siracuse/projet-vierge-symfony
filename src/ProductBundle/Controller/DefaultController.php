<?php

namespace ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route ("/", name="product-index")
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()->getManager()->getRepository('ProductBundle:Product')->findAll();
        $categories = $this->getDoctrine()->getManager()->getRepository('ProductBundle:Category')->findAll();
        return $this->render('front/product/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * @Route ("/product/{slug}-{id}", name="product-fiche", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function productFicheAction($slug, $id)
    {
        $product = $this->getDoctrine()->getManager()->getRepository('ProductBundle:Product')->find($id);
        if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute('product-fiche', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ], 301);
        }
        return $this->render('front/product/fiche.html.twig', compact('product'));
    }

    /**
     * @Route("/ajax/search/prog", name="ajax-search-prog")
     */
    public function ajaxSearchProgAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->get('data');
//        var_dump($data);
//        die();

        $products = $em->getRepository('ProductBundle:Product')->getActuAjax($data);

        $myProducts = [];
        foreach ($products as $product) {
            array_push($myProducts, [$product->getId(), $product->getName(), $product->getSlug()]);
        }

        $response = new Response(json_encode($myProducts));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}