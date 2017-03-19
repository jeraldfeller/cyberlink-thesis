<?php


class User{

    public $debug = TRUE;
    protected $db_pdo;


    public function login($user, $password)
    {
        //$passwordEncrypt = $this->encrypt_decrypt('encrypt', $password);
        $passwordEncrypt = $password;
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `users` WHERE `user_name` = "'. $user .'" AND `password` = "' . $passwordEncrypt . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user_name']);
        session_unset();
        session_destroy();
        header('Location: login');


    }

    /*
     * ENCRYPT/DECRYPT
     */


    function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }



    public function pdoQuoteValue($value)
    {
        $pdo = $this->getPdo();
        return $pdo->quote($value);
    }

    public function getPdo()
    {
        if (!$this->db_pdo)
        {
            if ($this->debug)
            {
                $this->db_pdo = new PDO(DB_DSN, DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            }
            else
            {
                $this->db_pdo = new PDO(DB_DSN, DB_USER, DB_PWD);
            }
        }
        return $this->db_pdo;
    }


}