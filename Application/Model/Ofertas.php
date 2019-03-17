<?php
class Ofertas {

    private $id;
    private $tipoHorario;
    private $titulo;
    private $descritivo;
    private $requisitos;
    private $categoria;
    private $subCategoria;
    private $remuneracao;
    private $dataInicio;
    private $dataFim;

    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescritivo() {
        return $this->descritivo;
    }

    function getRequisitos() {
        return $this->requisitos;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getSubCategoria() {
        return $this->subCategoria;
    }

    function getRemuneracao() {
        return $this->remuneracao;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDataFim() {
        return $this->dataFim;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescritivo($descritivo) {
        $this->descritivo = $descritivo;
    }

    function setRequisitos($requisitos) {
        $this->requisitos = $requisitos;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setSubCategoria($subCategoria) {
        $this->subCategoria = $subCategoria;
    }

    function setRemuneracao($remuneracao) {
        $this->remuneracao = $remuneracao;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    function getTipoHorario() {
        return $this->tipoHorario;
    }

    function setTipoHorario($tipoHorario) {
        $this->tipoHorario = $tipoHorario;
    }

    public static function convertArrayToObject(Array &$data) {
        return self::createObject($data['id'], $data['titulo'], $data['descritivo'], 
                $data['requisitos'], $data['categoria'], 
                $data['subCategoria'], $data['remuneracao'], 
                $data['tipoHorario'], $data['dataInicio'], $data['dataFim']);
    }

    public static function createObject($id, $titulo, $descritivo, $requisitos, $categoria, $subCategoria, $remuneracao, $tipoHorario, $dataInicio, $dataFim) {
        $oferta = new Ofertas();

        $oferta->setId($id);
        $oferta->setCategoria($categoria);
        $oferta->setDescritivo($descritivo);
        $oferta->setRemuneracao($remuneracao);
        $oferta->setRequisitos($requisitos);
        $oferta->setSubCategoria($subCategoria);
        $oferta->setTitulo($titulo);
        $oferta->setTipoHorario($tipoHorario);
        $oferta->setDataInicio($dataInicio);
        $oferta->setDataFim($dataFim);

        return $oferta;
    }

    public function convertObjectToArray() {

        $data = array('id' => $this->getId(), 'titulo' => $this->getTitulo(), 'descritivo' => $this->getDescritivo(),
            'requisitos' => $this->getRequisitos(), 'categoria' => $this->getCategoria(),
            'subCategoria' => $this->getSubCategoria(), 'remuneracao' => $this->getRemuneracao(),
            'tipoHorario' => $this->getTipoHorario(), 'dataInicio' => $this->getDataInicio(),
            'dataFim' => $this->getDataFim());

        return $data;
    }

}
