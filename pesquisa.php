<?php
require_once __DIR__ . './Application/Manager/SessionManager.php';

require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'DistritoManager.php');
require_once (Conf::getApplicationManagerPath() . 'CategoriaManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertaUtilizadorManager.php');
require_once (Conf::getApplicationModelPath() . 'Distrito.php');
require_once (Conf::getApplicationModelPath() . 'Categoria.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');
require_once (Conf::getApplicationModelPath() . 'TipoUtilizador.php');
require_once (Conf::getApplicationModelPath() . 'OfertaUtilizador.php');

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD' != 'GET')) {
    SessionManager::addSessionValue('logout', 'true');
    header('location: Application/Utils/loginValidate.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Resource/CSS/style1.css">
        <script src="Resource/JavaScript/Model/jquery-2.2.4.js"></script>
        <script src="Resource/JavaScript/ajaxPesquisa.js"></script>
    </head>
    <body>
        <header id="cabecalho">
            <img src="./Resource/Images/logo.png">
            <h1>Ofertas de trabalho para todos!</h1>   
        </header>
        <nav id="menu">
            <ul>
                <?php
                $utilizadorManager = new UtilizadorManager();
                if (array_key_exists('logged', $_SESSION) && array_key_exists('serial', $_SESSION) &&
                        array_key_exists('tipoUtilizador', $_SESSION) && $utilizadorManager->existeSerial($_SESSION['logged'], $_SESSION['serial'])) {
                    ?>
                    <li><a href="perfil.php?id=<?=$_SESSION['logged']?>">Perfil</a></li>
                    <?php
                    $tipoUtilizadorManager = new TipoUtilizadorManager();
                    if ($_SESSION['tipoUtilizador'] == $tipoUtilizadorManager->getTipoUtilizadorByNome('Empregador')->getId() && $_SESSION['tipoUtilizador'] == $utilizadorManager->getUtilizadorByEmail($_SESSION['logged'])->getTipoUtilizador()) {
                        ?>
                        <li><a href="criarOfertas.php">Criar Oferta de Trabalho</a></li>
                    <?php } ?>
                    <li><a href="">Pesquisa de Ofertas de Trabalho</a></li>
                    <li><a href="historico.php">Historico de Ofertas de Trabalho</a></li>
                    <li><a href="areaUtilizador.php?logout">Logout</a></li>
                    <?php
                } else {
                    ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="">Ofertas de Trabalho</a></li>
                <?php } ?>
            </ul>
        </nav>
        <div id ="pesquisa">

            <fieldset id="tipo">
                <label>Tipo Horario:</label>
                <input type="radio" name="tipoHorario" value="1"><p>Full-Time</p>
                <input type="radio" name="tipoHorario" value="2"><p>Part-Time</p>
                <input type="radio" name="tipoHorario" value="3" checked><p>Todos</p>
            </fieldset>
            <fieldset>
                <label for="textoPesquisa">Pesquisa:</label>
                <input type="text" id="textoPesquisa" name="pesquisa" placeholder="Pesquisa ofertas de emprego">


                <label>Categoria:</label>
                <select name ="categoria" id="categoria">
                    <option></option>
                    <?php
                    $categoriaManager = new CategoriaManager();
                    $list = $categoriaManager->getsCategoria();
                    foreach ($list as $value) {
                        ?><option value=<?= $value->getName() ?>><?= $value->getName() ?> </option>
                        <?php
                    }
                    ?>
                </select>

                <label>Sub-Categorias:</label>
                <input type="text" id="subCategoria" name="subCategoria">
            </fieldset>
            <fieldset>
                <label>Distrito:</label>
                <select name="distrito" id="distrito" >
                    <option></option>
                    <?php
                    $distritoManager = new DistritoManager();
                    $list = $distritoManager->getsDistrito();
                    foreach ($list as $value) {
                        ?><option value=<?= $value->getNome() ?>><?= $value->getNome() ?> </option>
                        <?php
                    }
                    ?>
                </select>

                <label>Concelho:</label>
                <input type="text" id="concelho" name="concelho" >
            </fieldset>
            <input type="submit" id="Pesquisar" name="Pesquisar">

        </div>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
