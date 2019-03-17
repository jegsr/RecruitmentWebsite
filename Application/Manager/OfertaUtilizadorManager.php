<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'OfertaUtilizador.php');

class OfertaUtilizadorManager extends MyDataAccessPDO{
      const SQL_TABLE_NAME = 'oferta_user';

    public function getOfertaUtilizador($utilizador, $oferta, $dataInicio, $dataFim) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('user' => $utilizador, 'oferta' => $oferta,
                'dataInicio' => $dataInicio, 'dataFim' => $dataFim));
            $list = array();

            foreach ($results as $key => $rec) {
                $list[$key] = (OfertaUtilizador::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeOfertaUtilizador($utilizador, $oferta, $dataInicio, $dataFim) {

        $results = $this->getOfertaUtilizador($utilizador, $oferta, $dataInicio, $dataFim);

        return count($results) > 0;
    }
    
    public function getOfertaUtilizadorByUser($utilizador) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('user' => $utilizador));
            $list = array();

            foreach ($results as $key => $rec) {
                $list[$key] = (OfertaUtilizador::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getOfertaUtilizadorByOferta($oferta) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('oferta' => $oferta));
            $list = array();

            foreach ($results as $rec) {
                $list= (OfertaUtilizador::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeOfertaUtilizadorByOferta( $oferta) {

        $results = $this->getOfertaUtilizador($oferta);

        return count($results) > 0;
    }
    
    public function getOfertaUtilizadorByVencedor($vencedor) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('vencedor' => $vencedor));
            $list = array();

            foreach ($results as $key =>$rec) {
                $list[$key]= (OfertaUtilizador::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeOfertaUtilizadorByVencedor( $vencedor) {

        $results = $this->getOfertaUtilizador($vencedor);

        return count($results) > 0;
    }

    public function getsOfertaUtilizador() {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME);

            foreach ($results as $key => $value) {
                $list[$key] = (OfertaUtilizador::convertArrayToObject($value));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function InsertOfertaUtilizador(OfertaUtilizador $obj) {

        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function updateOfertaUtilizador(OfertaUtilizador $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('user' => $obj->getUtilizador(), 'oferta'=>$obj->getOferta()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteOfertaUtilizador(OfertaUtilizador $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('user' => $obj->getUtilizador(), 'oferta'=>$obj->getOferta()));
        } catch (Exception $e) {
            throw $e;
        }
    }

}
