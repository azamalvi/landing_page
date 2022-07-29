<?php

namespace App\Controller;

use App\Entity\ContactUs;
use App\Form\ContactUsType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(Request $request,EntityManagerInterface $em): Response
    {
        $contactUs = new ContactUs();
        $form = $this->createForm(ContactUsType::class, $contactUs);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contactUs);
            $em->flush();

            return $this->redirect($this->generateUrl('home', ['fname' => $contactUs->getFirstName(), 'lname' => $contactUs->getLastName()]));
        }
        return $this->renderForm('landing_page.html.twig', ['form' => $form]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request): Response
    {
        return $this->render('home.html.twig');
    }
}
