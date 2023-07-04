<?php

namespace App\Controller;

use App\Controller\ControllerPadrao,
    App\Controller\ControllerHome;

use App\View\ViewAdmin;
use App\Model\ModelAluno;
use App\Client\Session;

class ControllerAdmin extends ControllerPadrao
{

    function render()
    {
        if (!(new Session)->isAdmin()) {
            $oControllerHome = new ControllerHome;

            $oControllerHome->showMessageError('Usuário sem privilégio de acesso.');

            return $oControllerHome->processPage();
        }

        return parent::render();
    }

    function processPage()
    {
        $sTitle   = 'Administrador';
        $sContent = ViewAdmin::render([
            'alunos' => ViewAdmin::getHtmlAlunos(self::getAlunos())
        ]);

        return parent::getPage(
            $sTitle,
            $sContent
        );
    }

    static function getAlunos()
    {
        return (new ModelAluno())->getAll();
    }
}
