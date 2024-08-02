<?php

namespace App\Service;

use App\Builders\ReviewBuilder;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ReviewService
{
    public function __construct(
        private PostRepository $postRepository,
        private Security $security,
        private EntityManagerInterface $entityManager
    ){}

    public function store(array $data)
    {
        $post = $this->postRepository->findOneBy(['id' => $data['post_id']]);
        $user = $this->security->getUser();

        $review = ReviewBuilder::create()
            ->for($post, $user, $data['title'])
            ->withContent($data['content'])
            ->withCreatedAt()
            ->build()
        ;

        $this->entityManager->persist($review);
        $this->entityManager->flush();
    }
}
