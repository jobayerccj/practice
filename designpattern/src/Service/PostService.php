<?php

namespace App\Service;

use App\Entity\Post;
use App\Utils\FileLogger;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\KernelInterface;

class PostService
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        private DataValidator $validator,
        private KernelInterface $kernel
    ) {
    }

    public function savePost(array $requestData): int
    {
        $post = new Post();
        $post->setTitle($requestData['title'] ?? '');
        $post->setDescription($requestData['description'] ?? '');
        $post->setCreatedBy($this->security->getUser());
        $post->setCreatedAt(new DateTimeImmutable("now"));

        $this->validator->validateData($post);
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        FileLogger::getInstance(
            $this->kernel->getLogDir() . '/custom.log')->log(sprintf('Post %s successfully added.', $post->getId())
        );
        return $post->getId();
    }
}
