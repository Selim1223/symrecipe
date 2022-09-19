<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $contact = new Contact();

        if ($this->getUser()) {
            $contact->setFullName($this->getUser()->getFullName())
                ->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $this->addFlash(
                'success',
                'Votre demande a bien été envoyé avec succès !'
            );

            $manager->persist($contact);
            $manager->flush();

            //Email
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('admin@symrecipe.com')
                ->subject($contact->getSubject())
                 // path of the Twig template to render
                ->htmlTemplate('emails/contact.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'contact' => $contact,
                ]);

            $mailer->send($email);

            return $this->redirectToRoute('contact.index');
        }


        return $this->render('pages/contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
