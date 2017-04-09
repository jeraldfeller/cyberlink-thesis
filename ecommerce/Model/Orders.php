<?php


class Orders {
    public $debug = TRUE;
    protected $db_pdo;


    public function insertOrders($data){
        $totalProfit = $data['info']['sumTotal'] - $data['info']['baseSumTotal'];
        $pdo = $this->getPdo();
        $sql = 'INSERT INTO `invoice` (`customer_id`,
                                       `transaction_id`,
                                       `mode_of_payment`,
                                       `delivery_address`,
                                       `date_of_delivery`,
                                       `total_base_price`,
                                       `total_price`,
                                       `total_profit`,
                                       `status`,
                                       `date_ordered`) VALUES
                                       ("' . $data['info']['customerId'] . '",
                                        "' . $data['info']['invoiceId'] . '",
                                        "' . $data['info']['modeOfPayment'] . '",
                                        "' . $data['info']['deliveryAddress'] . '",
                                        "' . $data['info']['dateOfDelivery'] . '",
                                        "' . $data['info']['baseSumTotal'] . '",
                                        "' . $data['info']['sumTotal'] . '",
                                        "' . $totalProfit . '",
                                        "PENDING",
                                        "' . date('Y-m-d') . '")';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $invoiceId = $pdo->lastInsertId();


        for($i = 0; $i < count($data['items']); $i++){
            $sql = 'INSERT INTO `orders` (`invoice_id`,
                                     `customer_id`,
                                     `product_id`,
                                     `original_price`,
                                     `selling_price`,
                                     `quantity`,
                                     `profit`,
                                     `total_price`
                                     ) VALUES
                                     ("' . $invoiceId . '",
                                      "' . $data['info']['customerId'] . '",
                                      "' . $data['items'][$i]['productId'] . '",
                                      "' . $data['items'][$i]['originalPrice'] . '",
                                      "' . $data['items'][$i]['sellingPrice'] . '",
                                      "' . $data['items'][$i]['quantity'] . '",
                                      "' . $data['items'][$i]['profit'] * $data['items'][$i]['quantity']. '",
                                      "' . $data['items'][$i]['totalPrice'] . '"
                                     )
                                     ';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }



    }

    public function getOrdersByCustomerId($customerId){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `invoice` WHERE `customer_id` = ' . $customerId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }


    public function getOrdersByTransactionId($transactionId){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `invoice` WHERE `transaction_id` = "' . $transactionId . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = $stmt->fetch(PDO::FETCH_ASSOC);
        return $content;
    }

    public function getOrderItemsByInvoiceId($invoiceId){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `orders` WHERE `invoice_id` = ' . $invoiceId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
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