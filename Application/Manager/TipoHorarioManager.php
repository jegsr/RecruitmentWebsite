<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'TipoHorario.php');

class TipoHorarioManager extends MyDataAccessPDO{
    const SQL_TABLE_NAME = 'tipohorario';
    
    public function getTipoHorarioById($id) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('id' => $id));
            $list = array();

            foreach ($results as $key => $rec) { 
                $list[$key] = (TipoHorario::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getsTipoHorario(){
        try {
           $results = $this->getRecords(self::SQL_TABLE_NAME);
            
            foreach ($results as $key => $value) {
                $list[$key] = (TipoHorario::convertArrayToObject($value));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeTipoHorario($id) {
        $results = $this->getTipoHorarioById($id);
        
        return count($results)>0;
    }
    
    public function InsertTipoHorario(TipoHorario $obj) {

        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateTipoHorario(TipoHorario $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('id' => $obj->getId()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteTipoHorario(TipoHorario $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('id' => $obj->getId()));
        } catch (Exception $e) {
            throw $e;
        }
    }
}


