<?php


class TipoUtilizador {

    private $id;
    private $nome;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
    
    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['id'], $data['name']);
    }
    
    public static function createObject($id, $tipoUtilizador) {
        $TipoUtilizador = new TipoUtilizador();

        $TipoUtilizador->setId($id);
        $TipoUtilizador->setNome($tipoUtilizador);
        
        return $TipoUtilizador;
    }

    public function convertObjectToArray() {
        
        $data = array('id' => $this->getID(), 'name' => $this->getNome());

        return $data;
    }

}
