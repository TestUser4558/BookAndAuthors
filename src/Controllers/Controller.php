<?php

namespace Src\Controllers;

use Slim\Views\PhpRenderer;
use Slim\Flash\Messages;

class Controller
{
    public function __construct(
       protected PhpRenderer $renderer, protected Messages $messages
    )
    {
    }
}
