<?php

class Customer extends Orders{
    public $debug = TRUE;
    protected $db_pdo;

    public function getCustomerById($customerId){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `customers` WHERE `customer_id` = "'. $customerId .'"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $content = $stmt->fetch(PDO::FETCH_ASSOC);
        return $content;
    }

    public function getCustomers(){
        $aColumns = array('customer_id', 'first_name', 'last_name', 'address', 'home_number', 'mobile_number');
        // Indexed column (used for fast and accurate table cardinality)
        $sIndexColumn = 'customer_id';

        // DB table to use
        $sTable = 'customers';

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
                if ( $aColumns[$i] == 'customer_id' ) {
                    $customerId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'first_name'){
                    $firstName = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'last_name'){
                    $lastName = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'address'){
                    $address = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'home_number'){
                    $homeNo = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'mobile_number'){
                    $mobileNo = $aRow[ $aColumns[$i]];
                }

            }
            $pendingCount = count($this->getPendingOrdersByCustomerId($customerId, 'PENDING'));
            $approvedCount = count($this->getPendingOrdersByCustomerId($customerId, 'ALL'));
            $row[] = $firstName . ' ' . $lastName;
            $row[] = $address;
            $row[] = $homeNo;
            $row[] = $mobileNo;
            $row[] = '<a href="customer-orders?customer-id=' . $customerId . '&status=PENDING" class="btn btn-info btn-xs"><span class="badge badge-success">' . $pendingCount . '</span> PENDING</a>
                      <a href="customer-orders?customer-id=' . $customerId . '&status=ALL" class="btn btn-success btn-xs"><span class="badge badge-success">' . $approvedCount . '</span> Order History</a>';
            $output['aaData'][] = $row;

        }


        //  echo $sQuery;
        echo json_encode( $output );
    }


    public function getCustomerOrdersById($customerId, $status){
        $aColumns = array('customer_id', 'transaction_id', 'mode_of_payment', 'delivery_address', 'date_of_delivery', 'total_price', 'status');
        // Indexed column (used for fast and accurate table cardinality)
        $sIndexColumn = 'customer_id';

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

        if($status == 'ALL'){
            if (!empty($aFilteringRules)) {
                $sWhere = " WHERE ".implode(" AND ", $aFilteringRules). "AND `customer_id` = " . $customerId . " AND `status` !=  'PENDING'";
            } else {
                $sWhere = " WHERE `customer_id` = " . $customerId . " AND `status` !=  'PENDING'";
            }
        }else{
            if (!empty($aFilteringRules)) {
                $sWhere = " WHERE ".implode(" AND ", $aFilteringRules). "AND `customer_id` = " . $customerId . " AND `status` = '" . $status . "'";
            } else {
                $sWhere = " WHERE `customer_id` = " . $customerId . " AND `status` = '" . $status . "'";
            }
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
                if ( $aColumns[$i] == 'customer_id' ) {
                    $customerId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'transaction_id'){
                    $transactionId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'mode_of_payment'){
                    $modeOfPayment = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'delivery_address'){
                    $deliveryAddress = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'date_of_delivery'){
                    $dateOfDelivery = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'total_price'){
                    $totalPrice = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'status'){
                    $status = $aRow[ $aColumns[$i]];
                }

            }
            $row[] = $transactionId;
            $row[] = $modeOfPayment;
            $row[] = $deliveryAddress;
            $row[] = date('m/d/Y', strtotime($dateOfDelivery));
            $row[] = 'Php' . number_format($totalPrice);
            $row[] = $status;
            $row[] = '<a href="invoice?page=customer&customer-id=' . $customerId . '&transaction-id=' . $transactionId . '"  class="btn btn-info btn-xs"><i class="fa fa-eye"></i> View </a>';
            $output['aaData'][] = $row;

        }


        //  echo $sQuery;
        echo json_encode( $output );
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