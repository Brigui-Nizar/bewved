<?php

declare(strict_types=1);

namespace App\DTO;

class LearnerSearchCriteria
{
    public ?bool $genre = false;
    public ?bool $age = false;
    public ?bool $skill = false;
}
