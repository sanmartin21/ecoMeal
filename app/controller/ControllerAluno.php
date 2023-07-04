<?php

namespace App\Controller;

use App\Controller\ControllerPadrao,
    App\Controller\ControllerAdmin;

use App\View\ViewAluno;

use App\Model\ModelAluno;

class ControllerAluno extends ControllerPadrao
{
    private $fileUrl;

    function processPage()
    {
        $sTitle   = 'Aluno';
        $sContent = ViewAluno::render(
            $this->getContentVars()
        );

        return parent::getPage(
            $sTitle,
            $sContent
        );
    }

    protected function getContentVars()
    {
        $xId = $_GET['id'] ??= '';

        if ($xModelAluno = $this->getModelAlunoFromId($xId)) {
            return [
                'id'       => $xModelAluno->getId(),
                'name'     => $xModelAluno->getName(),
                'turma'    => $xModelAluno->getTurma(),
                'idade'    => $xModelAluno->getIdade(),
                'sexo'     => $xModelAluno->getSexo(),
                'goEat'    => $xModelAluno->getGoEat(),
                'imageurl' => $xModelAluno->getImageUrl(),
                'info'     => $xModelAluno->getInfo(),
                'act'      => 'update&id=' . $xModelAluno->getId(),
                'required' => ''
            ];
        }

        return [
            'id'       => '',
            'name'     => '',
            'turma'    => '',
            'idade'    => '',
            'sexo'     => '',
            'goEat'     => '',
            'imageurl' => '',
            'info'     => '',
            'act'      => 'insert',
            'required' => 'required'
        ];
    }

    protected function getModelAlunoFromId($xId)
    {
        if (!empty($xId) && !is_null($xId)) {
            $oModelAluno = new ModelAluno;
            $oModelAluno->setId($xId);

            $oModelAluno->persistAluno();

            return $oModelAluno;
        }

        return false;
    }

    protected function processInsert()
    {
        if ($this->processInsertFile($this)) {
            $this->processInsertAluno();
        }

        return $this->processPage();
    }

    protected function processInsertAluno()
    {
        $oModelAluno = $this->getModelAlunoFromPost();

        if (!empty($this->fileUrl)) {
            $oModelAluno->setImageUrl($this->fileUrl);
        }

        if ($oModelAluno->insertAluno()) {
            return $this->showMessageSucess('Aluno inserido com sucesso!');
        }

        return $this->showMessageError('Ocorreu um erro ao tentar inserir o Aluno.');
    }

    protected function getModelAlunoFromPost()
    {
        $sId    = $_POST['id'] ??= null;
        $sName  = $_POST['name'] ??= '';
        $sTurma = $_POST['turma'] ??= '';
        $iIdade = $_POST['idade'] ??= '';
        $iSexo  = $_POST['sexo'] ??= '';
        $iGoEat = $_POST['goEat'] ??= '';
        $sTurma = $_POST['turma'] ??= '';
        $sInfo  = $_POST['info'] ??= '';

        $oModelAluno = new ModelAluno;
        $oModelAluno->setId($sId);
        $oModelAluno->setName($sName);
        $oModelAluno->setTurma($sTurma);
        $oModelAluno->setIdade($iIdade);
        $oModelAluno->setSexo($iSexo);
        $oModelAluno->setGoEat($iGoEat);
        $oModelAluno->setImageUrl($this->fileUrl);
        $oModelAluno->setInfo($sInfo);

        return $oModelAluno;
    }

    protected function processInsertFile($oController)
    {
        if (isset($_FILES['image'])) {
            $aFile = $_FILES['image'];

            if ($this->validFile($aFile, $oController)) {
                $sPath          = __DIR__ . '/../../temp/';
                $sFileTempName  = $aFile['tmp_name'];
                $sFileNewName   = uniqid();
                $sFileExtension = $this->getFileExtension($aFile);

                $this->fileUrl = 'temp/' . $sFileNewName . '.' . $sFileExtension;

                return move_uploaded_file($sFileTempName, $sPath . $sFileNewName . '.' . $sFileExtension);
            }
        }

        return false;
    }

    protected function validFile($aFile, $oController)
    {
        if ($aFile['error'] == UPLOAD_ERR_NO_FILE) {
            return false;
        }

        if ($aFile['error']) {
            return $oController->showMessageError('Falha ao enviar arquivo.');
        }

        if ($aFile['size'] > 2097152) {
            return $oController->showMessageError('Arquivo muito grande! Máximo: 2MB.');
        }

        if (!in_array($this->getFileExtension($aFile), ['jpeg', 'jpg', 'png', 'webp'])) {
            return $oController->showMessageError('Tipo de arquivo não aceito.');
        }

        return true;
    }

    protected function getFileExtension($aFile)
    {
        return strtolower(pathInfo($aFile['name'], PATHINFO_EXTENSION));
    }

    protected function processDelete()
    {
        $oControllerAdmin = new ControllerAdmin;

        $xId = $_GET['id'] ??= null;

        if ($oModelAluno = $this->getModelAlunoFromId($xId)) {
            if ($this->processDeleteAluno($oControllerAdmin, $oModelAluno)) {
                $this->processDeleteFile($oModelAluno);
            }
        }

        return $oControllerAdmin->processPage();
    }

    protected function processDeleteAluno(ControllerAdmin $oControllerAdmin, ModelAluno $oModelAluno)
    {
        $xId = $oModelAluno->getId();

        if ($oModelAluno->deleteAluno()) {
            return $oControllerAdmin->showMessageSucess('Aluno ' . $xId . ' excluído com sucesso!');
        }

        return $oControllerAdmin->showMessageError('Ocorreu um erro ao excluir o Aluno: ' . $xId . '.');
    }


    protected function processDeleteFile(ModelAluno $oModelAluno)
    {
        $xFileUrl = $oModelAluno->getImageUrl();

        if (!empty($xFileUrl)) {
            $sFileUrl = __DIR__ . '/../../' . $xFileUrl;

            if (file_exists($sFileUrl)) {
                unlink($sFileUrl);

                return true;
            }
        }

        return false;
    }

    protected function processUpdate()
    {
        $oControllerAdmin = new ControllerAdmin;

        if ($this->processInsertFile($oControllerAdmin)) {
            $xId = $_GET['id'] ??= null;

            if ($oModelAluno = $this->getModelAlunoFromId($xId)) {
                $this->processDeleteFile($oModelAluno);
            }
        }

        $this->processUpdateAluno($oControllerAdmin);

        return $oControllerAdmin->processPage();
    }

    protected function processUpdateAluno(ControllerAdmin $oControllerAdmin)
    {

        $oModelAluno = $this->getModelAlunoFromPost();

        $aValues = $oModelAluno->getColumnsChange($oModelAluno->getColumnsValues());

        $xId = $oModelAluno->getId();

        if ($oModelAluno->updateAluno($aValues)) {
            return $oControllerAdmin->showMessageSucess('Aluno ' . $xId . ' alterado com sucesso!');
        }
    }
}
