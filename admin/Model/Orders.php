<?php


class Orders{
    public $debug = TRUE;
    protected $db_pdo;

    public function getPendingOrdersByCustomerId($customerId, $status){
            $pdo = $this->getPdo();
            if($status == 'ALL'){
                $sql = 'SELECT * FROM `invoice` WHERE `customer_id` = ' . $customerId . ' AND `status` != "PENDING"';
            }else{
                $sql = 'SELECT * FROM `invoice` WHERE `customer_id` = ' . $customerId . ' AND `status` = "' . $status . '"';
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $content = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $content[] = $row;
            }
            return $content;
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

    public function getCustomerById($customerId){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `customers` WHERE `customer_id` = ' . $customerId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function updateOrder($data){
       if($data['action'] == 'approved'){
            $sql = 'UPDATE `invoice` SET `delivery_charge` = "' . $data['deliveryCharge'] . '",
                                         `no_of_days_expire` = "' . $data['daysExpire'] . '",
                                         `status` = "APPROVED" WHERE `invoice_id` = ' . $data['invoiceId'] . '';
           $pdo = $this->getPdo();
           $stmt = $pdo->prepare($sql);
           $stmt->execute();
       }else if($data['action'] == 'complete'){
           $sql = 'UPDATE `invoice` SET `status` = "' . strtoupper($data['action']) . '" WHERE `invoice_id` = ' . $data['invoiceId'] . '';
           $pdo = $this->getPdo();
           $stmt = $pdo->prepare($sql);
           $stmt->execute();

            $items = $this->getOrderItemsByInvoiceId($data['invoiceId']);
            foreach($items as $item){
                $this->updateProductQuantity($item['product_id'], -$item['quantity']);
            }
           $this->recordTransaction($data['transactionId']);


        }else{
           $sql = 'UPDATE `invoice` SET `status` = "' . strtoupper($data['action']) . '" WHERE `invoice_id` = ' . $data['invoiceId'] . '';
           $pdo = $this->getPdo();
           $stmt = $pdo->prepare($sql);
           $stmt->execute();
       }


        return $data['page'];
    }

    public function updateProductQuantity($productId, $quantity){
        $pdo = $this->getPdo();
        $sql = 'UPDATE `products` SET `product_qty` = (`product_qty` + ' . $quantity . ') WHERE `product_id` = ' . $productId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function recordTransaction($transactionId){
        $transaction = $this->getOrdersByTransactionId($transactionId);
        $customer = $this->getCustomerById($transaction['customer_id']);
        $dateNow = date('Y-m-d');
        $sql = 'INSERT INTO `reports` (`transaction_id`, `customer_id`, `customer_name`, `amount_paid`, `profit`, `date_completed`)
                VALUES
                ("' . $transaction['transaction_id'] . '", "' . $customer['customer_id'] . '", "' . $customer['first_name'] . ' ' . $customer['last_name'] . '", "' . $transaction['total_price'] . '", "' . $transaction['total_profit'] . '", "' . $dateNow . '")';
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function getOrders(){
        $aColumns = array('invoice_id', 'customer_id', 'transaction_id', 'mode_of_payment', 'delivery_address', 'date_of_delivery', 'total_price', 'delivery_charge', 'date_ordered', 'status');
        // Indexed column (used for fast and accurate table cardinality)
        $sIndexColumn = 'invoice_id';

        // DB table to use
        $sTable = 'invoice';

        // Database connection information
        $gaSql = $this->mysqliConnection();
        // Input method (use $_GET, $_POST or $_REQUEST)
        $input =& $_GET;

        /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         */

        /**
         * Character set to use for the MySQL connection.
         * MySQL will return all strings in this charset to PHP (if the data is stored correctly in the database).
         */
        $gaSql['charset']  = 'utf8';

        /**
         * MySQL connection
         */
        $db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
        if (mysqli_connect_error()) {
            die( 'Error connecting to MySQL server (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
        }

        if (!$db->set_charset($gaSql['charset'])) {
            die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
        }


        /**
         * Paging
         */
        $sLimit = "";
        if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
            $sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
        }


        /**
         * Ordering
         */
        $aOrderingRules = array();
        if ( isset( $input['iSortCol_0'] ) ) {
            $iSortingCols = intval( $input['iSortingCols'] );
            for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
                if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
                    $aOrderingRules[] =
                        "`".$aColumns[ intval( $input['iSortCol_'.$i] ) ]."` "
                        .($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
                }
            }
        }

        if (!empty($aOrderingRules)) {
            $sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
        } else {
            $sOrder = "";
        }


        /**
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $iColumnCount = count($aColumns);

        if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
            $aFilteringRules = array();
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
                    $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string( $input['sSearch'] )."%'";
                }
            }
            if (!empty($aFilteringRules)) {
                $aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
            }
        }else{
            // custom filter


            if(isset($input['status'])){

                if($input['status'] != 'ALL'){
                    $aFilteringRules[] = "`status` = '".$db->real_escape_string( $input['status'] )."'";
                }


                if (!empty($aFilteringRules)) {
                    $aFilteringRules = array('('.implode(" AND ", $aFilteringRules).')');
                }
            }

        }

// Individual column filtering
        for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
            if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
                $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
            }
        }

        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
        } else {
            $sWhere = "";
        }





// Individual column filtering
        for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
            if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
                $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
            }
        }

        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
        } else {
            $sWhere = "";
        }


        /**
         * SQL queries
         * Get data to display
         */
        $aQueryColumns = array();
        foreach ($aColumns as $col) {
            if ($col != ' ') {
                $aQueryColumns[] = $col;
            }
        }

        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`
    FROM `".$sTable."`".$sWhere.$sOrder.$sLimit;


        $rResult = $db->query( $sQuery ) or die($db->error);

// Data set length after filtering
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
        list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

// Total data set length
        $sQuery = "SELECT COUNT(`".$sIndexColumn."`) FROM `".$sTable."`";
        $rResultTotal = $db->query( $sQuery ) or die($db->error);
        list($iTotal) = $rResultTotal->fetch_row();


        /**
         * Output
         */


        $output = array(
            "sEcho"                => intval($input['sEcho']),
            "iTotalRecords"        => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData"               => array(),
        );

        while ( $aRow = $rResult->fetch_assoc() ) {
            $row = array();
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if( $aColumns[$i] == 'invoice_id' ){
                    $id= $aRow[ $aColumns[$i]];
                }
                else if ( $aColumns[$i] == 'customer_id' ) {
                    $customerId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'transaction_id'){
                    $transactionId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'mode_of_payment'){
                    $modeOfPayment = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'delivery_address'){
                    $address = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'date_of_delivery'){
                    $dateDelivery = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'total_price'){
                    $totalPrice = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'delivery_charge'){
                    $deliveryCharge = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'date_ordered'){
                    $dateOrderd = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'status'){
                    $status = $aRow[ $aColumns[$i]];
                }

            }

            $customer = $this->getCustomerById($customerId);
            $row[] = $customer['first_name'] . ' ' . $customer['last_name'];
            $row[] = $transactionId;
            $row[] = $modeOfPayment;
            $row[] = $address;
            $row[] = date('m/d/Y', strtotime($dateDelivery));
            $row[] = 'Php'.number_format($totalPrice + $deliveryCharge, 2);
            $row[] = date('m/d/Y', strtotime($dateOrderd));
            $row[] = $status;
            $row[] = '<a href="invoice?page=orders&customer-id=' . $customerId . '&transaction-id=' . $transactionId . '"  class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View </a>';
            $output['aaData'][] = $row;

        }


        //  echo $sQuery;
        echo json_encode( $output );
    }



    public function getReports(){
        $aColumns = array('reports_id', 'transaction_id', 'customer_id', 'customer_name', 'amount_paid', 'profit', 'date_completed');
        // Indexed column (used for fast and accurate table cardinality)
        $sIndexColumn = 'reports_id';

        // DB table to use
        $sTable = 'reports';

        // Database connection information
        $gaSql = $this->mysqliConnection();
        // Input method (use $_GET, $_POST or $_REQUEST)
        $input =& $_GET;

        /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP server-side, there is
         * no need to edit below this line
         */

        /**
         * Character set to use for the MySQL connection.
         * MySQL will return all strings in this charset to PHP (if the data is stored correctly in the database).
         */
        $gaSql['charset']  = 'utf8';

        /**
         * MySQL connection
         */
        $db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
        if (mysqli_connect_error()) {
            die( 'Error connecting to MySQL server (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
        }

        if (!$db->set_charset($gaSql['charset'])) {
            die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
        }


        /**
         * Paging
         */
        $sLimit = "";
        if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
            $sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
        }


        /**
         * Ordering
         */
        $aOrderingRules = array();
        if ( isset( $input['iSortCol_0'] ) ) {
            $iSortingCols = intval( $input['iSortingCols'] );
            for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
                if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
                    $aOrderingRules[] =
                        "`".$aColumns[ intval( $input['iSortCol_'.$i] ) ]."` "
                        .($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
                }
            }
        }

        if (!empty($aOrderingRules)) {
            $sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
        } else {
            $sOrder = "";
        }


        /**
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $iColumnCount = count($aColumns);

        if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
            $aFilteringRules = array();
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
                    $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string( $input['sSearch'] )."%'";
                }
            }
            if (!empty($aFilteringRules)) {
                $aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
            }
        }else{
            // custom filter


            if(isset($input['from'])){
                    $from = date('Y-m-d', strtotime($input['from']));
                    $to = date('Y-m-d', strtotime($input['to']));

                    $aFilteringRules[] = "`date_completed` >= '".$from." AND `date_completed` <= ".$to."'";



                if (!empty($aFilteringRules)) {
                    $aFilteringRules = array('('.implode(" AND ", $aFilteringRules).')');
                }
            }

        }

// Individual column filtering
        for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
            if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
                $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
            }
        }

        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
        } else {
            $sWhere = "";
        }





// Individual column filtering
        for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
            if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
                $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
            }
        }

        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
        } else {
            $sWhere = "";
        }


        /**
         * SQL queries
         * Get data to display
         */
        $aQueryColumns = array();
        foreach ($aColumns as $col) {
            if ($col != ' ') {
                $aQueryColumns[] = $col;
            }
        }

        $sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`
    FROM `".$sTable."`".$sWhere.$sOrder.$sLimit;


        $rResult = $db->query( $sQuery ) or die($db->error);

// Data set length after filtering
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
        list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

// Total data set length
        $sQuery = "SELECT COUNT(`".$sIndexColumn."`) FROM `".$sTable."`";
        $rResultTotal = $db->query( $sQuery ) or die($db->error);
        list($iTotal) = $rResultTotal->fetch_row();


        /**
         * Output
         */


        $output = array(
            "sEcho"                => intval($input['sEcho']),
            "iTotalRecords"        => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData"               => array()
        );

        $totalPaid = 0;
        $totalProfit = 0;
        while ( $aRow = $rResult->fetch_assoc() ) {
            $row = array();
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if( $aColumns[$i] == 'reports_id' ){
                    $id= $aRow[ $aColumns[$i]];
                }
                else if ( $aColumns[$i] == 'customer_id' ) {
                    $customerId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'transaction_id'){
                    $transactionId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'customer_name'){
                    $customerName = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'amount_paid'){
                    $amountPaid = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'profit'){
                    $profit = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'date_completed'){
                    $dateCompleted = date('m/d/Y', strtotime($aRow[ $aColumns[$i]]));
                }

            }

            $row[] = $id;
            $row[] = $transactionId;
            $row[] = $customerName;
            $row[] = $dateCompleted;
            $row[] = 'Php' . number_format($amountPaid, 2);
            $row[] = 'Php' . number_format($profit, 2);
            $row[] = '<a href="invoice?page=orders&customer-id=' . $customerId . '&transaction-id=' . $transactionId . '"  class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View </a>';
            $output['aaData'][] = $row;

            $totalPaid += $amountPaid;
            $totalProfit += $profit;

        }

            $output['totalPaid'] = 'Php' . number_format($totalPaid, 2);
            $output['totalProfit'] = 'Php' . number_format($totalProfit, 2);
        //  echo $sQuery;
        echo json_encode( $output );
    }


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
                                        "COMPLETE",
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
                                     ("' .  $invoiceId . '",
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



        $items = $this->getOrderItemsByInvoiceId($invoiceId);
        foreach($items as $item){
            $this->updateProductQuantity($item['product_id'], -$item['quantity']);
        }

        $this->recordTransaction($data['info']['invoiceId']);



    }


    public function mysqliConnection(){
        $gaSql['user']     = 'root';
        $gaSql['password'] = '';
        $gaSql['db']       = 'cyberlink_db';
        $gaSql['server']   = 'localhost';
        $gaSql['port']     = 3306; // 3306 is the default MySQL port

        return $gaSql;
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