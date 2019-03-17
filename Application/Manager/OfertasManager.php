<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationManagerPath() . 'OfertaUtilizadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertasManager.php');
require_once (Conf::getApplicationModelPath() . 'Ofertas.php');
require_once (Conf::getApplicationModelPath() . 'OfertaUtilizador.php');

class OfertasManager extends MyDataAccessPDO {

    const SQL_TABLE_NAME = 'ofertas';

    public function getOfertaById($id) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('id' => $id));
            $list = array();

            foreach ($results as $rec) {
                $list = (Ofertas::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function existeOfertasById($id) {

        $results = $this->getOfertaById($id);

        return count($results) > 0;
    } 

    public function getOfertas($id, $titulo, $descritivo, $requisitos, $categoria, $subCategoria, $remuneracao, $tipoHorario) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('id' => $id, 'titulo' => $titulo,
                'descritivo' => $descritivo, 'requisitos' => $requisitos, 'categoria' => $categoria,
                'subCategoria' => $subCategoria, 'remuneracao' => $remuneracao,
                'tipoHorario' => $tipoHorario));
            $list = array();

            foreach ($results as $key => $rec) {
                $list[$key] = (Ofertas::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeOfertas($id, $titulo, $descritivo, $requisitos, $categoria, $categoriaespecifica, $remuneracao, $tipoHorario) {

        $results = $this->getOfertas($id, $titulo, $descritivo, $requisitos, $categoria, $categoriaespecifica, $remuneracao, $tipoHorario);

        return count($results) > 0;
    }

    public function maxID() {
        try {
            $results = $this->getRecordsByUserQuery('SELECT MAX(id) FROM ofertas');

            if ($results[0][0] == null) {
                return 0;
            } else {
                return $results[0][0];
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getsOfertas() {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME);

            foreach ($results as $key => $value) {
                $list[$key] = (Ofertas::convertArrayToObject($value));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getsOfertasForSearch($pesquisa) {
        $where = 'WHERE("' . date('Y-m-d') . '" BETWEEN oferta_user.dataInicio AND oferta_user.dataFim';

        if (count($pesquisa) > 0) {

            $where = $where . ' AND ';
            $i = 0;
            foreach ($pesquisa as $key => $value) {
                if ($i < count($pesquisa) - 1) {
                    $where = $where . '' . $key . ' = "' . $value . '" AND ';
                } else {
                    if ($key == 'procurar') {
                        $where = $where . '( ofertas.titulo LIKE "%' . $value . '%" OR ofertas.descritivo LIKE "%' . $value . '%")';
                    } else {
                        $where = $where . '' . $key . ' = "' . $value . '"';
                    }
                }
                $i++;
            }
        }
        try {
            $sql = 'SELECT ofertas.id, ofertas.titulo, ofertas.descritivo, ofertas.requisitos, '
                    . 'ofertas.categoria, ofertas.subCategoria,ofertas.remuneracao ,'
                    . 'tipohorario.name as tipoHorario,oferta_user.dataInicio, oferta_user.dataFim FROM ofertas '
                    . 'INNER JOIN oferta_user ON oferta_user.oferta = ofertas.id '
                    . 'INNER JOIN tipohorario ON ofertas.tipoHorario = tipohorario.id '
                    . 'INNER JOIN user ON oferta_user.user = user.email '
                    . 'INNER JOIN morada ON morada.id = user.morada '
                    . '' . $where . ');';



            $results = $this->getRecordsByUserQuery($sql);
            $list = array();


            foreach ($results as $key => $value) {
                $list[$key] = (Ofertas::convertArrayToObject($value));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function InsertOfertas(Ofertas $obj) {

        try {
            $data = $obj->convertObjectToArray();

            $ofertasUtilizadorManager = new OfertaUtilizadorManager();



            $this->insert(self::SQL_TABLE_NAME, array('id' => $data['id'], 'titulo' => $data['titulo'], 'descritivo' => $data['descritivo'],
                'requisitos' => $data['requisitos'], 'categoria' => $data['categoria'],
                'subCategoria' => $data['subCategoria'], 'remuneracao' => $data['remuneracao'],
                'tipoHorario' => $data['tipoHorario']));

            $ofertasUtilizador = new OfertaUtilizador();
            $ofertasUtilizador->setDataFim($data['dataFim']);
            $ofertasUtilizador->setDataInicio($data['dataInicio']);
            $ofertasUtilizador->setOferta($data['id']);
            $ofertasUtilizador->setUtilizador($_SESSION['logged']);



            $ofertasUtilizadorManager->InsertOfertaUtilizador($ofertasUtilizador);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateOfertas(Ofertas $obj) {
        try {
            $data = $obj->convertObjectToArray();
            $ofertasUtilizadorManager = new OfertaUtilizadorManager();
            
            $ofertasUtilizador = new OfertaUtilizador();
            $ofertasUtilizador->setDataFim($data['dataFim']);
            $ofertasUtilizador->setDataInicio($data['dataInicio']);
            $ofertasUtilizador->setOferta($data['id']);
            $ofertasUtilizador->setUtilizador($_SESSION['logged']);
            $ofertasUtilizadorManager->updateOfertaUtilizador($ofertasUtilizador);
            
            $this->update(self::SQL_TABLE_NAME, array('id' => $data['id'], 'titulo' => $data['titulo'], 'descritivo' => $data['descritivo'],
                'requisitos' => $data['requisitos'], 'categoria' => $data['categoria'],
                'subCategoria' => $data['subCategoria'], 'remuneracao' => $data['remuneracao'],
                'tipoHorario' => $data['tipoHorario']), array('id' => $obj->getId()));
            
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteOfertas(Ofertas $obj) {
        try {
            $data = $obj->convertObjectToArray();
            $ofertasUtilizadorManager = new OfertaUtilizadorManager();
            $ofertasUtilizador = new OfertaUtilizador();
            $ofertasUtilizador->setDataFim($data['dataFim']);
            $ofertasUtilizador->setDataInicio($data['dataInicio']);
            $ofertasUtilizador->setOferta($data['id']);
            $ofertasUtilizador->setUtilizador($_SESSION['logged']);
            
            $ofertasUtilizadorManager->deleteOfertaUtilizador($ofertasUtilizador);
            $this->delete(self::SQL_TABLE_NAME, array('id' => $data['id'], 'titulo' => $data['titulo'], 'descritivo' => $data['descritivo'],
                'requisitos' => $data['requisitos'], 'categoria' => $data['categoria'],
                'subCategoria' => $data['subCategoria'], 'remuneracao' => $data['remuneracao'],
                'tipoHorario' => $data['tipoHorario']));
            
        } catch (Exception $e) {
            throw $e;
        }
    }

}
