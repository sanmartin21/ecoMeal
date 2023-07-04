<?php

function render($sPage)
{
    switch ($sPage) {
        case 'home':
            return (new App\Controller\ControllerHome)->render();
        case 'login':
            return (new App\Controller\ControllerLogin)->render();
        case 'logout':
            return (new App\Controller\ControllerLogout)->render();
        case 'register':
            return (new App\Controller\ControllerRegister)->render();
        case 'admin':
            return (new App\Controller\ControllerAdmin)->render();
        case 'aluno':
            return (new App\Controller\ControllerAluno)->render();
    }

    return (new App\Controller\ControllerPageNotFound)->render();
}
