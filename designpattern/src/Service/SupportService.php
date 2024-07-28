<?php

namespace App\Service;

use App\Factories\SupportableFactory;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;

class SupportService
{
    public function __construct(protected PostRepository $postRepository, protected SupportableFactory $supportableFactory, protected EntityManagerInterface $entityManager)
    {
    }

    public function support(array $requestData)
    {

        $post = $this->postRepository->findOneBy(['id' => $requestData['post_id']]);
        if (is_null($post)) {
            throw new EntityNotFoundException("asdasda");
        }

        $supportableClass = $this->supportableFactory->getSupportable($post);
        $supportableClass->support();
        $this->entityManager->flush();
    }
}
