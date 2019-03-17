<?php

class Utilizador {

    private $email;
    private $password;
    private $serial;
    private $nome;
    private $morada;
    private $contacto;
    private $tipoUtilizador;
    private $foto;

    function getSerial() {
        return $this->serial;
    }
    
    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    
    function setSerial($serial) {
        $this->serial = $serial;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }
    
    function getContacto() {
        return $this->contacto;
    }

    function getTipoUtilizador() {
        return $this->tipoUtilizador;
    }

    function getFoto() {
        return $this->foto;
    }

    function setContacto($contacto) {
        $this->contacto = $contacto;
    }

    function setTipoUtilizador($tipoUtilizador) {
        $this->tipoUtilizador = $tipoUtilizador;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function getMorada() {
        return $this->morada;
    }

    function setMorada($morada) {
        $this->morada = $morada;
    }

            
    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['email'], $data['password'],$data['serial'],
                $data['tipoUtilizador'],$data['foto'],$data['contacto'],$data['morada'], $data['name']);
    }

    public static function createObject($email, $password, $serial, $tipoUtilizador, $foto, $contacto, $morada, $nome) {
        $utilizador = new Utilizador();
        
        $utilizador->setEmail($email);
        $utilizador->setPassword($password);
        $utilizador->setSerial($serial);
        $utilizador->setNome($nome);
        $utilizador->setFoto($foto);
        $utilizador->setTipoUtilizador($tipoUtilizador);
        $utilizador->setContacto($contacto);
        $utilizador->setMorada($morada);
        return $utilizador;
    }

    public function convertObjectToArray() {
        
        $data = array('email' => $this->getEmail(), 'password' => $this->getPassword(), 
            'serial' => $this->getSerial(), 'tipoUtilizador' => $this->getTipoUtilizador(),
            'foto' => $this->getFoto(), 'contacto' => $this->getContacto(), 'morada' => $this->getMorada(), 'name' => $this->getNome());

        return $data;
    }
    
 
    public function generatorSerial() {
        define('HASH', UtilizadorManager::ENCRYPTED . '%d' . '%s');
        $str = sprintf(HASH,time(), $this->getSerial());
        
        return UtilizadorManager::encriptar($str);
    }

}
