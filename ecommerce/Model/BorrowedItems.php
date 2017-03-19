<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 3/13/2017
 * Time: 12:16 AM
 */

class BorrowedItems extends Products{
    public $debug = TRUE;
    protected $db_pdo;


    public function returnItem($borrowedItemsId, $productId, $quantity, $action){
        $this->updateProductQuantity($productId, $quantity);
        $this->updateBorrowedQuantity($productId, -$quantity);
        if($action == 'update'){
            $sql = 'UPDATE `borrowed_items` SET `quantity` = (`quantity` - ' . $quantity . ') WHERE `borrowed_items_id` = ' . $borrowedItemsId . '';
        }else if($action == 'delete'){
            $sql = 'DELETE FROM `borrowed_items` WHERE `borrowed_items_id` = ' . $borrowedItemsId . '';
        }
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return true;

    }

    public function updateBorrowedItemsQuantity($borrowedItemsId, $quantity){

    }

    public function getBorrowedItems(){
        $aColumns = array('borrowed_items_id', 'product_id', 'quantity', 'notes', 'date_borrowed');
        // Indexed column (used for fast and accurate table cardinality)
        $sIndexColumn = 'borrowed_items_id';

        // DB table to use
        $sTable = 'borrowed_items';

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
                if( $aColumns[$i] == 'borrowed_items_id' ) {
                    $borrowedItemsId = $aRow[ $aColumns[$i]];
                }
                else if ( $aColumns[$i] == 'product_id' ) {
                    $products = $this->getProductById( $aRow[ $aColumns[$i]]);
                    $productId = $aRow[ $aColumns[$i]];
                    $productName = $products[0]['product_name'];
                    $category = $this->getCategoryById($products[0]['cat_id'])[0]['title'];
                    $brand = $this->getBrandById($products[0]['brand_id'])[0]['brand_name'];
                }else if($aColumns[$i] == 'quantity'){
                    $quantity = $aRow[ $aColumns[$i] ];
                }else if ( $aColumns[$i] == 'notes' ) {
                    $notes = $aRow[ $aColumns[$i]];
                }
                else if ( $aColumns[$i] == 'date_borrowed' ) {
                    $dateBorrowed = $aRow[ $aColumns[$i]];
                }


            }

            $row[] = $category;
            $row[] = $brand;
            $row[] = $productName;
            $row[] = $quantity;
            $row[] = $notes;
            $row[] = date('m/d/Y', strtotime($dateBorrowed));
            $row[] = '<i style="cursor:pointer;" data-action="edit"
                         data-id="'.$borrowedItemsId.'"
                         data-product-id="' . $productId . '"
                         data-product-name="' . $productName . '"
                         data-quantity="' . $quantity . '"
                         onClick="pushData(this);" data-toggle="modal"  href="#modalReturnProduct" class="fa fa-reply returnTooltip"></i>';
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