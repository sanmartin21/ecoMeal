<?php

namespace App\View;

use App\View\ViewPadrao;

class ViewHome extends ViewPadrao
{

    static function getHtmlAlunos(array $aAlunos = [])
    {
        $sHtml = '';

        if (count($aAlunos) > 0) {
            foreach ($aAlunos as $iKey => $aAluno) {
                $iGoEat  = $aAluno['alunogoeat'];

                if ($iGoEat == 1) {
                    $sHtml .= '<div class="col">';

                    $sId     = $aAluno['alunoid'];
                    $sNome   = $aAluno['alunoname'];
                    $sTurma  = $aAluno['alunoturma'];
                    $iIdade  = $aAluno['alunoidade'];
                    $iSexo   = $aAluno['alunosexo'];

                    $sSexo = $iSexo == 1 ? $sSexo = "Feminino" : $sSexo = "Masculino";

                    $sImagem = file_exists($aAluno['alunoimageurl']) ? $aAluno['alunoimageurl'] : 'http://via.placeholder.com/250x250';
                    $sInfo   = !empty($aAluno['alunoinfo']) ? $aAluno['alunoinfo'] : 'Este aluno não contém informações adicionais.';

                    $sHtml .= '
                        <div class="card bg-dark bg-gradient" style="display: flex; flex-direction: column; align-items: center;">
                            <img src="' . $sImagem . '" alt="' . $sNome . '" style="width: 200px; height: 250px;">
                            <div class="card-body text-center">
                                <h5 class="card-title" style="word-wrap: break-word;">' . "<b>Nome do Aluno: </b>" . $sNome . '</h5>
                                <p class="card-text">
                                    ' . "<b>Turma: </b>" . $sTurma . '<br>
                                    ' . "<b>Idade: </b>" . $iIdade . '<br>
                                    ' . "<b>Sexo: </b>"  . $sSexo . '<br>
                                </p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-secondary" data-bs-trigger="focus" data-bs-toggle="popover" title="' . $sNome . '" data-bs-content="' . $sInfo . '"><span class="p-2"><i class="fa-solid fa-circle-info fa-lg"></i></span></button>
                                </div>
                            </div>
                        </div>
                    ';

                    $sHtml .= '</div>';
                }
            }
        }

        return $sHtml;
    }
}
