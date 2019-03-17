<?php
require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'SessionManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');
require_once (Conf::getApplicationModelPath() . 'TipoUtilizador.php');

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD' != 'GET') || (!array_key_exists('tipoUtilizador', $_SESSION))) {
    SessionManager::addSessionValue('logout', 'true');
    header('location: Application/Utils/loginValidate.php');
    return;
}

if (array_key_exists('tipoUtilizador', $_SESSION)) {
    $tipoUtilizador = $_SESSION['tipoUtilizador'];

    $TipoUtilizadorManager = new TipoUtilizadorManager();
    $utilizadorManager = new UtilizadorManager();
    if ($tipoUtilizador == false || !is_numeric($tipoUtilizador) || !$TipoUtilizadorManager->existeTipoUtilizador($tipoUtilizador)
            || $tipoUtilizador != $TipoUtilizadorManager->getTipoUtilizadorByNome('Prestador de Serviço')->getId()  
            || $utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador() != $tipoUtilizador) {
        SessionManager::addSessionValue('logout', 'true');
        header('location: Application/Utils/loginValidate.php');
        return;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Resource/CSS/style1.css" >
        <script src="Resource/JavaScript/Model/jquery-2.2.4.js"></script>
        <script src="Resource/JavaScript/ofertasFavoritas.js"></script>
        <script src="Resource/JavaScript/ajaxHistorico.js"></script>
    </head>
    <body>
        <header id="cabecalho">
            <img src="./Resource/Images/logo.png">
            <h1>Ofertas de trabalho para todos!</h1>   
        </header>
        <nav id="menu">
            <ul>
                <li><a href="perfil.php?id=<?=$_SESSION['logged']?>">Perfil</a></li>
                <li><a href="pesquisa.php">Pesquisa de Ofertas de Trabalho</a></li>
                <li><a href="historico.php">Historico de Ofertas de Trabalho</a></li>
                <li><a href="areaUtilizador.php?logout">Logout</a></li>
            </ul>
        </nav>

        <nav id="navegacaoSegundaria">
            <ul>
                <li><a href="">Histórico de Ofertas de Trabalho Favoritas</a></li>
                <li><a href="candidatadas.php">Histórico de Ofertas de Trabalho Submetidas</a></li>
                <li><a href="finalizadasPrestador.php">Histórico de Ofertas de Trabalho Finalizadas</a></li>
            </ul>  
        </nav>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
