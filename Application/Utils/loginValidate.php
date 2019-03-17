<?php

require_once '../Manager/SessionManager.php';


require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');

if (array_key_exists('logout', $_SESSION)) {

    SessionManager::deleteSessionValue('logged');
    SessionManager::deleteSessionValue('serial');
    SessionManager::deleteSessionValue('logout');
    SessionManager::deleteSessionValue('tipoUtilizador');
    if (array_key_exists('email', $_COOKIE)) {
        setcookie('email','',0,'/');
       
    }
    if (array_key_exists('serial', $_COOKIE)) {
        setcookie('serial','',0,'/');
    }
    header('location: ../../login.php');
    return;
} else {

    if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST' || (!filter_has_var(INPUT_POST, 'Login') && !filter_has_var(INPUT_POST, 'Registar'))) {
        header('location: ../../login.php');
        return;
    }
    $erros = array();



    if (filter_has_var(INPUT_POST, 'Registar') == true) {
        header('location: ../../registar.php');
    } else {
        $utilizadorManager = new UtilizadorManager();


        if (filter_has_var(INPUT_POST, 'email')) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if ($email == false || !($email = filter_var($email, FILTER_VALIDATE_EMAIL))) {
                $erros['email'] = 'Email com formato invalido';
            }
        } else {
            $erros['email'] = 'Email não preenchido';
        }

        if (filter_has_var(INPUT_POST, 'pass')) {
            $palavrachave = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

            if ($palavrachave == false || !is_string($palavrachave)) {
                $erros['palavraChave'] = 'Palavra chave com formato invalido';
            }
        } else {
            $erros['palavraChave'] = 'Palavra chave não preenchida';
        }

        if (filter_has_var(INPUT_POST, 'remember')) {

            $remember = filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_STRING);

            if ($remember == false || !is_string($remember)) {
                $erros['remember'] = 'Remember me com formato invalido';
            }
        }


        if (count($erros) == 0) {

            if ($utilizadorManager->existeUtilizador(UtilizadorManager::encriptar($email), UtilizadorManager::encriptar($palavrachave))) {

                $utilizadorAtual = $utilizadorManager->getUtilizadorByEmail(UtilizadorManager::encriptar($email));

                $utilizadorAtual->setSerial($utilizadorAtual->generatorSerial());

                $utilizadorManager->updateUtilizador($utilizadorAtual);

                SessionManager::addSessionValue('logged', $utilizadorAtual->getEmail());
                SessionManager::addSessionValue('serial', $utilizadorAtual->getSerial());
                SessionManager::addSessionValue('tipoUtilizador', $utilizadorAtual->getTipoUtilizador());
                if ($remember == 'remember') {

                    setcookie('email', $utilizadorAtual->getEmail(), time() + (60 * 60 * 24 * 360), "/");
                    setcookie('serial', $utilizadorAtual->getSerial(), time() + (60 * 60 * 24 * 360), "/");
                }
                if ($utilizadorAtual->getTipoUtilizador() == null) {
                    header('location:../../areaAdmin.php');
                } else {
                    header('location:../../areaUtilizador.php');
                }
            } else {

                header('location: ../../login.php?login=Invalido');
            }
        } else {

            SessionManager::addSessionValue('erros', json_encode($erros));
            header('location: ../../login.php?login=Invalido');
        }
    }
}    