<?php


class Morada {

    private $id;
    private $rua;
    private $distrito;
    private $concelho;
    private $cp1;
    private $cp2;

    function getId() {
        return $this->id;
    }

    function getRua() {
        return $this->rua;
    }

    function getDistrito() {
        return $this->distrito;
    }

    function getConcelho() {
        return $this->concelho;
    }

    function getCp1() {
        return $this->cp1;
    }

    function getCp2() {
        return $this->cp2;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRua($rua) {
        $this->rua = $rua;
    }

    function setDistrito($distrito) {
        $this->distrito = $distrito;
    }

    function setConcelho($concelho) {
        $this->concelho = $concelho;
    }

    function setCp1($cp1) {
        $this->cp1 = $cp1;
    }

    function setCp2($cp2) {
        $this->cp2 = $cp2;
    }

    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['id'], $data['rua'], $data['concelho'], $data['distrito'], $data['cp1'], $data['cp2']);
    }

    public static function createObject($id, $rua, $concelho, $distrito, $cp1, $cp2) {
        $morada = new Morada();

        $morada->setId($id);
        $morada->setDistrito($rua);
        $morada->setDistrito($distrito);
        $morada->setConcelho($concelho);
        $morada->setCp1($cp1);
        $morada->setCp2($cp2);

        return $morada;
    }

    public function convertObjectToArray() {

        $data = array('id' => $this->getId(), 'rua' => $this->getRua(), 'concelho' => $this->getConcelho(), 
            'distrito' => $this->getDistrito(), 'cp1' => $this->getCp1(), 'cp2' => $this->getCp2());

        return $data;
    }

}
