<?php

namespace App\Service;

use App\Entity\ContactMessage;
use Doctrine\ORM\EntityManagerInterface;

class ContactService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handleForm(ContactMessage $data): bool
    {
        $data->setDateAdd(new \DateTime());
        $data->setDateUpdate(new \DateTime());
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return true;
    }
}