<?php

namespace App\Application\School;

use App\Domain\School\SchoolRepository;

final class SchoolMatchService
{
    public function __construct(
        private SchoolRepository $repository,
        private SchoolMatcher $matcher
    ) {}

    public function match(string $name): ?array
    {
        $schools = $this->repository->findAll();

        $school = $this->matcher->match($name, $schools);

        if (!$school) {
            return null;
        }

        return [
            'name' => $school->officialName(),
            'city' => $school->city(),
            'type' => $school->type(),
        ];
    }
}
