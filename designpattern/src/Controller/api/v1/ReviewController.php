<?php

namespace App\Controller\api\v1;

use App\Controller\BaseController;
use App\Service\ReviewService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class ReviewController extends BaseController
{
    #[Route('/review', name: 'add_review', methods: ['POST'])]
    public function review(Request $request, ReviewService $reviewService)
    {
        // TO DO will add validation for required fields in near future
        $data = $request->toArray();
        $reviewService->store($data);

        return $this->jsonOk();
    }
}
