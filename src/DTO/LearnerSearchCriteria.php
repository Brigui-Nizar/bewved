<?php

declare(strict_types=1);

namespace App\DTO;

class LearnerSearchCriteria
{

    public ?int $size = 2;
    public ?bool $genre = null;
    public ?bool $age = null;
    public ?bool $skill = null;
}
