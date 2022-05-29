<?php

namespace App\Enums;

class Priority
{
    const LOW = 'Normalny';
    const MEDIUM = 'Ważny!';
    const HIGH = 'Bardzo ważne!';

    const TYPES = [
        self::LOW,
        self::MEDIUM,
        self::HIGH
    ];
}
