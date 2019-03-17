<?php

require_once '../Manager/SessionManager.php';
$erros = array();

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'POST') {
    return;
}

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'OfertasManager.php');
require_once (Conf::getApplicationManagerPath() . 'DistritoManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoHorarioManager.php');
require_once (Conf::getApplicationManagerPath() . 'CategoriaManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'UtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'CandidaturaManager.php');
require_once (Conf::getApplicationModelPath() . 'Ofertas.php');
require_once (Conf::getApplicationModelPath() . 'TipoHorario.php');
require_once (Conf::getApplicationModelPath() . 'Distrito.php');
require_once (Conf::getApplicationModelPath() . 'Categoria.php');
require_once (Conf::getApplicationModelPath() . 'TipoUtilizador.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');
require_once (Conf::getApplicationModelPath() . 'Candidatura.php');

$tipoHorarioManager = new TipoHorarioManager();
$ofertasManager = new OfertasManager();
$categoriaManager = new CategoriaManager();
$distritoManager = new DistritoManager();

$pesquisa = array();


if (filter_has_var(INPUT_POST, 'candidatar')) {
    $id_oferta = filter_input(INPUT_POST, 'id_oferta', FILTER_SANITIZE_NUMBER_INT);

    if ($id_oferta == false || !is_numeric($id_oferta) || !$ofertasManager->existeOfertasById($id_oferta)) {
        
    } else {

        $candidaturaManager = new CandidaturaManager();

        $candidatura = new Candidatura();

        $candidatura->setUser($_SESSION['logged']);
        $candidatura->setOferta($id_oferta);


        echo $candidaturaManager->InsertCandidatura($candidatura);
    }
}

if (filter_has_var(INPUT_POST, 'favorito')) {
    $id_oferta = filter_input(INPUT_POST, 'id_oferta', FILTER_SANITIZE_NUMBER_INT);

    if ($id_oferta == false || !is_numeric($id_oferta) || !$ofertasManager->existeOfertasById($id_oferta)) {
        
    } else {

        $pesquisa['ofertas.id'] = $id_oferta;
        $results = $ofertasManager->getsOfertasForSearch($pesquisa);



        $list = array();



        foreach ($results as $key => $value) {
            $list[$key] = $value->convertObjectToArray();
        }

        echo json_encode($list);
    }
} else {

    if (filter_has_var(INPUT_POST, 'tipoHorario') && filter_input(INPUT_POST, 'tipoHorario', FILTER_SANITIZE_NUMBER_INT) != 3) {

        $pesquisa['ofertas.tipoHorario'] = filter_input(INPUT_POST, 'tipoHorario', FILTER_SANITIZE_NUMBER_INT);

        if ($pesquisa['ofertas.tipoHorario'] == false || !is_numeric($pesquisa['ofertas.tipoHorario'])) {
            $erros['tipoHorario'] = 'Tipo de Horario não selecionado';
        } else {
            if (!$tipoHorarioManager->existeTipoHorario($pesquisa['ofertas.tipoHorario'])) {
                $erros['tipoHorario'] = 'Tipo de Horario não existe';
            }
        }
    }

    if (filter_has_var(INPUT_POST, 'categoria') && filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING) != false) {
        $pesquisa['ofertas.categoria'] = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);

        if (!is_string($pesquisa['ofertas.categoria'])) {
            $erros['categoria'] = 'Categoria não selecionado';
        } else {

            if (!$categoriaManager->existeCategoria($pesquisa['ofertas.categoria'])) {
                $erros['categoria'] = 'Categoria não existe';
            }
        }
    }

    if (filter_has_var(INPUT_POST, 'subCategoria') && filter_input(INPUT_POST, 'subCategoria', FILTER_SANITIZE_STRING) != false) {
        $pesquisa['ofertas.subCategoria'] = filter_input(INPUT_POST, 'subCategoria', FILTER_SANITIZE_STRING);

        if (!is_string($pesquisa['ofertas.subCategoria'])) {
            $erros['subCategoria'] = 'Sub-Categoria não foi preenchida';
        } else {
            if (count($pesquisa['ofertas.subCategoria']) > 150) {
                $erros['subCategoria'] = 'Sub-Categoria pode conter no maximo 150 Caracteres';
            }
        }
    }

    if (filter_has_var(INPUT_POST, 'distrito') && filter_input(INPUT_POST, 'distrito', FILTER_SANITIZE_STRING) != false) {

        $pesquisa['morada.distrito'] = filter_input(INPUT_POST, 'distrito', FILTER_SANITIZE_STRING);

        if (!is_string($pesquisa['morada.distrito'])) {
            $erros['distrito'] = 'Distrito não selecionado';
        } else {
            if (!$distritoManager->existeDistrito($pesquisa['morada.distrito'])) {
                $erros['distrito'] = 'Distrito não existe';
            }
        }
    }

    if (filter_has_var(INPUT_POST, 'concelho') && filter_input(INPUT_POST, 'concelho', FILTER_SANITIZE_STRING) != false) {
        $pesquisa['morada.concelho'] = filter_input(INPUT_POST, 'concelho', FILTER_SANITIZE_STRING);

        if (!is_string($pesquisa['morada.concelho'])) {
            $erros['concelho'] = 'Concelho não foi preenchido' . $pesquisa['morada.concelho'];
        } else {
            if (count($pesquisa['morada.concelho']) > 150) {
                $erros['concelho'] = 'Concelho pode conter no maximo 150 Caracteres';
            }
        }
    }

    if (filter_has_var(INPUT_POST, 'texto') && filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_STRING) != false) {
        $pesquisa['procurar'] = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_STRING);

        if (!is_string($pesquisa['procurar'])) {
            $erros['pesquisa'] = 'A pesquisa não foi preenchido';
        } else {
            if (count($pesquisa['procurar']) > 150) {
                $erros['pesquisa'] = 'A pesquisa pode conter no maximo 150 Caracteres';
            }
        }
    }

    if (count($erros) == 0) {

        $results = $ofertasManager->getsOfertasForSearch($pesquisa);

        $list = array();



        foreach ($results as $key => $value) {
            $list[$key] = $value->convertObjectToArray();
        }

        echo json_encode($list);
    } else {
        echo json_encode($erros);
    }
}