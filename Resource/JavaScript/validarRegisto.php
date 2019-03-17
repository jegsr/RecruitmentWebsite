<?php
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD' != 'POST') || (!filter_has_var(INPUT_POST, 'registo'))) {
    return;
}
require_once '../../Config.php';

use Config as Conf;

require_once Conf::getApplicationManagerPath() . 'TipoUtilizadorManager.php';
require_once Conf::getApplicationModelPath() . 'TipoUtilizador.php';

if(filter_has_var(INPUT_POST, 'registo')){
    $id = filter_input(INPUT_POST, 'registo',FILTER_SANITIZE_NUMBER_INT);
    
    if($id == null || !is_numeric($id)){
        
    }else{
        $tipoUtilizadorManager=new TipoUtilizadorManager();
        if($tipoUtilizadorManager->existeTipoUtilizador($id)){
            echo $tipoUtilizadorManager->getTipoUtilizadorById($id)->getNome();
        }
    }
}

