<?php

namespace App\Controller;

use App\View\ViewHome;
use App\Controller\ControllerPadrao;
use App\Controller\ControllerAdmin;

class ControllerHome extends ControllerPadrao
{

    protected function processPage()
    {
        $sTitle   = 'EcoMeal';
        $sContent = ViewHome::render([
            'alunos' => ViewHome::getHtmlAlunos(ControllerAdmin::getAlunos())
        ]);

        return parent::getPage(
            $sTitle,
            $sContent
        );
    }
}
