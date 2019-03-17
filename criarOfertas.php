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
    return;
}

if (array_key_exists('tipoUtilizador', $_SESSION)) {
    $tipoUtilizador = $_SESSION['tipoUtilizador'];

    $TipoUtilizadorManager = new TipoUtilizadorManager();
    $empregador = $TipoUtilizadorManager->getTipoUtilizadorByNome('Empregador');
    $utilizadorManager = new UtilizadorManager();
    if ($tipoUtilizador == false || !is_numeric($tipoUtilizador) || !$TipoUtilizadorManager->existeTipoUtilizador($tipoUtilizador) 
            || $empregador->getId() != $tipoUtilizador 
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
        <title>Registar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Resource/CSS/style1.css">
        <script src="Resource/JavaScript/saveLocalStorage.js"></script> 
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
                <li><a href="historico.php">Historico de Ofertas de Trabalho</a></li>
                <li><a href="areaUtilizador.php?logout">Logout</a></li>
            </ul>
        </nav>
        <section id="criarOferta">
            <h1>Nova Oferta</h1>
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
            <form action="" method="get">
                <fieldset>
                    <label for="titulo">Titulo:</label><input type="text" id="titulo" value="<?= (($titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING)) != false) ? $titulo : '' ?>" name="titulo" >


                    <label for="descritivo">Descritivo:</label>
                    <textarea id="descritivo" name="descritivo"><?= (($descritivo = filter_input(INPUT_GET, 'descritivo', FILTER_SANITIZE_STRING)) != false) ? $descritivo : '' ?></textarea>


                    <label for="requisitos">Requisitos do Trabalho:</label><input type="text" id="requisitos"  value="<?= (($requisitos = filter_input(INPUT_GET, 'requisitos', FILTER_SANITIZE_STRING)) != false) ? $requisitos : '' ?>" name="requisitos" >
                    <label>Categoria Geral:</label>
                    <select name ="categoria" id="categoria">
                        <option value=""></option>
<?php
$candidaturaManager = new CategoriaManager();

$list = $candidaturaManager->getsCategoria();

foreach ($list as $value) {
    ?><option value="<?= $value->getName() ?>"  <?php (filter_input(INPUT_GET, 'categoria', FILTER_SANITIZE_STRING) == $value->getName()) ? "selected" : '' ?>><?= $value->getName() ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="categoriaespecifica">Categoria Especifica:</label><input type="text" id="categoriaespecifica"
                                                                                         value="<?= (($categoriaespecifica = filter_input(INPUT_GET, 'categoriaespecifica', FILTER_SANITIZE_STRING)) != false) ? $categoriaespecifica : '' ?>" name="categoriaespecifica" >
                    <label for="remuneracao">Remuneração:</label><input type="number" id="remuneracao" value="<?= (($remuneracao = filter_input(INPUT_GET, 'remuneracao', FILTER_SANITIZE_STRING)) != false) ? $remuneracao : '' ?>" name="remuneracao" >
                </fieldset>
                <fieldset id="tipohorario"> 
                    <label>Tipo de Horario:</label>
<?php
$tipoHorarioManager = new TipoHorarioManager();

$list = $tipoHorarioManager->getsTipoHorario();

foreach ($list as $obj) {
    ?> <input type="radio" id="tipoHorario" name="tipoHorario" value="<?= $obj->getId() ?>" <?php (filter_input(INPUT_GET, 'tipoHorario', FILTER_SANITIZE_STRING) == $obj->getId() ) ? "checked" : '' ?>>
                        <p><?= $obj->getNome() ?></p> 
                        <?php
                    }
                    ?>

                </fieldset>
                <fieldset>
                    <label for="dataInicio">Data de Inicio:</label><input type="date" id="dataInicio" 
                                                                          value="<?php (($dataInicio = filter_input(INPUT_GET, 'dataInicio', FILTER_SANITIZE_STRING)) != false ) ? $dataInicio : '' ?>" name="dataInicio" >
                    <label for="dataFim">Data de Fim:</label><input type="date" id="dataFim" value="<?php (($dataFim = filter_input(INPUT_GET, 'dataFim', FILTER_SANITIZE_STRING)) != false ) ? $dataFim : '' ?>" name="dataFim" >
                </fieldset>
                <input type="reset" name="clear" id="clear">
                <input type="submit" value="Criar" name="Criar"> 

                <button id="storeOferta" type="button">Guardar Oferta</button>


            </form>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>

