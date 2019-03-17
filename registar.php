<?php
require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once Conf::getApplicationUtilsPath() . './registerValidate.php';
require_once Conf::getApplicationManagerPath() . './TipoUtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . './DistritoManager.php';
require_once Conf::getApplicationModelPath() . './TipoUtilizador.php';
require_once Conf::getApplicationModelPath() . './Distrito.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registar</title>
        <link rel="stylesheet" href="Resource/CSS/style1.css">
        <script src="Resource/JavaScript/Model/jquery-2.2.4.js"></script>
        <script src="Resource/JavaScript/validarRegisto.js"></script>
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
        <section id="registar">
            <?php
            if (count($erros) > 0) {
                ?>  <ul> <?php
                    foreach ($erros as $key => $value) {
                        if (!is_string($value)) {


                            if (count($value) > 1) {
                                ?> <li><?= $key . ':' ?></li>
                                <ul><?php
                                }

                                foreach ($value as $valorArray) {
                                    ?><li><?= $valorArray ?></li>
                                    <?php
                                }
                                if (count($value) > 1) {
                                    ?> 
                                </ul>
                                <?php
                            }
                        } else {
                            ?> <li>   <?= $value ?> </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            <?php }
            ?> 
            <form action="" method="post" enctype="multipart/form-data">
                <fieldset id="tipo">
                    <label>Tipo de Utilizador:</label>
                    <?php
                    $tipoUtilizadorManager = new TipoUtilizadorManager();

                    $list = $tipoUtilizadorManager->getsTipoUtilizador();

                    foreach ($list as $obj) {
                        ?> <input type="radio" name="tipoUtilizador" value=<?= $obj->getId() ?> checked>
                        <p><?= $obj->getNome() ?></p> 
                        <?php
                    }
                    ?>
                </fieldset>
                <fieldset>
                    <label for="email">Email</label><input type="text" id="email" name="email" > 

                    <label for="password">Palavra-Chave</label><input type="password" id="password" name="password" > 

                    <label id="nome" for="name">Nome da Empresa</label><input type="text" id="name" name="name" >

                    

                        <label for="rua">Rua</label><input type="text" id="rua" name="rua" >

                        <fieldset id="cp">
                            <label for="cp1">Codigo-Postal</label><input type="number" min="0" max="999" name="cp2" ><p>-</p><input type="number" id="cp1" name="cp1" min="1000"max="9999">
                        </fieldset>
                        <label>Distrito</label>

                        <select name ="distrito" >
                            <option value=""></option>
                            <?php
                            $distritoManager = new DistritoManager();

                            $list = $distritoManager->getsDistrito();

                            foreach ($list as $value) {
                                ?><option value=<?= $value->getNome() ?>><?= $value->getNome() ?> </option>
                                <?php
                            }
                            ?>
                        </select>

                        <label for="concelho">Concelho</label><input type="text" id="concelho" name="concelho">
                    

                    <label for="contact">Contacto</label><input type="text" id="contact" name="contact" >

                </fieldset>
                <input type="reset" name="clear" id="clear">
                <input type="submit" value="Registar" name="Registar"> 
            </form>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
