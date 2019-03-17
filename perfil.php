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

$utilizadorManager = new UtilizadorManager();

if (!filter_has_var(INPUT_GET, 'id') || !array_key_exists('logged', $_SESSION) || !array_key_exists('serial', $_SESSION) || !array_key_exists('tipoUtilizador', $_SESSION) || !$utilizadorManager->existeSerial($_SESSION['logged'], $_SESSION['serial'])) {
    header('location: ./login.php');
}

if (filter_has_var(INPUT_GET, 'id')) {
    $email = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

    if ($email == false || !is_string($email) || !$utilizadorManager->existeEmail($email)) {
        header('location: login.php');
    }

    $utilizadorAtual = $utilizadorManager->getUtilizadorByEmail($email);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Perfil</title>
        <link rel="stylesheet" href="Resource/CSS/style1.css"
        <script src="editarInformacao.js"></script>

    </head>
    <body>

        <header id="cabecalho">
            <img src="./Resource/Images/logo.png">
            <h1>Ofertas de trabalho para todos!</h1>   
        </header>
        <nav id="menu">
            <ul>
                <?php
                if (array_key_exists('logged', $_SESSION) && array_key_exists('serial', $_SESSION) &&
                        array_key_exists('tipoUtilizador', $_SESSION) && $utilizadorManager->existeSerial($_SESSION['logged'], $_SESSION['serial'])) {
                    if ($_SESSION['tipoUtilizador'] == null) {
                        ?>
                        <li><a href = "gerirUtilizador.php">Gerir Utilizadores</a></li>
                        <li><a href = "gerirOfertas.php">Gerir Ofertas</a></li>
                        <li><a href = "areaAdmin.php?logout">Logout</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="">Perfil</a></li>
                        <?php
                        $tipoUtilizadorManager = new TipoUtilizadorManager();

                        if ($_SESSION['tipoUtilizador'] == $tipoUtilizadorManager->getTipoUtilizadorByNome('Empregador')->getId() && $_SESSION['tipoUtilizador'] == $utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador()) {
                            $empregador = true;
                            ?>
                            <li><a href="criarOfertas.php">Criar Oferta de Trabalho</a></li>

                        <?php } ?>
                        <li><a href="pesquisa.php">Pesquisa de Ofertas de Trabalho</a></li>
                        <li><a href="historico.php">Historico de Ofertas de Trabalho</a></li>
                        <li><a href="areaUtilizador.php?logout">Logout</a></li>
                        <?php
                    }
                } else {
                    ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="pesquisa.php">Ofertas de Trabalho</a></li>
                <?php } ?>

            </ul>
        </nav>
        <section id="ofertasEmprego">
            <article id ="<?= $utilizadorAtual->getEmail() ?>">
                <figure>
                    <img src='<?php
                    if ($utilizadorAtual->getFoto() != NULL) {
                        echo $utilizadorAtual->getFoto();
                    } else {
                        echo Conf::getImagesPathBase() . "semFoto.png";
                    }
                    ?>
                         'alt="foto">

                    <h4><?= $utilizadorAtual->getNome() ?></h4>
                </figure> 

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

                <!-- <button id="editar" type="button">Editar</button> !-->
            </article>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
