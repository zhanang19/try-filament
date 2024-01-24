<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Gender: int implements HasLabel
{
    case Male = 1;

    case Female = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Male => 'Male',
            self::Female => 'Female',
        };
    }
}
