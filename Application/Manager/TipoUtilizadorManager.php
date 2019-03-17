<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'TipoUtilizador.php');

class TipoUtilizadorManager extends MyDataAccessPDO {

    const SQL_TABLE_NAME = 'tipoUser';

    public function getTipoUtilizadorById($id) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('id' => $id));
            

            foreach ($results as $key => $rec) {
                
                $list[$key] = (TipoUtilizador::convertArrayToObject($rec));
            }

            return $list[0];
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getTipoUtilizadorByNome($nome){
         try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('name' => $nome));
            

            foreach ($results as $key => $rec) {
                
                $list[$key] = (TipoUtilizador::convertArrayToObject($rec));
            }

            return $list[0];
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getsTipoUtilizador(){
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME);

            
            foreach ($results as $key => $value) {
                $list[$key] = (TipoUtilizador::convertArrayToObject($value));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeTipoUtilizador($id) {
        $results = $this->getTipoUtilizadorById($id);
        
        return count($results)>0;
    }
    
    public function InsertTipoUtilizador(TipoUtilizador $obj) {

        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateTipoUtilizador(TipoUtilizador $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('id' => $obj->getId()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteTipoUtilizador(TipoUtilizador $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('id' => $obj->getId()));
        } catch (Exception $e) {
            throw $e;
        }
    }

}
