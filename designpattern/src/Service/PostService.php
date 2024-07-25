<?php

namespace App\Service;

use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class PostService
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        private DataValidator $validator
    ) {
    }

    public function savePost(array $requestData)
    {
        $post = new Post();
        $post->setTitle($requestData['title'] ?? '');
        $post->setDescription($requestData['description'] ?? '');
        $post->setCreatedBy($this->security->getUser());
        $post->setCreatedAt(new DateTimeImmutable("now"));

        $this->validator->validateData($post);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}
