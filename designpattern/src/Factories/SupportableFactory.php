<?php

namespace App\Factories;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SupportableFactory
{
    public function __construct(protected AuthorizationCheckerInterface $authorizationChecker)
    {
    }

    public function getSupportable(Post $post)
    {
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $post->getCreatedBy();
        } else {
            return $post;
        }
    }
}
