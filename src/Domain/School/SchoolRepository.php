<?php

namespace App\Domain\School;

interface SchoolRepository
{
    /** @return School[] */
    public function findAll(): array;
}
