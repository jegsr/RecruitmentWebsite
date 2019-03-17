<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'Utilizador.php');

class UtilizadorManager extends MyDataAccessPDO {

    const SQL_TABLE_NAME = 'user';
    const ENCRYPTED = 'xpto';

    public static function encriptar($str) {
        return sha1($str . self::ENCRYPTED);
    }

    function getUtilizadorByEmail($email) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('email' => $email));
            
            foreach ($results as $rec) {
                $list = (Utilizador::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function existeUtilizador($email, $password) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('email' => $email, 'password' => $password));

            return count($results) > 0;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function existeEmail($email) {
        try {
            $results = $this->getUtilizadorByEmail($email);

            return count($results) > 0;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function existeSerial($email, $serial) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('email' => $email, 'serial' => $serial));

            return count($results) > 0;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    function getUtilizador(){
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME);
            $list = array();
            foreach ($results as $key => $rec) {
                $list[$key] = (Utilizador::convertArrayToObject($rec));
            }

            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function InsertUtilizador(Utilizador $obj) {
        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateUtilizador(Utilizador $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('email' => $obj->getEmail()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteUtilizador(Utilizador $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('email' => $obj->getEmail()));
        } catch (Exception $e) {
            throw $e;
        }
    }

}
