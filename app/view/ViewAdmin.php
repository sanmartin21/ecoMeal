<?php

namespace App\View;

use App\View\ViewPadrao;

class ViewAdmin extends ViewPadrao
{

    static function getHtmlAlunos(array $aAlunos = [])
    {
        $sHtml = '';

        if (count($aAlunos) > 0) {
            $sHtml .= '
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Turma</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Alimentação</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Excluir</th>
                    </tr>
                </thead>
                <tbody>
            ';

            foreach ($aAlunos as $iKey => $aAluno) {
                $sHtml .= '<tr>';

                $sId     = $aAluno['alunoid'];
                $sNome   = $aAluno['alunoname'];
                $sTurma  = $aAluno['alunoturma'];
                $iIdade  = $aAluno['alunoidade'];
                $iSexo   = $aAluno['alunosexo'];
                $iGoEat   = $aAluno['alunogoeat'];

                $sSexo  = $iSexo == 2 ? $sSexo = "Masculino" : $sSexo = "Feminino";

                $sGoEat = $iGoEat == 2 ? '<span style="color: red; font-weight: bold;">Aluno não irá comer!</span>' : '<span style="color: rgb(0, 255, 0); font-weight: bold;">Aluno irá comer!</span>';

                $sHtml .= '
                    <th scope="row" height="62.5px">' . $sId . '</th>
                    <td>' . $sNome . '</td>
                    <td>' . $sTurma . '</td>
                    <td>' . $iIdade . '</td>
                    <td>' . $sSexo . '</td>
                    <td>' . $sGoEat . '</td>
                    <td><a href="index.php?pg=aluno&id=' . $sId . '"><i class="fa-solid fa-pen-to-square fa-lg text-warning"></i></a></td>
                    <td><a href="index.php?pg=aluno&act=delete&id=' . $sId . '"><i class="fa-solid fa-trash-can fa-lg text-danger"></i></a></td>
                ';

                $sHtml .= '</tr>';
            }

            $sHtml .= '</tbody>';
        } else {
            $sHtml .= '
                <thead>
                    <tr>
                        <th colspan="8">
                            <i class="fa-solid fa-exclamation-circle fa-xl p-2"></i>
                            Nenhum aluno cadastrado!
                        </th>
                    </tr>
                </thead>
            ';
        }

        return $sHtml;
    }
}
