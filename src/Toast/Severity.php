<?php

namespace ShufflingPixels\Toast;

enum Severity: string
{
    case INFO = 'info';
    case SUCCESS = 'success';
    case WARN = 'warning';
    case ERROR = 'error';
}
