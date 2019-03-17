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
require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDOBase.php');
require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDOSqlFactory.php');

/**
 * Classe genérica e simples responsável pela interacção com a base de dados. 
 *  Contém os métodos CRUD de interacção com uma base de dados.
 *  Utiliza a extensão PDO
 * 
 * @author ESTGF.PAW
 */
class MyDataAccessPDO extends MyDataAcessPDOBase {

    /**
     * Constantes que identificam o tipo de query que será construída
     */
    const SELECT_OPERATION = 1;
    const INSERT_OPERATION = 2;
    const UPDATE_OPERATION = 3;
    const DELETE_OPERATION = 4;

    /**
     * Construtor que procede à invocação do contrutor da superclasse, de forma
     * a estabelecer a ligação com a base de dados
     * Caso não seja enviados argumentos, a classe utiliza as parametrizações 
     *  definidas no ficheiro de configurações.
     * 
     * @param String $host Nome do servidor onde se encontra alojado o servidor de 
     * base de dados.
     * @param String $databaseName Nome da base de dados para a qual se pretender
     * estabelecer a comunicação.
     * @param String $userName Nome do utilizador para acesso à base de dados.
     * @param String $password Palavra-chave de acesso à base de dados.
     */
    public function __construct($host = Conf::SGBD_HOST_NAME, 
            $databaseName = Conf::SGBD_DATABASE_NAME, 
            $userName = Conf::SGBD_USERNAME, $password = Conf::SGBD_PASSWORD) {
        parent::__construct($host, $databaseName, $userName, $password);
    }

    /**
     * Metodo responsável pela devolução dos registos de uma fonte de dados, 
     *  podendo adicionalmente ter associado filtros e ordenação.
     * 
     * @param String $table Define a fonte de dados que será o alvo da consulta. Este 
     *  parâmetro pode receber o nome da tabela, assim como a expressão de junção
     *  entre várias tabelas.
     * @param Array $where Define o filtro a ser aplicado à consulta. O array deve
     *  ser do tipo $chave => $valor, onde $chave é o nome do campo da tabela e 
     *  $valor é o valor a filtrar no campo. Caso seja enviado mais de um atributo, 
     *  é aplicado o operador "AND".
     * @param Array $order Define os atributos que fazem parte da cláusula 
     *  de ordenação.
     * @return Array Devolve um array associativo do tipo chave => valor, onde $chave  
     *  é nome do campo da tabela e o $valor representa o valor do respetivo campo.
     * @throws PDOException Excepção lançada no caso de a classe PDO detetar algum erro.
     * @throws Exception Excepção genérica a ser lançada.
     */
    protected function getRecords($table, Array $where = null, 
            Array $order = null) {

        try {
            $sql = MyDataAccessPDOSQLFactory::buildSQL(self::SELECT_OPERATION, 
                    $table, $where, $order);
            $q = $this->prepareStatement($sql, $where);
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }

        $q->setFetchMode(PDO::FETCH_BOTH);
        return $q->fetchAll();
    }

    /**
     * Método que permite a execução de consultas ao servidor de base de dados
     *  de forma livre. Ou seja, o parâmetro recebe uma "string" com a query a 
     *  executar.
     * 
     * @warning Este método não previne ataques do tipo SQL Injection
     * @param String $sql String que contém a query a executar na base de dados 
     * @return Array Devolve um array associativo do tipo chave => valor, onde $chave  
     *  é nome do campo da tabela e o $valor representa o valor do respetivo campo.
     * @throws PDOException Excepção lançada no caso de a classe PDO detetar algum erro
     * @throws Exception Excepção genérica a ser lançada.
     */
    protected function getRecordsByUserQuery($sql) {
        try {
            $q = $this->prepareStatement($sql);
            $q->setFetchMode(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        return $q->fetchAll();
    }

    /**
     * Método responsável pela inserção de um registo numa tabela
     * 
     * @param String $table Nome da tabela para a qual o registo será inserido
     * @param Array $fields Array associativo que O array deve
     *  ser do tipo $chave => $valor, onde $chave é o nome do campo da tabela e 
     *  $valor é o valor a inserir para o respetivo campo.
     * @throws Exception Excepção lançada no caso de a classe PDO detetar algum erro
     */
    protected function insert($table, Array $fields) {
        $sql = MyDataAccessPDOSQLFactory::buildSQL(self::INSERT_OPERATION, 
                $table, $fields);
        try {
            $this->prepareStatement($sql, $fields);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Método responsável por atualizar um registo numa tabela
     * 
     * @param String $table Nome da tabela para a qual o registo será atualizado
     * @param Array $fields Array associativo que contém o mapeamento entre os atributos
     * e os valores associados
     * @param Array $where Define o filtro a ser aplicado à consulta. 
     * O array deve ser do tipo $chave => $valor, onde $chave é o nome do 
     * campo da tabela e $valor é o valor a filtrar no campo. 
     * Caso seja enviado mais de um atributo, é aplicado o operador "AND".
     * @throws Exception Excepção lançada no caso de a classe PDO detetar algum erro
     */
    protected function update($table, Array $fields, Array $where = null) {
        $sql = MyDataAccessPDOSQLFactory::buildSQL(self::UPDATE_OPERATION, $table, $fields, $where);
        try {
            $this->prepareStatement($sql, $fields);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Método responsável por eliminar um registo de uma tabela
     * 
     * @param String $table Nome da tabela para a qual o registo será atualizado
     * @param Array $where Define o filtro a ser aplicado à consulta. 
     * O array deve ser do tipo $chave => $valor, onde $chave é o nome do 
     * campo da tabela e $valor é o valor a filtrar no campo. 
     * @throws Exception Excepção lançada no caso de a classe PDO detetar algum erro
     */
    protected function delete($table, Array $where = null) {
        $sql = MyDataAccessPDOSQLFactory::buildSQL(self::DELETE_OPERATION, 
                $table, $where);
        try {
            $this->prepareStatement($sql, $where);
        } catch (Exception $e) {
            throw $e;
        }
    }

}
