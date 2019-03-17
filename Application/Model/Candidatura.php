<?php


class Candidatura {
    private $oferta;
    private $user;
    
    function getOferta() {
        return $this->oferta;
    }

    function getUser() {
        return $this->user;
    }

    function setOferta($oferta) {
        $this->oferta = $oferta;
    }

    function setUser($user) {
        $this->user = $user;
    }

    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['oferta_id'],$data['user_email']);
    }
    
    public static function createObject($oferta,$user) {
        $candidatura = new Candidatura();
        $candidatura->setOferta($oferta);
        $candidatura->setUser($user);
        
        return $candidatura;
    }

    public function convertObjectToArray() {
        
        $data = array('oferta_id' => $this->getOferta(), 'user_email' => $this->getUser());

        return $data;
    }
}
