<?php
/**
  ESTGF - Escola Superior de Tecnologia e Gestão de Felgueiras
  IPP - Instituto Politécnico do Porto
  LEI - Licenciatura em Engenharia Informática
  PAW - Programação em Ambiente Web 2013/2014
 */

/**
 * Importação do ficheiro de configuração
 */
require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

/**
 * Alias para o nome da classe existente no ficheiro de configuração
 */
use Config as Conf;

/**
 * Importação das classes de suporte ao módulo de acesso à base de dados
 */
require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDOSqlFactory.php');

/**
 * Alias para o nome da classe existente que permite auxiliar a ocnstrução das
 * consultas à base de dados
 */
use MyDataAccessPDOSqlFactory as MyHelper;

/**
 * Descrição da classe MyDataAcessPDOBase
 * 
 * Esta classe tem como objetivo fornecer uma interface de comunicação 
 * entre o website (camada aplicacional) e a base de dados (camada de dados)
 * 
 * @author ESTGF.PAW
 */
abstract class MyDataAcessPDOBase {

    const ERRORMSG_INVALID_CONNECTION = "A conexão enviada é invalida!!";

    private $connection = null;

    /**
     *
     * @var array Que define as opções de ligação à base de dados
     */
    private $connectionOptions = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    );

    /**
     * Constantes utilizadas para a conexão à base de dados.
     * 
     */
    const DSN_HOST_TAG = '{host}';
    const DSN_DATABASENAME_TAG = '{databaseName}';
    const DSN_MYSQL = 'mysql:host={host};dbname={databaseName}';

    /**
     * Método construtor que define a string de conexão à base de dados
     * 
     * @param type $host Endereço do servidor de base de dados
     * @param type $databaseName Nome da base de dados
     * @param type $userName Nome de utilizador de acesso à base de dados
     * @param type $password Palavra-chave de acesso à base de dados
     * @throws Exception Excepção lançada pelo PDO que no caso de a conexão não
     * ocorrer com sucesso.
     */
    public function __construct($host, $databaseName, $userName, $password) {

        $dsn = $this->getDSNMySQL($host, $databaseName);

        try {
            $this->setConnection(new PDO($dsn, $userName, $password, $this->getConnectionOptions()));
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Método responsável pela geração da string de conexão para a ligação à
     * base de dados
     * 
     * @param String $host Endereço do servidor de base de dados
     * @param String $databaseName Nome da base de dados
     * @return String String de conexão devidamente construída 
     */
    private function getDSNMySQL(&$host, &$databaseName) {
        $dsn = self::DSN_MYSQL;

        MyHelper::replaceStringTag(self::DSN_HOST_TAG, $dsn, $host);
        MyHelper::replaceStringTag(self::DSN_DATABASENAME_TAG, $dsn, $databaseName);

        return $dsn;
    }

    /**
     * Método que devolve o objeto com a conexão à base de dados
     * 
     * @return PDO O objeto com a ligação à base de dados
     */
    protected function getConnection() {
        return $this->connection;
    }

    /**
     * Devolve na variável  $this->connection, o objeto de conexão devolvido pelo
     * PDO
     * 
     * @param PDO $connection Valor enviado por referência que contém a ligação
     * à base de dados devolvido pelo PDO
     * @throws PDOException Excepção gerada pelo PDO no caso de o objeto de conexão
     * não ter sido realizado com sucesso.
     */
    protected function setConnection(PDO &$connection) {
        if (($connection == null) || !($connection instanceof PDO)) {
            throw new PDOException(self::ERRORMSG_INVALID_CONNECTION);
        }
        $this->connection = $connection;
    }

    /**
     * Devolve as opções de ligação do PDO
     * 
     * @return array Com as opções de conexão do PDO
     */
    private function getConnectionOptions() {
        return $this->connectionOptions;
    }

    /**
     * Método que permite a definição de uma transação no PDO para a realização
     * das consultas
     */
    public function beginTransaction() {
        $this->connection->beginTransaction();
    }

    /**
     * Método que permite terminar a transação nas queries executadas pelo PDO
     */
    public function endTransaction() {
        $this->connection->endTransaction();
    }

    /**
     * Método responsável pela execução da consulta à base de dados
     * 
     * @param type $sql Valor enviado por referência que contém a base da querie a 
     * executar
     * @param array $dataParameters Contém os parâmetors que irão ser substituídos
     * na querie base enviada.
     * @return boolean Valor booleano relativo à execução da querie
     */
    protected function prepareStatement(&$sql, Array &$dataParameters = null) {
        $q = $this->getConnection()->prepare($sql);
        $q->execute($dataParameters);
        return $q;
    }

}
