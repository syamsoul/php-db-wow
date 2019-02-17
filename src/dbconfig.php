<?php 
namespace SoulDoit\PhpDBWow;

class DBConfig{
    private static $hostname;
    private static $database;
    private static $username;
    private static $password;
    
    private static $empty_config=true;
    
    public static function setConfig($host, $db, $user, $pwd=''){
        if(!empty($db) && !empty($host) && !empty($user)){
            self::$empty_config = false;
            
            self::$hostname = $host;
            self::$database = $db;
            self::$username = $user;
            self::$password = $pwd;
        }
    }
    
    public static function getConfig(){
        if(self::$empty_config == true) return false;
        
        return [
            "hostname"  => self::$hostname,
            "database"  => self::$database,
            "username"  => self::$username,
            "password"  => self::$password,
        ];
    }
}
?>