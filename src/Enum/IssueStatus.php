<?php

namespace App\Enum;

enum IssueStatus: int
{
    case OPEN = 0;
    case IN_PROGRESS = 1;
    case RESOLVED = 2;
    case CLOSED = 3;
}
