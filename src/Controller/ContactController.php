<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'portfolio_contact')]
    public function index(): Response
    {
        $form = $this->createForm(ContactType::class);

        return $this->render('pages/contact/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
