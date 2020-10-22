<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Contact;
use ContactBundle\Form\ContactType;
use ReCaptcha\ReCaptcha;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route ("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
//        clé secrete



        $form = $this->createForm(ContactType::class);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                $name = $form['name']->getData();
                $firstname = $form['firstname']->getData();
                $email = $form['email']->getData();
                $phone = $form['phone']->getData();
                $message = $form['message']->getData();

                $messageSend = \Swift_Message::newInstance()
                    ->setSubject($name . $firstname)
                    ->setFrom($email)
                    ->setTo('siracuse.harichandra@gmail.com')
                    ->setBody($this->renderView('email/contact.html.twig', array(
                        'name' => $name,
                        'email' => $email,
                        'message' => $message,
                    )), 'text/html');
                $this->get('mailer')->send($messageSend);
                $this->addFlash('success', 'Votre message a bien été envoyé');
                return $this->redirectToRoute('contact');

        }

        return $this->render('front/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
