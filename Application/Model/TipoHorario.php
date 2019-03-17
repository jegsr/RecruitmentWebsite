<?php


class TipoHorario {
     private $nome;
     private $id;
     
     
    function getNome() {
        return $this->nome;
    }
    
    function setNome($nome) {
        $this->nome = $nome;
    }
    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    
    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['id'],$data['name']);
    }
    
    public static function createObject($id,$nome) {
        $tipoHorario = new TipoHorario();
        
        $tipoHorario->setId($id);
        $tipoHorario->setNome($nome);
        
        return $tipoHorario;
    }

    public function convertObjectToArray() {
        
        $data = array('id'=> $this->getId(),'name' => $this->getNome());

        return $data;
    }
}
