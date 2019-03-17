<?php

$erros = array();

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST' || !filter_has_var(INPUT_POST, 'Registar')) {
    return;
}

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'DistritoManager.php');
require_once (Conf::getApplicationManagerPath() . 'MoradaManager.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');
require_once (Conf::getApplicationModelPath() . 'TipoUtilizador.php');
require_once (Conf::getApplicationModelPath() . 'Distrito.php');
require_once (Conf::getApplicationModelPath() . 'Morada.php');


$tipoUtilizadorManager = new TipoUtilizadorManager();
$utilizadorManager = new UtilizadorManager();
$distritoManager = new DistritoManager();
$moradaManager = new MoradaManager();

$IdPrestadorServico = $tipoUtilizadorManager->getTipoUtilizadorByNome('Prestador de Serviço')->getId();



if (filter_has_var(INPUT_POST, 'tipoUtilizador')) {
    $tipoUtilizador = filter_input(INPUT_POST, 'tipoUtilizador', FILTER_SANITIZE_NUMBER_INT);


    if ($tipoUtilizador == false || !is_numeric($tipoUtilizador)) {
        $erros['tipoUtilizador'] = 'Tipo de Registo nao foi selecionado';
    } else {
        if (!$tipoUtilizadorManager->existeTipoUtilizador($tipoUtilizador)) {
            $erros['tipoUtilizador'] = 'Tipo de Registo contem erros';
        }
    }
} else {
    $erros['tipoUtilizador'] = 'Tipo de Registo nao foi selecionado';
}



if (filter_has_var(INPUT_POST, 'email')) {
    $str = array();



    if (($email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) == FALSE) {
        $erros['Email'] = "Email contem erros";
    } else {
        if (($email = filter_var($email, FILTER_VALIDATE_EMAIL)) == FALSE) {
            $str['sanitize'] = "Email não é valido";
        }
        $email = UtilizadorManager::encriptar($email);
        if ($utilizadorManager->existeEmail($email)) {
            $str['existe'] = "Email já existe";
        }

        if (count($str) > 0) {
            $erros['Email'] = $str;
        }
    }
} else {
    $erros['Email'] = "Email não foi preenchido";
}

if (filter_has_var(INPUT_POST, 'password')) {

    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $str = array();



    if ($pass == FALSE || !is_string($pass)) {
        $erros['Palavra-Chave'] = "Palavra-Chave não foi preenchida";
    } else {
        if (strlen($pass) < 6) {
            $str['minimo'] = "Palavra-Chave deve conter no minimo de 6 caracteres";
        }
        if (strlen($pass) > 20) {
            $str['maximo'] = "Palavra-Chave deve ter no maximo 20 caracteres";
        }

        if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $pass) == false) {
            $str['especial'] = "Palavra-Chave deve conter caracteres especiais";
        }

        if (count($str) > 0) {
            $erros['Palavra-Chave'] = $str;
        }
        $pass = UtilizadorManager::encriptar($pass);
    }
} else {
    $erros['Palavra-Chave'] = "Palavra-Chave não foi preenchida";
}



if (filter_has_var(INPUT_POST, 'name')) {

    $nome = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

    $str = array();
    if ($nome == FALSE || !is_string($nome)) {
        $erros['Nome'] = "Nome Completo não foi preenchido";
    } else {
        if (strlen($nome) > 200) {
            $str['maximo'] = "Nome Completo tem de ter no maximo de 200 caracteres";
        }
        if (strlen($nome) < 10) {
            $str['minimo'] = "Nome Completo tem de ter no minimo de 10 caracteres";
        }

        if (count($str) > 0) {
            $erros['Nome'] = $str;
        }
    }
} else {
    $erros['Nome'] = "Nome Completo não foi preenchido";
}

if (filter_has_var(INPUT_POST, 'rua')) {

    if (($rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING)) == FALSE || !is_string($rua)) {
        $erros['rua'] = "Rua não foi preenchida";
    } else {
        if (strlen($rua) > 150) {
            $erros['rua'] = "Rua tem de ter menos de 150 caracteres";
        }
    }
} else {
    $erros['rua'] = "Rua não foi preenchida";
}

