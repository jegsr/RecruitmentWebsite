<?php


class Distrito {
    private $nome;

    function getNome() {
        return $this->nome;
    }
    
    function setNome($nome) {
        $this->nome = $nome;
    }

    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['name']);
    }
    
    public static function createObject($nome) {
        $distrito = new Distrito();
        
        $distrito->setNome($nome);
        
        return $distrito;
    }

    public function convertObjectToArray() {
        
        $data = array('name' => $this->getNome());

        return $data;
    }
}
