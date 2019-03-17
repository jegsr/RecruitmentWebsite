<?php
require_once (realpath(dirname(__FILE__)) . './Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'SessionManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertasManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertaUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'MoradaManager.php');
require_once (Conf::getApplicationManagerPath() . 'CandidaturaManager.php');
require_once (Conf::getApplicationModelPath() . 'Candidatura.php');
require_once (Conf::getApplicationModelPath() . 'Ofertas.php');
require_once (Conf::getApplicationModelPath() . 'Morada.php');
require_once (Conf::getApplicationModelPath() . 'OfertaUtilizador.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');
require_once (Conf::getApplicationModelPath() . 'TipoUtilizador.php');


if (filter_input(INPUT_SERVER, 'REQUEST_METHOD' != 'GET') || (!filter_has_var(INPUT_GET, 'id'))) {

    header('location: areaUtilizador.php');
}

if (filter_has_var(INPUT_GET, 'id')) {
    $id_oferta = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $ofertasManager = new OfertasManager();

    if ($id_oferta == false || !is_numeric($id_oferta) || !$ofertasManager->existeOfertasById($id_oferta)) {
        header('location: areaUtilizador.php');
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="Resource/CSS/style1.css">
        <script src="Resource/JavaScript/ajaxHistorico.js"></script>
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
                        $empregador = true;
                        ?>
                        <li><a href="criarOfertas.php">Criar Oferta de Trabalho</a></li>

                    <?php } ?>
                    <li><a href="historico.php">Historico de Ofertas de Trabalho</a></li>
                    <li><a href="areaUtilizador.php?logout">Logout</a></li>
                    <?php
                } else {
                    ?>
                    <li><a href="pesquisa.php">Pesquisa de Ofertas de Trabalho</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="pesquisa.php">Ofertas de Trabalho</a></li>
                <?php } ?>

            </ul>
        </nav>

        <nav id="navegacaoSegundaria">
            <ul>
                <?php
                if ($empregador === true) {
                    ?>
                    <li><a href="temporarias.php">Histórico de Ofertas de Trabalho Temporárias</a></li>
                    <li><a href="pendentes.php">Historico de Ofertas de Trabalho Pendentes</a></li>
                    <li><a href="publicadas.php">Historico de Ofertas de Trabalho Publicadas</a></li>

                    <li><a href="expiradas.php">Historico de Ofertas de Trabalho Expiradas</a></li>
                <?php } else { ?>
                    <li><a href="finalizadas.php">Historico de Ofertas de Trabalho Finalizadas</a></li>
                <?php } ?>
            </ul>  
        </nav>
        <section id="ofertasEmprego">
            <?php
            $ofertasManager = new OfertasManager();
            $ofertaUtilizadorManager = new OfertaUtilizadorManager();

            $dateNow = date('Y-m-d');


            $Ofertas = $ofertasManager->getOfertaById($id_oferta);

            $OfertasUtilizador = $ofertaUtilizadorManager->getOfertaUtilizadorByOferta($id_oferta);
            $utilizador = $utilizadorManager->getUtilizadorByEmail($OfertasUtilizador->getUtilizador());

            $moradaManager = new MoradaManager();
            $morada = $moradaManager->getMoradaById($utilizador->getMorada());
            if ($Ofertas->getId() == $OfertasUtilizador->getOferta() && $OfertasUtilizador->getUtilizador() == $utilizador->getEmail() && $morada->getId() == $utilizador->getMorada()) {
                ?> 
                <article id="<?= $Ofertas->getId() ?>">
                    <fieldset>
                        <legend>Dados do Empregador</legend>
                        <h1>Nome:</h1>
                        <h3><?= $utilizador->getNome() ?></h3>
                        <fieldset id="morada">
                            <legend>Morada</legend>
                            <h1>Distrito:</h1>
                            <h3><?= $morada->getDistrito() ?></h3>
                            <h1>Concelho:</h1>
                            <h3><?= $morada->getConcelho() ?></h3>
                            <h1>Rua:</h1>
                            <h3><?= $morada->getRua() ?></h3>
                            <h1>Codigo-Postal:</h1>
                            <h3><?= $morada->getCp1() . '-' . $morada->getCp2() ?></h3>
                        </fieldset>
                        <h1>Contacto:</h1>
                        <h3><?= $utilizador->getContacto() ?></h3>
                    </fieldset>
                    <fieldset>
                        <legend>Dados da Oferta de Trabalho</legend>
                        <h1>Titulo:</h1>
                        <h3><?= $Ofertas->getTitulo() ?></h3> 
                        <h1>Descritivo:</h1> 
                        <h3><?= $Ofertas->getDescritivo(); ?></h3> 
                        <h1>Requisitos:</h1> 
                        <h3><?= $Ofertas->getRequisitos(); ?></h3> 

                        <h1>Categoria:</h1> 
                        <h3><?= $Ofertas->getCategoria(); ?></h3> 
                        <h1>Categoria Especifica:</h1> 
                        <h3><?= $Ofertas->getSubCategoria(); ?></h3> 
                        <h1>Remuneração:</h1>
                        <h3><?= $Ofertas->getRemuneracao(); ?>€</h3> 
                    </fieldset>
                    <fieldset>
                        <legend>Limite da Oferta de Trabalho</legend>
                        <h1>Data Inicio:</h1>  
                        <h3><?= $OfertasUtilizador->getDataInicio(); ?></h3> 
                        <h1>Data Fim:</h1> 
                        <h3><?= $OfertasUtilizador->getDataFim(); ?></h3> 
                    </fieldset>


                    <fieldset id="candidatos"><?php
                        if (($vencedor = $OfertasUtilizador->getVencedor() ) == null) {
                            ?>
                            <legend>Utilizadores Candidatados</legend>
                            <?php
                            $candidaturaManager = new CandidaturaManager();
                            $listcandidatura = $candidaturaManager->getCandidaturaByOferta($id_oferta);

                            if (count($listcandidatura) > 0) {

                                foreach ($listcandidatura as $value) {
                                    $utilizador = $utilizadorManager->getUtilizadorByEmail($value->getUser());
                                    ?>
                                    <article id="<?= $utilizador->getEmail() ?>">
                                        <h1>Nome:</h1>
                                        <h3><?= $utilizador->getNome() ?></h3>
                                        <button class="visualizarPerfil">Visualizar Perfil</button>
                                        <button class="selecionar">Selecionar Candidato</button>
                                    </article>
                                    <?php
                                }
                            } else {
                                ?>
                                <h1>Oferta sem candidatos</h1>
                                <?php
                            }
                        } else {
                            ?>
                            <legend>Utilizador Vencedor</legend>
                            <article id="<?= $utilizadorManager->getUtilizadorByEmail($vencedor)->getEmail() ?>">
                                <h1>Nome</h1>
                                <h3><?= $utilizadorManager->getUtilizadorByEmail($vencedor)->getNome() ?></h3>
                                <button id="visualizar">Visualizar Perfil</button>
                            </article>
                        <?php }
                        ?>
                    </fieldset>
                </article><?php
            } else {
                ?>
                <h1>Oferta Indisponivel</h1>
                <?php
            }
            ?>
        </section>
        <footer id="rodape">
            <p>@20152016 Programação em Ambiente Web
                All rights reserved to <strong>Ofertas de trabalho para todos!</strong></p>
        </footer>
    </body>
</html>
