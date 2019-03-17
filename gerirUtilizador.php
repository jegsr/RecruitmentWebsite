<?php
require_once __DIR__ . './Application/Manager/SessionManager.php';

require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'MoradaManager.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');
require_once (Conf::getApplicationModelPath() . 'TipoUtilizador.php');
require_once (Conf::getApplicationModelPath() . 'Morada.php');

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
                <li><a href="">Gerir Utilizadores</a></li>
                <li><a href="gerirOfertas.php">Gerir Ofertas</a></li>
                <li><a href="areaAdmin.php?logout">Logout</a></li>
            </ul>
        </nav>
        <section id="ofertasEmprego">
            <?php
            $utilizadorManager = new UtilizadorManager();
            $utilizador = $utilizadorManager->getUtilizador();
            if (count($utilizador) > 0) {
                foreach ($utilizador as $utilizadorAtual) {
                    if ($utilizadorAtual->getTipoUtilizador() != null) {
                        ?>
                        <article id ="<?= $utilizadorAtual->getEmail() ?>">
                            <fieldset>
                                <legend>Dados Pessoais</legend>
                                <h1>Nome</h1>
                                <h3><?= $utilizadorAtual->getNome() ?></h3>
                                <fieldset id="morada">
                                    <legend>Morada</legend>
                                    <?php
                                    $moradaManager = new MoradaManager();

                                    $morada = $moradaManager->getMoradaById($utilizadorAtual->getMorada());
                                    ?>
                                    <h1>Distrito</h1>
                                    <h3><?= $morada->getDistrito() ?></h3>
                                    <h1>Concelho</h1>
                                    <h3><?= $morada->getConcelho() ?></h3>
                                    <h1>Rua</h1>
                                    <h3><?= $morada->getRua() ?></p>
                                        <h1>Codigo Postal</h1>
                                        <h3><?= $morada->getCp1() . '-' . $morada->getCp2() ?></h3>

                                </fieldset>
                                <h1>Contacto</h1>
                                <h3><?= $utilizadorAtual->getContacto() ?></h3>
                            </fieldset>
                            <button class="visualizarPerfil" type="button">Visualizar Perfil</button>
                            <button class="eliminarUtilizador" type="button">Eliminar</button>
                        </article>
                    <?php
                    }
                }
            } else {
                ?><h1>Não existe utilizadores</h1><?php
            }
            ?>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
