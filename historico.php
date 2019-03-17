<?php
require_once __DIR__ . './Application/Manager/SessionManager.php';

require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once (Conf::getApplicationUtilsPath() . './ofertasValidate.php');
require_once Conf::getApplicationManagerPath() . './TipoHorarioManager.php';
require_once Conf::getApplicationManagerPath() . './OfertasManager.php';
require_once Conf::getApplicationManagerPath() . './OfertaUtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . './CategoriaManager.php';
require_once Conf::getApplicationManagerPath() . './TipoUtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . './UtilizadorManager.php';
require_once Conf::getApplicationModelPath() . './TipoHorario.php';
require_once Conf::getApplicationModelPath() . './Ofertas.php';
require_once Conf::getApplicationModelPath() . './OfertaUtilizador.php';
require_once Conf::getApplicationModelPath() . './Categoria.php';
require_once Conf::getApplicationModelPath() . './TipoUtilizador.php';
require_once Conf::getApplicationModelPath() . './Utilizador.php';

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD' != 'GET') || (!array_key_exists('tipoUtilizador', $_SESSION))) {
    SessionManager::addSessionValue('logout', 'true');
    header('location: Application/Utils/loginValidate.php');
}

if (array_key_exists('tipoUtilizador', $_SESSION)) {
    $tipoUtilizador = $_SESSION['tipoUtilizador'];

    $TipoUtilizadorManager = new TipoUtilizadorManager();
    $utilizadorManager = new UtilizadorManager();
    if ($tipoUtilizador == false || !is_numeric($tipoUtilizador) || !$TipoUtilizadorManager->existeTipoUtilizador($tipoUtilizador) || !$utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador() == $tipoUtilizador) {
        SessionManager::addSessionValue('logout', 'true');
        header('location: Application/Utils/loginValidate.php');
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Resource/CSS/style1.css">
        <title></title>
    </head>
    <body>
        <header id="cabecalho">
            <img src="./Resource/Images/logo.png">
            <h1>Ofertas de trabalho para todos!</h1>   
        </header>
        <nav id="menu">
            <ul>
                <li><a href="perfil.php?id=<?= $_SESSION['logged'] ?>">Perfil</a></li>
                <?php if ($tipoUtilizador == $TipoUtilizadorManager->getTipoUtilizadorByNome('Empregador')->getId()) { ?>
                    <li><a href="criarOfertas.php">Criar Oferta de Trabalho</a></li>
                <?php } ?>
                <li><a href="pesquisa.php">Pesquisa de Ofertas de Trabalho</a></li>
                <li><a href="">Historico de Ofertas de Trabalho</a></li>
                <li><a href="areaUtilizador.php?logout">Logout</a></li>
            </ul>
        </nav>

        <nav id="navegacaoSegundaria">
            <ul>
                <?php if ($tipoUtilizador == $TipoUtilizadorManager->getTipoUtilizadorByNome('Empregador')->getId()) { ?>
                    <li><a href="temporarias.php">Histórico de Ofertas de Trabalho Temporárias</a></li>
                    <li><a href="pendentes.php">Histórico de Ofertas de Trabalho Pendentes</a></li>
                    <li><a href="publicadas.php">Histórico de Ofertas de Trabalho Publicadas</a></li>
                    <li><a href="expiradas.php">Histórico de Ofertas de Trabalho Expiradas</a></li>
                    <li><a href="finalizadas.php">Historico de Ofertas de Trabalho Finalizadas</a></li>
                <?php } else { ?>
                    <li><a href="favoritas.php">Histórico de Ofertas de Trabalho Favoritas</a></li>
                    <li><a href="candidatadas.php">Histórico de Ofertas de Trabalho Submetidas</a></li>
                    <li><a href="finalizadasPrestador.php">Historico de Ofertas de Trabalho Finalizadas</a></li>
                <?php }
                ?>
                
            </ul>
        </nav>
        <section>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
