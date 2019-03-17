<?php

class OfertaUtilizador {
    private $utilizador;
    private $oferta;
    private $dataInicio;
    private $dataFim;
    private $vencedor;
    
    function setUtilizador($utilizador) {
        $this->utilizador = $utilizador;
    }

    function setOferta($oferta) {
        $this->oferta = $oferta;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }
    
    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

 
    function getUtilizador() {
        return $this->utilizador;
    }

    function getOferta() {
        return $this->oferta;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDataFim() {
        return $this->dataFim;
    }
    function getVencedor() {
        return $this->vencedor;
    }

    function setVencedor($vencedor) {
        $this->vencedor = $vencedor;
    }

    
  public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['user'], $data['oferta'], $data['dataInicio'], 
                $data['dataFim'], $data['vencedor']);
    }

    public static function createObject($utilizador, $oferta, $dataInicio, $dataFim, $vencedor) {
        $ofertaUtilizador = new OfertaUtilizador();

        $ofertaUtilizador->setUtilizador($utilizador);
        $ofertaUtilizador->setOferta($oferta);
        $ofertaUtilizador->setDataInicio($dataInicio);
        $ofertaUtilizador->setDataFim($dataFim);
        $ofertaUtilizador->setVencedor($vencedor);
       
        return $ofertaUtilizador;
    }

    public function convertObjectToArray() {

        $data = array('user' => $this->getUtilizador(), 'oferta' => $this->getOferta(), 'dataInicio' => $this->getDataInicio(),
            'dataFim' => $this->getDataFim(), 'vencedor' => $this->getVencedor());

        return $data;
    }

}
