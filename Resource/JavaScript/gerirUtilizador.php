<?php
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD' != 'POST') || (!filter_has_var(INPUT_POST, 'gerir'))) {
    return;
}
require_once '../../Config.php';

use Config as Conf;

require_once Conf::getApplicationManagerPath() . 'UtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . 'CandidaturaManager.php';
require_once Conf::getApplicationManagerPath() . 'OfertaUtilizadorManager.php';
require_once Conf::getApplicationManagerPath() . 'OfertasManager.php';
require_once Conf::getApplicationModelPath() . 'Utilizador.php';
require_once Conf::getApplicationModelPath() . 'Candidatura.php';
require_once Conf::getApplicationModelPath() . 'OfertaUtilizador.php';
require_once Conf::getApplicationModelPath() . 'Ofertas.php';

if (filter_has_var(INPUT_POST, 'gerir')) {
    $tipo = filter_input(INPUT_POST, 'gerir', FILTER_SANITIZE_STRING);

    if ($id == null || !is_string($id)) {
        
    } else {
        switch ($tipo) {
            case '':

                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                if ($id == null || !is_numeric($id)) {
                    break;
                }
            case 'eliminar':

                $utilizadorManager = new UtilizadorManager();
                
                $utilizador = $utilizadorManager->getUtilizadorByEmail($id);
                
                $utilizadorManager->deleteUtilizador($utilizador);


                break;
            case 'desativar':
               
                $ofertasManager = new OfertasManager();
                if ($ofertasManager->existeOfertasById($id)) {
                    $ofertaUtilizadorManager = new OfertaUtilizadorManager();

                    $oferta = $ofertaUtilizadorManager->getOfertaUtilizadorByOferta($id);
                    $oferta->setDataInicio(null);
                    $oferta->setDataFim(null);
                    $ofertaUtilizadorManager->updateOfertaUtilizador($oferta);
                }
                break;
            case 'selecionar':
                
                $id_oferta = filter_input(INPUT_POST, 'oferta', FILTER_SANITIZE_NUMBER_INT);
                if ($id == null || !is_numeric($id)) {
                    break;
                }
                 $utilizadorManager = new UtilizadorManager();
                 $ofertasManager = new OfertasManager();
                if($utilizadorManager->existeEmail($id) && $ofertasManager->existeOfertasById($id_oferta)){
                   $oferta=  $ofertasManager->getOfertaById($id_oferta);
                   $oferta->setVencedor($id);
                   $ofertasManager->updateOfertas($oferta);
                }else{
                    echo false;
                }
                break;
        }
        
       echo $id;
    }
}
