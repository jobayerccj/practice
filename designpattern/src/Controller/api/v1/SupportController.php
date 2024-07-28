<?php

namespace App\Controller\api\v1;

use App\Controller\BaseController;
use App\Service\SupportService;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/v1')]
class SupportController extends BaseController
{
    #[Route('/support', name: 'support', methods: ['POST'])]
    public function support(Request $request, SupportService $supportService)
    {
        try {
            $supportService->support($request->toArray());
            return $this->jsonOk();
        } catch (EntityNotFoundException $exception) {
            return $this->jsonError("Wrong post id provided");
        } catch (Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }
    }
}
