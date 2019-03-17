<?php
require_once __DIR__ . './Application/Manager/SessionManager.php';

require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Resource/CSS/style1.css">
    </head>
    <body>
        <header id="cabecalho">
            <img src="./Resource/Images/logo.png">
            <h1>Ofertas de trabalho para todos!</h1>
        </header>
        <nav id="menu">
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="pesquisa.php">Ofertas de Trabalho</a></li>
            </ul>
        </nav>
        <section id = "LoginAction">
            <?php
            $utilizadorManager = new UtilizadorManager();

            if (!array_key_exists('logged', $_SESSION)) {
                if (filter_input(INPUT_GET, 'login', FILTER_SANITIZE_STRING) == 'Invalido') {
                    ?>
                    <h1 class="loginInvalido">DADOS INVALIDOS</h1>
                    <?php
                    if (array_key_exists('erros', $_SESSION)) {
                        $erros = json_decode($_SESSION['erros'])
                        ?><ul><?php
                            foreach ($erros as $value) {
                                ?><li><?= $value ?></li><?php }
                            ?>
                        </ul><?php
                        SessionManager::destroySession('erros');
                    }
                }


                if (array_key_exists('email', $_COOKIE) && array_key_exists('serial', $_COOKIE) && $utilizadorManager->existeSerial($_COOKIE['email'], $_COOKIE['serial'])) {
                    SessionManager::addSessionValue('logged', $_COOKIE['email']);


                    $utilizadorAtual = $utilizadorManager->getUtilizadorByEmail($_COOKIE['email']);

                    $utilizadorAtual->setSerial($utilizadorAtual->generatorSerial());


                    $utilizadorManager->updateUtilizador($utilizadorAtual);

                    setcookie('serial', $utilizadorAtual->getSerial(), time() + (60 * 60 * 24 * 360), "/");

                    SessionManager::addSessionValue('serial', $utilizadorAtual->getSerial());
                    SessionManager::addSessionValue('tipoUtilizador', $utilizadorAtual->getTipoUtilizador());

                    if ($utilizadorAtual->getTipoUtilizador() == null) {
                        header('location:./areaAdmin.php');
                    } else {
                        header('location:./areaUtilizador.php');
                    }
                }
            } else {
                if ($utilizadorManager->existeSerial($_SESSION['logged'], $_SESSION['serial'])) {
                    if ($_SESSION['tipoUtilizador'] == null && $utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador() == null) {
                        header('location:./areaAdmin.php');
                    } else {
                        header('location:./areaUtilizador.php');
                    }
                }
            }
            ?>

            <form action="Application/Utils/loginValidate.php" method="POST">
                <fieldset>
                    <label for="email">Email</label><input id="email" type="text" name="email" placeholder="Inserir email">
                </fieldset>
                <fieldset>
                    <label for="pass">Password</label><input id="pass" type="password" name="pass" placeholder="Inserir password">
                </fieldset>
                <label for="remember">Remember-me?</label><input id="remember" type="checkbox" value="remember" name="remember">  
                <input id="login" type="submit" value="Login" name="Login">
                <input id="registo" type="submit" value="Registar" name="Registar">
            </form>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
