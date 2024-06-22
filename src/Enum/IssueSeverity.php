<?php

namespace App\Enum;

enum IssueSeverity: int
{
    case LOW = 0;
    case MEDIUM = 1;
    case HIGH = 2;
}
