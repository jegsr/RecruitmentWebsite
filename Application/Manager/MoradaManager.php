<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'Morada.php');

class MoradaManager extends MyDataAccessPDO {

    const SQL_TABLE_NAME = 'morada';

    public function getMorada($rua, $concelho, $distrito, $cp1, $cp2) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('rua' => $rua,
                'concelho' => $concelho, 'distrito' => $distrito, 'cp1' => $cp1, 'cp2' => $cp2));
            

            foreach ($results as $key => $rec) {
                $list[$key] = (Morada::convertArrayToObject($rec));
            }

            return $list[0];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeMorada($rua, $concelho, $distrito, $cp1, $cp2) {

        $results = $this->getMorada($rua, $concelho, $distrito, $cp1, $cp2);

        return count($results) > 0;
    }
    public function getMoradaById($id){
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('id'=>$id));
            
            $list = array();

            foreach ($results as $rec) {
                $list = (Morada::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function maxID(){
        try {
            $results = $this->getRecordsByUserQuery('SELECT MAX(id) FROM morada');
            
            if($results[0][0] == null){
                return 0;
            }else{
                return $results[0][0];
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getsMorada() {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME);

            foreach ($results as $key => $value) {
                $list[$key] = (Morada::convertArrayToObject($value));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function InsertMorada(Morada $obj) {

        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateMorada(Morada $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('id' => $obj->getId()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteMorada(Morada $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('id' => $obj->getId()));
        } catch (Exception $e) {
            throw $e;
        }
    }

}
