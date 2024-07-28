<?php

namespace App\Controller\api\v1;

use App\Controller\BaseController;
use App\Service\DataValidator;
use App\Service\PostService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Route('/api/v1')]
class PostController extends BaseController
{
    #[Route('/posts', name: 'posts', methods: ['POST'])]
    public function posts(Request $request, PostService $postService, DataValidator $dataValidator): JsonResponse
    {
        try {
            $postId = $postService->savePost($request->toArray());
            return $this->jsonOk(['postId' => $postId]);
        } catch (ValidationFailedException $exception) {
            return $this->jsonError($dataValidator->processErrors($exception->getViolations()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $exception) {
            return $this->jsonError($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
