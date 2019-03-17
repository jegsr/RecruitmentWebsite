<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'Categoria.php');

class CategoriaManager extends MyDataAccessPDO {

    const SQL_TABLE_NAME = 'categoria';

    function getCategoriaByName($name) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('name' => $name));
            $list = array();

            foreach ($results as $key => $rec) {
                $list[$key] = (Categoria::convertArrayToObject($rec));
            }
            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function getsCategoria() {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME);
            $list = array();

            foreach ($results as $key => $rec) {
                $list[$key] = (Categoria::convertArrayToObject($rec));
            }
            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function existeCategoria($name) {
        try {
            $results = $this->getCategoriaByName($name);
            return count($results) > 0;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function InsertCategoria(Categoria $obj) {

        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateCategoria(Categoria $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('name' => $obj->getName()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteCategoria(Categoria $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('name' => $obj->getName()));
        } catch (Exception $e) {
            throw $e;
        }
    }

}
