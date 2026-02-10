<?php
namespace App\Infrastructure\School;

use App\Domain\School\School;
use App\Domain\School\SchoolRepository;

final class FileSchoolRepository implements SchoolRepository
{
    public function __construct(private string $filePath) {}

    public function findAll(): array
    {
        $lines = file($this->filePath);

        $schools = [];

        foreach ($lines as $line) {
            if (str_starts_with($line, '#') || trim($line) === '') {
                continue;
            }

            [$name, $aliases, $city, $type] = array_map('trim', explode('|', $line));

            $schools[] = new School(
                $name,
                array_map('trim', explode(',', $aliases)),
                $city,
                $type
            );
        }

        return $schools;
    }
}
