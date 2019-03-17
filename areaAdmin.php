<?php


require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;
require_once (Conf::getApplicationManagerPath() . 'SessionManager.php');
require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');


if (filter_input(INPUT_SERVER, 'REQUEST_METHOD' != 'GET')  || (filter_has_var(INPUT_GET,'logout') )
        || (!array_key_exists('tipoUtilizador', $_SESSION)) || (!array_key_exists('logged', $_SESSION)) || (!array_key_exists('serial', $_SESSION)) ) {
    SessionManager::addSessionValue('logout', '');
    
    $_SESSION['tipoUtilizador']='null';
    header('location: Application/Utils/loginValidate.php');
}

if (array_key_exists('tipoUtilizador', $_SESSION)) {
    $tipoUtilizador = $_SESSION['tipoUtilizador'];

    $utilizadorManager = new UtilizadorManager();
    if ($tipoUtilizador != null || is_numeric($tipoUtilizador) || !$utilizadorManager->existeSerial($_SESSION['logged'], $_SESSION['serial']) 
            || !$utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador() == $tipoUtilizador ) {
        SessionManager::addSessionValue('logout', '');
        $_SESSION['tipoUtilizador']='null';
        header('location: Application/Utils/loginValidate.php');
    }
}

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title><link rel="stylesheet" href="Resource/CSS/style1.css">
        <link rel="stylesheet" href="Resource/CSS/style1.css">
    </head>
    <body>
        <header id="cabecalho">
            <img src="./Resource/Images/logo.png">
            <h1>Ofertas de trabalho para todos!</h1>   
        </header>
        <nav id="menu">
            <ul>
                <li><a href="gerirUtilizador.php">Gerir Utilizadores</a></li>
                <li><a href="gerirOfertas.php">Gerir Ofertas</a></li>
                <li><a href="areaAdmin.php?logout">Logout</a></li>
            </ul>
        </nav>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>

