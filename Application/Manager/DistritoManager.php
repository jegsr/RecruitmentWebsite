<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'Distrito.php');

class DistritoManager extends MyDataAccessPDO{
    const SQL_TABLE_NAME = 'distrito';
    
    public function getDistritoByNome($nome) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('name' => $nome));
            

            foreach ($results as $rec) { 
                $list = (Distrito::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getsDistrito(){
        try {
           $results = $this->getRecords(self::SQL_TABLE_NAME);
            
            foreach ($results as $key => $value) {
                $list[$key] = (Distrito::convertArrayToObject($value));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function existeDistrito($nome) {
        $results = $this->getDistritoByNome($nome);
        
        return count($results)>0;
    }
    
    public function InsertDistrito(Distrito $obj) {

        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateDistrito(Distrito $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('name' => $obj->getNome()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteDistrito(Distrito $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('name' => $obj->getNome()));
        } catch (Exception $e) {
            throw $e;
        }
    }
}
