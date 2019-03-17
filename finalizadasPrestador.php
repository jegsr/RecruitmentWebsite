<?php
require_once __DIR__ . './Application/Manager/SessionManager.php';

require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once Conf::getApplicationManagerPath() . './TipoHorarioManager.php';
require_once Conf::getApplicationManagerPath() . './OfertasManager.php';
require_once Conf::getApplicationManagerPath() . './OfertaUtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . './TipoUtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . './UtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . './CandidaturaManager.php';
require_once Conf::getApplicationModelPath() . './TipoHorario.php';
require_once Conf::getApplicationModelPath() . './Candidatura.php';
require_once Conf::getApplicationModelPath() . './Ofertas.php';
require_once Conf::getApplicationModelPath() . './OfertaUtilizador.php';
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
    if ($tipoUtilizador == false || !is_numeric($tipoUtilizador) || !$TipoUtilizadorManager->existeTipoUtilizador($tipoUtilizador) || $TipoUtilizadorManager->getTipoUtilizadorByNome('Prestador de Serviço')->getId() != $tipoUtilizador || $utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador() != $tipoUtilizador) {
        SessionManager::addSessionValue('logout', 'true');
        header('location: Application/Utils/loginValidate.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Resource/CSS/style1.css">
        <script src="Resource/JavaScript/Model/jquery-2.2.4.js"></script>
        <script src="Resource/JavaScript/ajaxHistorico.js"></script>
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
                <li><a href="pesquisa.php">Pesquisa de Ofertas de Trabalho</a></li>
                <li><a href="historico.php">Historico de Ofertas de Trabalho</a></li>
                <li><a href="areaUtilizador.php?logout">Logout</a></li>
            </ul>
        </nav>

        <nav id="navegacaoSegundaria">
            <ul>
                <li><a href="favoritas.php">Histórico de Ofertas de Trabalho Favoritas</a></li>
                <li><a href="candidatadas.php">Histórico de Ofertas de Trabalho Submetidas</a></li>
                <li><a href="">Histórico de Ofertas de Trabalho Finalizadas</a></li>
            </ul>

        </nav>
        <section id="ofertasEmprego">
            <?php
            $ofertasManager = new OfertasManager();
            $ofertaUtilizadorManager = new OfertaUtilizadorManager();
            $candidaturaManager = new CandidaturaManager();

            $dateNow = date('Y-m-d');


            $listOfertas = $ofertasManager->getsOfertas();
            $listOfertasUtilizador = $ofertaUtilizadorManager->getOfertaUtilizadorByUser($_SESSION['logged']);
            $listCandidatura = $candidaturaManager->getCandidaturaByUser($_SESSION['logged']);


            if (count($listCandidatura) > 0) {
                foreach ($listOfertas as $obj) {
                    foreach ($listOfertasUtilizador as $obj2) {
                        foreach ($listCandidatura as $obj3) {
                            if (($obj->getId()) == ($obj2->getOferta()) && $obj->getId() == $obj3->getOferta() && $dateNow > ($obj2->getDataFim()) && $obj2->getVencedor() != null) {
                                
                                ?> <article id="<?= $obj->getId() ?>">
                                    <fieldset>
                                        <legend>Dados da Oferta de Trabalho</legend>
                                        <h1>Titulo:</h1>
                                        <h3><?= $obj->getTitulo(); ?></h3> 
                                        <h1>Categoria:</h1> 
                                        <h3><?= $obj->getCategoria(); ?></h3> 
                                        <h1>Categoria Especifica:</h1> 
                                        <h3><?= $obj->getSubCategoria(); ?></h3> 
                                        <h1>Remuneração:</h1>
                                        <h3><?= $obj->getRemuneracao(); ?>€</h3> 
                                    </fieldset>
                                    <fieldset>
                                        <legend>Limite da Oferta de Trabalho</legend>
                                        <h1>Data Inicio:</h1>  
                                        <h3><?= $obj2->getDataInicio(); ?></h3> 
                                        <h1>Data Fim:</h1> 
                                        <h3><?= $obj2->getDataFim(); ?></h3> 
                                    </fieldset>
                                    <button class="visualizar">Visualizar</button>
                                </article>

                    <?php
                }
            }
        }
    }
} else {
    ?><h1>Não existe ofertas finalizadas</h1><?php
            }
            ?>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>

