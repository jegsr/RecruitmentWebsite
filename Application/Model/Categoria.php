<?php


class Categoria {
    private $name;
    
    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    
    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['name']);
    }
    
    public static function createObject($nome) {
        $categoria = new Categoria();
        $categoria->setName($nome);
        
        return $categoria;
    }

    public function convertObjectToArray() {
        
        $data = array('name' => $this->getNome());

        return $data;
    }
    
    
}
