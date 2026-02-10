<?php
namespace App\Domain\School;

final class School
{
    public function __construct(
        private string $officialName,
        private array $aliases,
        private string $city,
        private string $type,
    ) {}

    public function officialName(): string
    {
        return $this->officialName;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function allNames(): array
    {
        return array_merge([$this->officialName], $this->aliases);
    }
}
