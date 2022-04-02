<?php

namespace App\Enums;

class ModuleName
{
    const ADMIN = 'Administracja';
    const EDS = 'Terminy';
    const GUIDE = 'Podręczniki';
    const PLANOGRAMS = 'Planogramy';
    const MESSAGES = 'Wiadomości';
    const TASKS = 'Zadania';
    const SCHEDULE = 'Grafik';
    const UNKNOWN = 'Nieznany';

    const TYPES = [
        self::ADMIN,
        self::EDS,
        self::GUIDE,
        self::PLANOGRAMS,
        self::MESSAGES,
        self::TASKS,
        self::SCHEDULE,
        self::UNKNOWN
    ];
}
