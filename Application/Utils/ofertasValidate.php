<?php

$erros = array();

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != 'GET' || !filter_has_var(INPUT_GET, 'Criar')) {
    return;
}

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationManagerPath() . 'SessionManager.php');
require_once (Conf::getApplicationManagerPath() . 'TipoHorarioManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertasManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertaUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'CategoriaManager.php');
require_once (Conf::getApplicationModelPath() . 'Ofertas.php');
require_once (Conf::getApplicationModelPath() . 'OfertaUtilizador.php');
require_once (Conf::getApplicationModelPath() . 'TipoHorario.php');
require_once (Conf::getApplicationModelPath() . 'Categoria.php');



$tipoHorarioManager = new TipoHorarioManager();
$ofertasManager = new OfertasManager();
$ofertaUtilizadorManager = new OfertaUtilizadorManager();
$categoriaManager = new CategoriaManager();

if (filter_has_var(INPUT_GET, 'titulo')) {

    $titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);

    $str = array();
    if ($titulo == FALSE || !is_string($titulo)) {
        $erros['Titulo'] = "Titulo não foi preenchido";
    } else {
        if (strlen($titulo) > 150) {
            $str['maximo'] = "Titulo tem de ter no maximo de 150 caracteres";
        }


        if (count($str) > 0) {
            $erros['Titulo'] = $str;
        }
    }
} else {
    $erros['Titulo'] = "Titulo não foi preenchido";
}

if (filter_has_var(INPUT_GET, 'descritivo')) {

    if (($descritivo = filter_input(INPUT_GET, 'descritivo', FILTER_SANITIZE_STRING)) == FALSE || !is_string($descritivo)) {
        $erros['descritivo'] = "Descritivo não foi preenchido";
    } else {
        if (strlen($descritivo) > 500) {
            $erros['descritivo'] = "Descritivo tem de ter menos de 500 caracteres";
        }
    }
} else {
    $erros['descritivo'] = "Descritivo não foi preenchido";
}

if (filter_has_var(INPUT_GET, 'requisitos')) {

    $requisitos = filter_input(INPUT_GET, 'requisitos', FILTER_SANITIZE_STRING);

    $str = array();
    if ($requisitos == FALSE || !is_string($requisitos)) {
        $erros['requisitos'] = "Requisitos não foram preenchidos";
    } else {
        if (strlen($requisitos) > 500) {
            $str['maximo'] = "Requisitos tem de ter no maximo 500 caracteres";
        }


        if (count($str) > 0) {
            $erros['requisitos'] = $str;
        }
    }
} else {
    $erros['requisitos'] = "Requisitos não foram preenchido";
}

if (filter_has_var(INPUT_GET, 'categoria')) {

    $categoria = filter_input(INPUT_GET, 'categoria', FILTER_SANITIZE_STRING);


    if ($categoria == false || !is_string($categoria)) {
        $erros['categoria'] = 'Categoria nao foi selecionado';
    } else {
        if (!$categoriaManager->existeCategoria($categoria)) {
            $erros['categoria'] = 'Categoria contem erros';
        }
    }
} else {
    $erros['categoria'] = 'Categoria nao foi selecionado';
}

if (filter_has_var(INPUT_GET, 'categoriaespecifica')) {

    $categoriaespecifica = filter_input(INPUT_GET, 'categoriaespecifica', FILTER_SANITIZE_STRING);

    $str = array();
    if ($categoriaespecifica == FALSE || !is_string($categoriaespecifica)) {
        $erros['categoriaespecifica'] = "Categoria Especifica não foi preenchida";
    } else {
        if (strlen($categoriaespecifica) > 150) {
            $str['maximo'] = "Categoria Especifica tem de ter no maximo 150 caracteres";
        }


        if (count($str) > 0) {
            $erros['categoriaespecifica'] = $str;
        }
    }
} else {
    $erros['categoriaespecifica'] = "Categoria Especifica não foi preenchida";
}

if (filter_has_var(INPUT_GET, 'tipoHorario')) {
    $tipoHorario = filter_input(INPUT_GET, 'tipoHorario', FILTER_SANITIZE_NUMBER_INT);


    if ($tipoHorario == false || !is_numeric($tipoHorario)) {
        $erros['tipoHorario'] = 'Tipo de Horario nao foi selecionado';
    } else {
        if (!$tipoHorarioManager->existetipoHorario($tipoHorario)) {
            $erros['tipoHorario'] = 'Tipo de Horario contem erros';
        }
    }
} else {
    $erros['tipoHorario'] = 'Tipo de Horario nao foi selecionado';
}

if (filter_has_var(INPUT_GET, 'remuneracao')) {

    $remuneracao = filter_input(INPUT_GET, 'remuneracao', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);

    if ($remuneracao == FALSE || !is_numeric($remuneracao)) {
        $erros['remuneracao'] = "Remuneração não foi preenchido";
    } else {
        if ($remuneracao < 0) {
            $erros['remuneracao'] = "Remuneracao contem erros";
        }
    }
} else {
    $erros['remuneracao'] = "Remuneracao não foi preenchido";
}


if(filter_has_var(INPUT_GET, 'dataInicio')){
    
     $now = date('Y-m-d');
  
    
    $dataInicio = filter_input(INPUT_GET, 'dataInicio');
    
    $date_regex = '%\A(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])\z%'; 
    
    if($dataInicio == FALSE){
        $erros['dataInicio'] = "Data de Inicio nao foi preenchida";
    }else{
        if (preg_match($date_regex, $dataInicio) == FALSE && var_dump($dataInicio >= $now) == TRUE){
            $erros['dataInicio'] = "Data de Inicio contem erros";
        }
    }
}else{
     $erros['dataInicio'] = "Data de inicio nao foi preenchida";
}

if(filter_has_var(INPUT_GET, 'dataFim')){
    $now = date('Y-m-d');
    
    $dataFim = filter_input(INPUT_GET, 'dataFim');
    
    $date_regex = '%\A(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])\z%'; 
    
    if($dataFim == FALSE){
        $erros['dataFim'] = "Data de Fim nao foi preenchida";
    }else{
        if (preg_match($date_regex, $dataFim) == FALSE && var_dump($dataFim >= $now) == TRUE && var_dump($dataFim >= $dataInicio) == TRUE){
            $erros['dataFim'] = "Data de Fim contem erros";
        }
    }
}else{
     $erros['dataFim'] = "Data de Fim nao foi preenchida";
}

if (count($erros) == 0) {

    $novaOferta = new Ofertas();
    $novaOfertaUtilizador = new OfertaUtilizador();
    


    $novaOferta->setId($ofertasManager->maxID() + 1);
    $novaOferta->setTitulo($titulo);
    $novaOferta->setDescritivo($descritivo);
    $novaOferta->setRequisitos($requisitos);
    $novaOferta->setCategoria($categoria);
    $novaOferta->setSubCategoria($categoriaespecifica);
    $novaOferta->setRemuneracao($remuneracao);
    $novaOferta->setTipoHorario($tipoHorario);
    $novaOferta->setDataInicio($dataInicio);
    $novaOferta->setDataFim($dataFim);
    
   


    $ofertasManager->InsertOfertas($novaOferta);
    
    

    header('location:areaUtilizador.php');
}
