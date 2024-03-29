<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactType;
use App\Service\ContactService;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'portfolio_contact')]
    public function index(ContactService $contactService, Request $request, Recaptcha3Validator $recaptcha3Validator): Response
    {
        $message = new ContactMessage();

        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);
        $params = ['form' => $form->createView()];

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $params['success'] = $contactService->handleForm($form->getData());
            }
            else {
                $params['success'] = false;
            }
        }

        return $this->render('pages/contact/contact.html.twig', $params);
    }
}
