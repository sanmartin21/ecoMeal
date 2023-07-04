<?php

namespace App\Model;

use App\Model\ModelPadrao;

class ModelAluno extends ModelPadrao
{
    private $id;
    private $name;
    private $turma;
    private $idade;
    private $sexo;
    private $goEat;
    private $imageUrl;
    private $info;

    function getId()
    {
        return $this->id;
    }

    function setId($sId)
    {
        $this->id = $sId;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($sName)
    {
        $this->name = $sName;
    }

    function getTurma()
    {
        return $this->turma;
    }

    function setTurma($sTurma)
    {
        $this->turma = $sTurma;
    }

    function getIdade()
    {
        return $this->idade;
    }

    function setIdade($iIdade)
    {
        $this->idade = $iIdade;
    }
    function getSexo()
    {
        return $this->sexo;
    }

    function setSexo($iSexo)
    {
        $this->sexo = $iSexo;
    }

    function getGoEat()
    {
        return $this->goEat;
    }

    function setGoEat($iGoEat)
    {
        $this->goEat = $iGoEat;
    }

    function getImageUrl()
    {
        return $this->imageUrl;
    }

    function setImageUrl($sImageUrl)
    {
        $this->imageUrl = $sImageUrl;
    }

    function getInfo()
    {
        return $this->info;
    }

    function setInfo($sInfo)
    {
        $this->info = $sInfo;
    }

    function getTable()
    {
        return 'tbaluno';
    }

    function insertAluno()
    {
        return parent::insert([
            'alunoname'     => $this->getBdValue($this->getName()),
            'alunoturma'    => $this->getBdValue($this->getTurma()),
            'alunoidade'    => $this->getBdValue($this->getIdade()),
            'alunosexo'     => $this->getBdValue($this->getSexo()),
            'alunogoeat'    => $this->getBdValue($this->getGoEat()),
            'alunoimageurl' => $this->getBdValue($this->getImageUrl()),
            'alunoinfo'     => $this->getBdValue($this->getInfo())
        ]);
    }

    function deleteAluno()
    {
        return parent::delete([
            'alunoid = ' . $this->getBdValue($this->getId())
        ]);
    }

    function getAluno()
    {
        $aAll = parent::getAll([
            'alunoid = ' . $this->getBdValue($this->getId())
        ]);

        if (count($aAll) > 0) {
            return array_shift($aAll);
        }

        return false;
    }

    function persistAluno()
    {
        if ($aAluno = $this->getAluno()) {
            $this->setName($aAluno['alunoname']);
            $this->setTurma($aAluno['alunoturma']);
            $this->setIdade($aAluno['alunoidade']);
            $this->setSexo($aAluno['alunosexo']);
            $this->setGoEat($aAluno['alunogoeat']);
            $this->setImageUrl($aAluno['alunoimageurl']);
            $this->setInfo($aAluno['alunoinfo']);
        }
    }

    function getColumnsChange(array $aAlunoUpdate)
    {
        $aAluno = $this->getAluno();

        foreach ($aAlunoUpdate as $sKey => $sValue) {
            if ($aAlunoUpdate[$sKey] == $aAluno[$sKey]) {
                unset($aAlunoUpdate[$sKey]);
            }
        }

        return $aAlunoUpdate;
    }

    function getColumnsValues()
    {
        return [
            'alunoid'       => $this->getId(),
            'alunoname'     => $this->getName(),
            'alunoturma'    => $this->getTurma(),
            'alunoidade'    => $this->getIdade(),
            'alunosexo'     => $this->getSexo(),
            'alunogoeat'    => $this->getGoEat(),
            'alunoimageurl' => $this->getImageUrl(),
            'alunoinfo'     => $this->getInfo()
        ];
    }

    function updateAluno($aValues)
    {
        return parent::update(
            $aValues,
            ['alunoid = ' . $this->getBdValue($this->getId())]
        );
    }
}
