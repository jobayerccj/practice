<?php

namespace App\Controller\api\v1;

use App\Controller\BaseController;
use App\Service\CommentService;
use App\Service\DataValidator;
use App\Service\PostService;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[Route('/api')]
class CommentController extends BaseController
{
    #[Route('/comments', name: 'comments', methods: ['POST'])]
    public function comments(Request $request, CommentService $commentService, DataValidator $dataValidator): JsonResponse
    {
        try {
            $commentId = $commentService->saveComment($request->toArray());
            return $this->jsonOk(['commentId' => $commentId]);
        } catch (ValidationFailedException $exception) {
            return $this->jsonError($dataValidator->processErrors($exception->getViolations()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (EntityNotFoundException $exception) {
            return $this->jsonError($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->jsonError($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
