<?php

namespace App\Application\School;

use App\Domain\School\School;

final class SchoolMatcher
{
    public function match(string $input, array $schools): ?School
    {
        $input = TextNormalizer::normalize($input);

        $best = null;
        $bestScore = 0;

        foreach ($schools as $school) {
            foreach ($school->allNames() as $name) {
                $normalized = TextNormalizer::normalize($name);

                similar_text($input, $normalized, $percent);

                if ($percent > $bestScore) {
                    $bestScore = $percent;
                    $best = $school;
                }
            }
        }

        return $bestScore > 40 ? $best : null;
    }
}