if (filter_has_var(INPUT_POST, 'cp1') && filter_has_var(INPUT_POST, 'cp2')) {

    $cp1 = filter_input(INPUT_POST, 'cp1', FILTER_SANITIZE_NUMBER_INT);
    $cp2 = filter_input(INPUT_POST, 'cp2', FILTER_SANITIZE_NUMBER_INT);

    if ($cp1 == FALSE || $cp2 == FALSE || !is_numeric($cp1) || !is_numeric($cp2)) {
        $erros['cp2'] = "Codigo-Postal não foi preenchido";
    } else {
        if ($cp1 < 1000 || $cp1 > 9999 || $cp2 < 001 || $cp2 > 999) {

            $erros['cp1'] = "Codigo-Postal contem erros";
        }
    }
} else {
    $erros['cp'] = "Codigo-Postal não foi preenchido";
}


if (filter_has_var(INPUT_POST, 'distrito')) {

    if (($distrito = filter_input(INPUT_POST, 'distrito', FILTER_SANITIZE_STRING)) == FALSE) {
        $erros['distrito'] = "Distrito não foi selecionado";
    } else {
        if (!$distritoManager->existeDistrito($distrito)) {
            $erros['distrito'] = "Distrito selecionado existente";
        }
    }
} else {
    $erros['distrito'] = "Distrito não foi selecionado";
}

if (filter_has_var(INPUT_POST, 'contact')) {

    $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_NUMBER_INT);

    if ($contact == FALSE || !is_numeric($contact)) {
        $erros['contact'] = "Contacto não foi preenchido";
    } else {
        if ($contact < 200000000 || $contact > 970000000) {
            $erros['contact'] = "Contacto contem erros";
        }
    }
} else {
    $erros['contact'] = "Contacto não foi preenchido";
}

if (filter_has_var(INPUT_POST, 'concelho')) {
    if (($concelho = filter_input(INPUT_POST, 'concelho', FILTER_SANITIZE_STRING)) == FALSE) {
        $erros['concelho'] = "Concelho não foi preenchido";
    } else {
        if (count($concelho) > 150) {
            $erros['concelho'] = 'Concelho pode conter no maximo 150 Caracteres';
        }
    }
} else {
    $erros['concelho'] = "Concelho não foi preenchido";
}




if ($tipoUtilizador == $IdPrestadorServico) {

    if (filter_has_var(INPUT_POST,'fileToUpload')) {

        $target_dir = "../../Resources/Images/Uploads/";

        $fotografia = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        $uploadOk = 1;
        $imageFileType = pathinfo($fotografia, PATHINFO_EXTENSION);

        
        if (file_exists($fotografia) && array_key_exists('fotografia', $erros) == false) {
           // $erros['fotografia'] = "A imagem já existe";
        }
        if ($_FILES["fileToUpload"]["size"] > 500000 && array_key_exists('fotografia', $erros) == false) {
          //  $erros['fotografia'] = "A imagem é muito grande";
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
          //  $erros['fotografia'] = "Só sao permitidas imagens com o formato JPG, JPEG, PNG e GIF";
        }

        if (array_key_exists('fotografia', $erros) == false) {

            move_uploaded_file($_FILES["fileToUpload"]["name"], $fotografia);
        }
    } else {
        //$erros['fotografia'] = "Não existe o campo fotografia";
    }
}



if (count($erros) == 0) {

    $novoUtilizador = new Utilizador();
    $morada = new Morada();

    $novoUtilizador->setEmail($email);
    $novoUtilizador->setPassword($pass);
    $novoUtilizador->setSerial(sha1($pass, time()));
    $novoUtilizador->setContacto($contact);
    $novoUtilizador->setTipoUtilizador($tipoUtilizador);
    $novoUtilizador->setNome($nome);

    if ($tipoUtilizador == $IdPrestadorServico) {
        $novoUtilizador->setFoto($fotografia);
    }
    if ($moradaManager->existeMorada($rua, $concelho, $distrito, $cp1, $cp2)) {
        $results = $moradaManager->getMorada($rua, $concelho, $distrito, $cp1, $cp2);
        $morada->setId($results->getId());
    } else {
        $morada->setConcelho($concelho);
        $morada->setCp1($cp1);
        $morada->setCp2($cp2);
        $morada->setDistrito($distrito);
        $morada->setRua($rua);
        $morada->setId($moradaManager->maxID() + 1);

        $moradaManager->InsertMorada($morada);
    }

    $novoUtilizador->setMorada($morada->getId());



    $utilizadorManager->InsertUtilizador($novoUtilizador);

    header('location:login.php');
}
