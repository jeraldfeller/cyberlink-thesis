<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 3/13/2017
 * Time: 10:29 AM
 */

class Customer {

    public $debug = TRUE;
    protected $db_pdo;

    public function registerCustomer($email, $password, $firstName, $lastName, $dateOfBirth, $address, $city, $homeNumber, $mobileNumber, $dateRegistered){
        $isEmailExist = $this->checkEmailDuplicate($email);
        if(count($isEmailExist) == 0){
            $pdo = $this->getPdo();
            $sql = 'INSERT INTO `customers` (`email_address`,
                                             `password`,
                                             `first_name`,
                                             `last_name`,
                                             `date_of_birth`,
                                             `address`,
                                             `city`,
                                             `home_number`,
                                             `mobile_number`,
                                             `date_registered`
                                            ) VALUES
                            ("' . $email . '",
                            "' . $password . '",
                            "' . $firstName . '",
                            "' . $lastName . '",
                            "' . $dateOfBirth . '",
                            "' . $address . '",
                            "' . $city . '",
                            "' . $homeNumber . '",
                            "' . $mobileNumber . '",
                            "' . $dateRegistered . '")';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $lastId = $pdo->lastInsertId();

            $_SESSION['is_logged'] = true;
            $_SESSION['customer_id'] = $lastId;
            $_SESSION['first_name'] = $firstName;
            $_SESSION['last_name'] = $lastName;

            return true;
        }else{
            return false;
        }

    }

    public function checkEmailDuplicate($email){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `customers` WHERE `email_address` = "'. $email .'"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function customerLogin($email, $password)
    {
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `customers` WHERE `email_address` = "'. $email .'" AND `password` = "' . $password . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        if(count($content) == 1){
            $_SESSION['is_logged'] = true;
            $_SESSION['customer_id'] = $content[0]['customer_id'];
            $_SESSION['first_name'] = $content[0]['first_name'];
            $_SESSION['last_name'] = $content[0]['last_name'];

            return true;
        }else{
            return false;
        }
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