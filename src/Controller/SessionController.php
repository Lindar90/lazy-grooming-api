<?php

namespace App\Controller;

use App\FormRequest\SessionInitFormRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'session_init', methods: ['post'])]
    public function init(SessionInitFormRequest $request): JsonResponse
    {
        $dto = $request->getDTO();
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SessionController.php',
        ]);
    }
}
