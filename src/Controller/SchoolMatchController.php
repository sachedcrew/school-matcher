<?php

namespace App\Controller;

use App\Application\School\SchoolMatchService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class SchoolMatchController
{
    public function __construct(private SchoolMatchService $service)
    {
    }

    #[Route('/schools/match', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $name = $request->query->get('name');

        if (!$name || trim($name) === '') {
            return new JsonResponse(['message' => 'Name is required'], 400);
        }

        $schools = $this->service->match($name);

        if (!$schools) {
            return new JsonResponse(['message' => 'Not found'], 404);
        }

        $data = array_map(fn($school) => [
            'name' => $school->officialName(),
            'city' => $school->city(),
            'type' => $school->type(),
        ], $schools);

        return new JsonResponse($data);
    }   

}
