<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationModelPath() . 'Candidatura.php');

class CandidaturaManager extends MyDataAccessPDO {

    const SQL_TABLE_NAME = 'candidatura';

    function getCandidaturaByUser($user) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('user_email' => $user));
            $list = array();

            foreach ($results as $key => $rec) {
                $list[$key] = (Candidatura::convertArrayToObject($rec));
            }
            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function getCandidaturaByOferta($id) {
        try {
            $results = $this->getRecords(self::SQL_TABLE_NAME, array('oferta_id' => $id));
            $list = array();

            foreach ($results as $key => $rec) {
                $list[$key] = (Candidatura::convertArrayToObject($rec));
            }
            return $list;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function InsertCandidatura(Candidatura $obj) {

        try {
            $this->insert(self::SQL_TABLE_NAME, $obj->convertObjectToArray());
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateCandidatura(Candidatura $obj) {
        try {

            $this->update(self::SQL_TABLE_NAME, $obj->convertObjectToArray(), array('oferta_id' => $obj->getOferta(), 'user_email' => $obj->getUser()));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteCandidatura(Candidatura $obj) {
        try {
            $this->delete(self::SQL_TABLE_NAME, array('oferta_id' => $obj->getOferta(), 'user_email' => $obj->getUser()));
        } catch (Exception $e) {
            throw $e;
        }
    }

}
