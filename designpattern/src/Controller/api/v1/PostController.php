<?php

namespace App\Controller\api\v1;

use App\Service\DataValidator;
use App\Service\PostService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Route('/api')]
class PostController extends AbstractController
{
    #[Route('/posts', name: 'posts', methods: ['POST'])]
    public function posts(Request $request, PostService $postService, DataValidator $dataValidator)
    {
        try {
            $postService->savePost($request->toArray());
            return new JsonResponse([
                'success' => true
            ]);
        } catch (ValidationFailedException $exception) {
            return new JsonResponse([
                'success' => false,
                'errors' => $dataValidator->processErrors($exception->getViolations())
            ], 422);
        } catch (Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'error' => $exception->getMessage()
            ], 422);
        }
    }
}
