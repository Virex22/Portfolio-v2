<?php

namespace App\Service;

use App\Entity\ContactMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MonologBundle\SwiftMailer\MessageFactory;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactService
{
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer, Environment $twig)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function handleForm(ContactMessage $contactMessage): bool
    {
        $contactMessage->setDateAdd(new \DateTime());
        $contactMessage->setDateUpdate(new \DateTime());
        $this->entityManager->persist($contactMessage);
        $this->entityManager->flush();

        $this->sendEmail($contactMessage);

        return true;
    }

    private function sendEmail(ContactMessage $contactMessage): void
    {
        $message = (new Email())
            ->from('contact-page@vincent-remy.fr')
            ->to('vincentremy222@gmail.com')
            ->subject('Nouveau message de contact')
            ->html($this->twig->render('emails/contact.html.twig', ['contactMessage' => $contactMessage]));

        $this->mailer->send($message);
    }
}