<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionManager
 * Controlar sessôes
 * @author Rodrigo Rocha
 */
class SessionManager {
/**
 * Cria uma nova variável de sessão
 * @param type $chave
 * @param type $valor
 * @throws Exception
 */
    public static function addSessionValue($chave, $valor) {
        if (!isset($_SESSION[$chave])) {
            $_SESSION[$chave] = $valor;
        } else {
            throw new Exception('A chave já existe na sessão');
        }
    }

    /**
     * Atualiza uma chave de sessão já existente
     * @param type $chave
     * @param type $valor
     * @throws Exception
     */
    public static function updateSessionValue($chave, $valor) {
        if (isset($_SESSION[$chave])) {
            $_SESSION[$chave] = $valor;
        } else {
            throw new Exception('A chave não existe na sessão');
        }
    }
/**
 * Remove uma chave de sessão já existente
 * @param type $chave
 * @throws Exception
 */
    public static function deleteSessionValue($chave) {
        if (isset($_SESSION[$chave])) {
            unset($_SESSION[$chave]);
        } else {
            throw new Exception('A chave não existe na sessão');
        }
    }
/**
 * Obtem o valor de uma chave de sessão
 * @param type $chave
 * @return type
 * @throws Exception
 */
    public static function getSessionValue($chave) {
        if (isset($_SESSION[$chave])) {
            return $_SESSION[$chave];
        } else {
            throw new Exception('A chave não existe na sessão');
        }
    }
/**
 * Destroi a sessão atual
 * @param type $chave
 * @throws Exception
 */
    public static function destroySession($chave) {
        if (isset($_SESSION[$chave])) {
            session_destroy();
        } else {
            throw new Exception('A chave não existe na sessão');
        }
    }

}
