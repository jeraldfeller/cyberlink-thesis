<?php


class Products {

    public $debug = TRUE;
    protected $db_pdo;

    public function getPosItems(){
        $pdo = $this->getPdo();
        $sql = 'SELECT category.title,
                       brand.brand_name,
                       products.*
                  FROM `category`, `brand`, `products`
                  WHERE products.product_qty != 0 AND products.cat_id = category.cat_id AND products.brand_id = brand.brand_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getBrand(){
        $pdo = $this->getPdo();
        $sql = 'SELECT `brand_name` FROM `brand`';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getBrandByName($brandName){
        $pdo = $this->getPdo();
        $sql = 'SELECT `brand_id` FROM `brand` WHERE `brand_name` = "' . $brandName . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getBrandById($brandId){
        $pdo = $this->getPdo();
        $sql = 'SELECT `brand_name` FROM `brand` WHERE `brand_id` = "' . $brandId . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function addBrand($brandName){

        $pdo = $this->getPdo();
        $sql = 'INSERT INTO `brand` (`brand_name`) VALUES ("' . $brandName . '")';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $lastId = $pdo->lastInsertId();

        return $lastId;
    }

    public function addProduct($catId, $supId, $stockId, $productName, $description, $originalPrice, $sellingPrice, $quantity, $profit, $brandName, $dateArrival, $image, $isFeatured){

        $isExistBrand = $this->getBrandByName($brandName);
        if(count($isExistBrand) == 1){
            $brandId = $isExistBrand[0]['brand_id'];
        }else{
            $brandId = $this->addBrand($brandName);
        }

        $pdo = $this->getPdo();

        $sql = 'INSERT INTO `products` (`cat_id`,
                                        `brand_id`,
                                        `sup_id`,
                                        `stock_id`,
                                        `product_name`,
                                        `description`,
                                        `date_arrival`,
                                        `original_price`,
                                        `selling_price`,
                                        `profit`,
                                        `product_qty`,
                                        `image_name`,
                                        `featured`) VALUES
                                        ("' . $catId . '",
                                         "' . $brandId . '",
                                         "' . $supId . '",
                                         "' . $stockId . '",
                                         "' . $productName . '",
                                         "' . $description. '",
                                         "' . $dateArrival . '",
                                         "' . $originalPrice . '",
                                         "' . $sellingPrice . '",
                                         "' . $profit . '",
                                         "' . $quantity . '",
                                         "' . $image . '",
                                         "' . $isFeatured . '")';

        $stmt = $pdo->prepare($sql);

        $stmt->execute();


        return true;

    }


    public function editProduct($productId, $catId, $supId, $stockId, $productName, $description, $originalPrice, $sellingPrice, $quantity, $profit, $brandName, $dateArrival, $image, $isFeatured){

        $isExistBrand = $this->getBrandByName($brandName);
        if(count($isExistBrand) == 1){
            $brandId = $isExistBrand[0]['brand_id'];
        }else{
            $brandId = $this->addBrand($brandName);
        }

        $pdo = $this->getPdo();

        $sql = ' UPDATE `products` SET
                `cat_id` = ' . $catId . ',
                `brand_id` = ' . $brandId . ',
                `sup_id` = ' . $supId . ',
                `stock_id` = "' . $stockId . '",
                `product_name` = "' . $productName . '",
                `description` = "' . $description . '",
                `date_arrival` = "' . $dateArrival . '",
                `original_price` = "' . $originalPrice . '",
                `selling_price` = "' . $sellingPrice . '",
                `profit` = "' . $profit . '",
                `product_qty` ="' . $quantity . '",
                `image_name` = "' . $image . '",
                `featured` = "' . $isFeatured . '"
                WHERE `product_id` = ' . $productId . '
        ';
        $stmt = $pdo->prepare($sql);

        $stmt->execute();


        return true;

    }


    public function deleteProduct($productId){

        $pdo = $this->getPdo();
        $sql = 'DELETE FROM `products` WHERE `product_id` = ' . $productId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function getProduct(){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `products`';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }

    public function getProductById($productId){
        $pdo = $this->getPdo();
        $sql = 'SELECT * FROM `products` WHERE `product_id` = ' . $productId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }



    public function getCategoryById($catId){
        $pdo = $this->getPdo();
        $sql = 'SELECT `title` FROM `category` WHERE `cat_id` = "' . $catId . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }


    public function getSupplierById($supId){
        $pdo = $this->getPdo();
        $sql = 'SELECT `supplier_name` FROM `supplier` WHERE `sup_id` = "' . $supId . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }
        return $content;
    }


    public function borrowItem($productId, $quantity, $notes){
        $isQuantityValid = $this->countProductQuantityLeft($productId, $quantity);
        if($isQuantityValid == true){
            $this->updateProductQuantity($productId, -$quantity);
            $this->updateBorrowedQuantity($productId, $quantity);
            $dateNow = date('Y-m-d');
            $pdo = $this->getPdo();
            $sql = 'INSERT INTO `borrowed_items` (`product_id`, `quantity`, `notes`, `date_borrowed`) VALUES (' . $productId . ', ' . $quantity . ', "' . $notes . '", "' . $dateNow . '")';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return true;
        }else{
            return false;
        }

    }

    public function countProductQuantityLeft($productId, $quantity){
        $pdo = $this->getPdo();
        $sql = 'SELECT `product_qty` FROM `products` WHERE `product_id` = "' . $productId . '"';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $content = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $content[] = $row;
        }

        if($content[0]['product_qty'] > $quantity){
            return true;
        }else{
            return false;
        }
    }

    public function updateBorrowedQuantity($productId, $quantity){
        $pdo = $this->getPdo();
        $sql = 'UPDATE `products` SET `borrowed_item` = (`borrowed_item` + ' .$quantity . ') WHERE `product_id` = ' . $productId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function updateProductQuantity($productId, $quantity){
        $pdo = $this->getPdo();
        $sql = 'UPDATE `products` SET `product_qty` = (`product_qty` + ' . $quantity . ') WHERE `product_id` = ' . $productId . '';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }



    public function getProducts(){
        $aColumns = array('product_id', 'cat_id', 'brand_id', 'sup_id', 'stock_id', 'product_name', 'description', 'date_arrival', 'original_price', 'selling_price', 'profit', 'borrowed_item', 'product_qty', 'no_item_sold', 'total_profit', 'image_name', 'featured');
        // Indexed column (used for fast and accurate table cardinality)
        $sIndexColumn = 'product_id';

        // DB table to use
        $sTable = 'products';

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
                if( $aColumns[$i] == 'image_name' ) {
                    $image = $aRow[ $aColumns[$i]];
                }
                else if ( $aColumns[$i] == 'product_id' ) {
                    $productId = $aRow[ $aColumns[$i]];
                }else if($aColumns[$i] == 'cat_id'){
                    $category = $this->getCategoryById($aRow[ $aColumns[$i]]);
                    $catId = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'brand_id' ) {
                    $brand = $this->getBrandById($aRow[ $aColumns[$i]]);
                }
                else if ( $aColumns[$i] == 'sup_id' ) {
                    $supplier = $this->getSupplierById($aRow[ $aColumns[$i]]);
                    $supId = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'stock_id' ) {
                    $stockId = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'product_name' ) {
                    $productName = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'description' ) {
                    $description = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'date_arrival' ) {
                    $dateArrival = date('m/d/Y', strtotime($aRow[ $aColumns[$i]]));
                }else if ( $aColumns[$i] == 'original_price' ) {
                    $originalPrice = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'selling_price' ) {
                    $sellingPrice = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'profit' ) {
                    $profit = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'borrowed_item' ) {
                    $borrowedItem = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'product_qty' ) {
                    $quantity = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'selling_price' ) {
                    $sellingPrice = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] =='no_item_sold' ) {
                    $noItemSold = $aRow[ $aColumns[$i]];
                }else if ( $aColumns[$i] == 'total_profit' ) {
                    $totalProfit = $aRow[ $aColumns[$i]];
                }else if( $aColumns[$i] == 'featured' ){
                    $isFeatured = $aRow[ $aColumns[$i]];
                    if($isFeatured == 1){
                        $featured = 'Yes';
                    }else{
                        $featured = 'No';
                    }
                }


            }

            //$row[] = '<img src="data:image/jpeg;base64,'.base64_encode( $image ).'" width="75" height="75">';
            $row[] = '<img src="/images/products/' . $image . '"  width="100" height="100">';
            $row[] = $category[0]['title'];
            $row[] = $brand[0]['brand_name'];
            $row[] = $stockId;
            $row[] = $productName;
            $row[] = $description;
            $row[] = $supplier[0]['supplier_name'];
            $row[] = $dateArrival;
            $row[] = number_format($originalPrice);
            $row[] = number_format($sellingPrice);
            $row[] = number_format($profit);
            $row[] = $borrowedItem;
            $row[] = $quantity;
            $row[] = $noItemSold;
            $row[] = number_format($totalProfit);
            $row[] = $featured;
            $row[] = '<i style="cursor:pointer;" data-action="edit"
                        data-id="'.$productId.'"
                         data-stock-id="' . $stockId . '"
                         data-product-name="' . $productName . '"
                         data-description="' . $description . '"
                         data-original-price="' . $originalPrice . '"
                         data-selling-price="' . $sellingPrice . '"
                         data-profit="' . $profit . '"
                         data-date-arrival="' . $dateArrival . '"
                         data-quantity="' . $quantity . '"
                         data-supplier="' . $supId . '"
                         data-category="' . $catId . '"
                         data-brand-name="' . $brand[0]['brand_name'] . '"
                         data-file-name="' . $image . '"
                         data-feature="' . $isFeatured . '"
                        onClick="pushData(this);" data-toggle="modal"  href="#modalEditProduct" class="fa fa-edit editTooltip"></i>
                        <i style="cursor:pointer;" data-action="borrow" data-id="'.$productId.'" data-product-name="' . $productName . '" data-quantity="' . $quantity . '" onClick="pushData(this);" data-toggle="modal"  href="#modalBorrowProduct" class="fa fa-hand-o-up borrowTooltip"></i>
                <i style="cursor:pointer;" data-action="delete" data-id="'.$productId.'" data-product-name="' . $productName . '" onClick="pushData(this);" data-toggle="modal"  href="#modalDeleteProduct" class="fa fa-times deleteTooltip"></i>';
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