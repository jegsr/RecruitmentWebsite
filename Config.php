<?php

/**
 * Ficheiro de configuração
 *
 * @author ESTGF.PAW
 */
class Config {
    
    const IMAGES_FOLDER = '/Resource/Images/';
    
    const SGBD_HOST_NAME = 'localhost';
    const SGBD_DATABASE_NAME = 'paw_trabalho';
    const SGBD_USERNAME = 'root';
    const SGBD_PASSWORD = '';
    
    public static function getImagesPathBase(){
        return realpath(dirname( __FILE__ )) . self::IMAGES_FOLDER;
    }
    
    public static function getApplicationPath(){
        return realpath(dirname( __FILE__ )) . '/Application/';
    }
    
    public static function getApplicationDatabasePath(){
        return self::getApplicationPath() . '/Database/';
    }
    
    public static function getApplicationManagerPath(){
        return self::getApplicationPath() . '/Manager/';
    }
    
    public static function getApplicationModelPath(){
        return self::getApplicationPath() . '/Model/';
    }
    
    public static function getApplicationUtilsPath(){
        return self::getApplicationPath() . '/Utils/';
    }    
}
