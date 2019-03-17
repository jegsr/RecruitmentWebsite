<?php
require_once __DIR__ . './Application/Manager/SessionManager.php';

require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php');
require_once Conf::getApplicationManagerPath() . './OfertasManager.php';
require_once Conf::getApplicationManagerPath() . './TipoHorarioManager.php';
require_once Conf::getApplicationManagerPath() . './OfertaUtilizadorManager.php';
require_once Conf::getApplicationModelPath() . './TipoHorario.php';
require_once Conf::getApplicationModelPath() . './Ofertas.php';
require_once Conf::getApplicationModelPath() . './OfertaUtilizador.php';
require_once Conf::getApplicationModelPath() . './TipoUtilizador.php';
require_once Conf::getApplicationModelPath() . './Utilizador.php';


if (array_key_exists('tipoUtilizador', $_SESSION)) {
    $tipoUtilizador = $_SESSION['tipoUtilizador'];

    $utilizadorManager = new UtilizadorManager();
    if ($tipoUtilizador != null || is_numeric($tipoUtilizador) || !$utilizadorManager->existeSerial($_SESSION['logged'], $_SESSION['serial']) || !$utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador() == $tipoUtilizador) {
        SessionManager::addSessionValue('logout', '');
        $_SESSION['tipoUtilizador'] = 'null';
        header('location: Application/Utils/loginValidate.php');
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Resource/CSS/style1.css">
        <script src="Resource/JavaScript/Model/jquery-2.2.4.js"></script>
        <script src="Resource/JavaScript/ajaxHistorico.js"></script>
    </head>
    <body>
        <header id="cabecalho">
            <img src="./Resource/Images/logo.png">
            <h1>Ofertas de trabalho para todos!</h1>   
        </header>
        <nav id="menu">
            <ul>
                <li><a href="gerirUtilizador.php">Gerir Utilizadores</a></li>
                <li><a href="">Gerir Ofertas</a></li>
                <li><a href="areaAdmin.php?logout">Logout</a></li>
            </ul>
        </nav>
        <section id="ofertasEmprego">
            <?php
            $ofertasManager = new OfertasManager();
            $ofertaUtilizadorManager = new OfertaUtilizadorManager();

            $dateNow = date('Y-m-d');


            $listOfertas = $ofertasManager->getsOfertas();
            $listOfertasUtilizador = $ofertaUtilizadorManager->getsOfertaUtilizador();
            if (count($listOfertasUtilizador) > 0 && count($listOfertas) > 0) {
                foreach ($listOfertas as $obj) {
                    foreach ($listOfertasUtilizador as $obj2) {
                        if (($obj->getId()) == ($obj2->getOferta())) {
                            ?> 
                            <article id="<?= $obj->getId() ?>">
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
                                <button class="Desativar">Desativar</button>
                            </article>
                            <?php
                        }
                    }
                }
            } else {
                ?><h1>Não existe ofertas</h1><?php
            }
            ?>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
