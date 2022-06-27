<?php
declare (strict_types = 1);

final class Conexao
{
    private static $instance;

     private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    } 
    

    public static function getInstance() : PDO
    {
        if(!isset(self::$instance)) {
            try {
                self::$instance = new PDO("mysql:host=micro-start.mysql.database.azure.com; dbname=microstart; charset=utf8", 'Micro_Start','Etec2022', array(
                    PDO::MYSQL_ATTR_SSL_CA => 'cert/DigiCertGlobalRootCA.crt',
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                ));
            } 
             catch (PDOException $erro) {
                echo 'Erro no banco de dados: ' . $erro->getMessage();
            }
             catch (Exception $erroG) {
                echo 'Ocorreu um erro: ' . $erroG->getMessage();
            }
            
            
        }

        return self::$instance;
    }

}
