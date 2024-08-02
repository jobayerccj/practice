<?php

namespace App\Builders;

use App\Entity\Post;
use App\Entity\Review;
use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface;

class ReviewBuilder
{
    protected Review $review;

    private function __construct()
    {
        $this->review = new Review();
    }

    public static function create(): self
    {
        return new self();
    }

    public function for(Post $post, UserInterface $user, string $title): self
    {
        $this->review->setPost($post);
        $this->review->setReviewedBy($user);
        $this->review->setTitle($title);

        return $this;
    }

    public function withContent(string $content): self
    {
        $this->review->setContent($content);

        return $this;
    }

    public function withCreatedAt(): self
    {
        $this->review->setCreatedAt(new DateTimeImmutable("now"));

        return $this;
    }

    public function build(): Review
    {
        return $this->review;
    }
}
