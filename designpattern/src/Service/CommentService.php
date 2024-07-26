<?php

namespace App\Service;

use App\Entity\Comment;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\SecurityBundle\Security;

class CommentService
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        private DataValidator $validator,
        private PostRepository $postRepository
    ) {
    }

    public function saveComment(array $requestData): int
    {
        try {
            $comment = new Comment();
            $comment->setDescription($requestData['description'] ?? '');
            $post = $this->postRepository->findOneBy(['id' => $requestData['commentedOn'] ?? null]);
            $comment->setCommentedOn($post);
            $comment->setCommentedBy($this->security->getUser());
            $comment->setCreatedAt(new DateTimeImmutable("now"));

            $this->validator->validateData($comment);
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $comment->getId();
        } catch (EntityNotFoundException $exception) {
            throw new EntityNotFoundException($exception->getMessage());
        }
    }
}
