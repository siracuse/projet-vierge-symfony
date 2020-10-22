<?php

namespace HomeBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use HomeBundle\Form\ClientResetPasswordType;
use HomeBundle\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HomeController extends Controller
{
    /**
     * @Route ("/", name="index")
     */
    public function indexAction()
    {
        $slides = $this->getDoctrine()->getManager()->getRepository('SlideBundle:Slider')->findAll();

        return $this->render('front/index.html.twig', compact('slides'));
    }

    /**
     * @Route ("/vie-privee", name="vie-privee")
     */
    public function viePriveAction()
    {
        return $this->render('front/viePrive.html.twig');
    }

    /**
     * @Route ("/mentions-legales", name="mentions-legales")
     */
    public function mentionsLegalesAction()
    {
        return $this->render('front/mentions-legales.html.twig');
    }

    /**
     * @Route ("/sitemap.xml", name="sitemap", defaults={"_format" = "xml"})
     */
    public function siteMapAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $urls = array();
        $hostname = $request->getSchemeAndHttpHost();

        $urls[] = array('loc' => $this->generateUrl('index'));
        $urls[] = array('loc' => $this->generateUrl('contact'));
        $urls[] = array('loc' => $this->generateUrl('mentions-legales'));
        $urls[] = array('loc' => $this->generateUrl('vie-privee'));


        $urls[] = array('loc' => $this->generateUrl('realisations'));
        foreach ($em->getRepository('RealisationBundle:Realisation')->findAll() as $post) {
            $urls[] = array(
                'loc' => $this->generateUrl('realisation-fiche', array('id' => $post->getId(), 'slug' => $post->getSlug()))
            );
        }



        // return response in XML format
        $response = new Response(
            $this->renderView('front/sitemap.html.twig', array('urls' => $urls,
                'hostname' => $hostname)),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }

    /**
     * @Route ("/admin", name="indexAdmin")
     */
    public function adminIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nbRea = $em->getRepository('RealisationBundle:Realisation')->findAll();
        $nbSlide = $em->getRepository('SlideBundle:Slider')->findAll();

        return $this->render('back/index.html.twig', [
            'nbRea' => count($nbRea),
            'nbSlide' => count($nbSlide),
        ]);
    }

    /**
     * @Route ("/admin/utilisateurs", name="admin-utilisateurs-index")
     */
    public function adminUtilisateursIndexAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository('HomeBundle:User')->findAll();

        return $this->render('back/indexUtilisateurs.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/admin/reset-password", name="admin-reset-password")
     */
    public function adminResetPasswordAction(Request $request)
    {

        $form = $this->createForm(ResetPasswordType::class);

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordEncrypt = password_hash($form['password_confirm']->getData(), PASSWORD_BCRYPT);
            $user->setPassword($passwordEncrypt);
            $em->flush();
            $this->addFlash('success', 'Votre mot de passe a bien été enregistré');
            return $this->redirectToRoute('indexAdmin');
        }
        return $this->render('back/indexResetPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/client/reset-password", name="admin-client-reset-password")
     */
    public function adminClientResetPasswordAction(Request $request)
    {
        $form = $this->createForm(ClientResetPasswordType::class);

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('HomeBundle:User')->find(2);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordEncrypt = password_hash($form['password_confirm']->getData(), PASSWORD_BCRYPT);
            $client->setPassword($passwordEncrypt);
            $em->flush();
            $this->addFlash('success', 'Le mot de passe du compte client a bien été enregistré');
            return $this->redirectToRoute('indexAdmin');
        }
        return $this->render('back/indexClientResetPassword.html.twig', [
            'form' => $form->createView(),
            'client' => $client
        ]);

    }
}