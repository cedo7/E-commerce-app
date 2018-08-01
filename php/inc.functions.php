<?php
require_once '/var/www/licenta/vendor/autoload.php';

// Connect to database
$db = new MysqliDb('localhost', 'superUser', 'pass', 'Licenta');

// ===================================
// GLOBAL VARIABLES
// ===================================
// pagination of elements
$items_per_page = 6;


$currentUrl =  $_SERVER['REQUEST_URI'];
$currentPath = parse_url($currentUrl, PHP_URL_PATH);
parse_str( parse_url($currentUrl, PHP_URL_QUERY), $queryFilter);
$fullUrl = $currentPath . "?" . http_build_query($queryFilter);



// ===================================
// DECLARE TABLES
// ===================================


$arr_product_tables = ['processors', 'videoCards', 'motherboards', 'RAM', 'ssd', 'hdd', 'sources', 'cases', 'coolers'];



// ===================================
// FUNCTIONS
// ===================================


function prettyPrint($arr){
    print("<pre>".print_r($arr,true)."</pre>");
}


function getAllProductsFromOneCategory($table){
    global $db;
    $products = $db->get ($table, null, $cols=[]);
    if ($db->count > 0){
        return $products;
    }else{
        return false;
    }
}


function getOneProductFromOneCategory($table, $id){
    global $db;
    $db->where ("id", $id);
    $prod = $db->getOne ($table);
    if ($db->count) {
        return $prod;
    }else{
        return false;
    }
}


function updatePrice($table, $id, $newPrice, $discount){
    global $db;
    $db->where('id', $id);
    $data = Array (
            'price2' => $newPrice,
            'discount' => $discount,
        );
    if($db->update($table, $data)){
        return true;
    }else{
        return false;
    }
}


function removeProdFromCart($tableid){
    global $db;
    $db->where('id', $tableid);
    if($db->delete('shopcart')){
        return true;
    }else{
        return false;
    }
}

function updateQantProdFromCart($tableid, $action){
    global $db;
    if ($action == 'inc') {
        $tmpAct = $db->inc(1);
    }elseif ($action == 'dec') {
        $tmpAct = $db->dec(1);
    }

    $data = Array (
            'quantity' => $tmpAct,
        );
    $db->where('id', $tableid);
    if($db->update('shopcart', $data)){
        return true;
    }else{
        return false;
    }
}



function input($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    return $data;
}


// ===================================
// LOGIN
// ===================================
function login($username, $password){
    global $db;
    $query = $db->rawQuery("SELECT * FROM users WHERE username='$username' AND password='$password'");


    if(count($query) > 0){
        return true;
    } else {
        return false;
    }
}

// ===================================
// FORGOT PASSWORD
// ===================================
function forgotPassword($email){
    global $db;
    $query = $db->rawQueryOne("SELECT password FROM users WHERE email='$email'");

    if (count($query) > 0) {
        return $query['password'];
    } else {
        return false;
    }
}

function sendPassword($email, $password){
    $headers = "From: optimus@store.com\n";
    $subject = "Password recovery";
    $message = "Hello from Optimus online store. We are pleased that you have chosen us." . "\nThis is your password: " .$password;
    mail($email,$subject,$message,$headers);
}

// ===================================
// REGISTER
// ===================================
function register($username, $email, $password){
    global $db;
    $queryEmail = $db->rawQueryOne("SELECT * FROM users WHERE email='$email' OR username='$username'");

    if(count($queryEmail) > 0){
        return false;
    } else {
        $query = $db->rawQuery("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        return true;
    }
}

// ==============================
// ADMIN ADD PRODUCTS
// ==============================

$arrProduct_keys_processors = ['name', 'stock', 'brand', 'type', 'cores', 'cache', 'socket', 'price'];

$arrProduct_keys_videoCards = ['name', 'stock', 'brand', 'chipset', 'model', 'memory', 'busMemory', 'price'];

$arrProduct_keys_motherboards = ['name', 'stock', 'brand', 'chipset', 'socket', 'memory', 'format', 'price'];

$arrProduct_keys_RAM = ['name', 'stock', 'brand', 'frequency', 'capacity', 'memory', 'latency', 'price'];

$arrProduct_keys_ssd = ['name', 'stock', 'brand', 'interface', 'capacity', 'memory', 'form', 'price'];

$arrProduct_keys_hdd = ['name', 'stock', 'brand', 'interface', 'capacity', 'rotation', 'type', 'price'];

$arrProduct_keys_sources = ['name', 'stock', 'brand', 'format', 'power', 'modular', 'price'];

$arrProduct_keys_cases = ['name', 'stock', 'brand', 'type', 'format', 'source', 'fans', 'price'];

$arrProduct_keys_coolers = ['name', 'stock', 'brand', 'socket', 'cooling', 'price'];





// ===================================
// DECLARE FILTERS
// ===================================


// PROD.PHP
$arr_product_keys_processors = ['name', 'brand', 'type', 'cores', 'cache', 'socket', 'price'];

$arr_product_keys_videoCards = ['name', 'brand', 'chipset', 'model', 'memory', 'busMemory', 'price'];

$arr_product_keys_motherboards = ['name', 'brand', 'chipset', 'socket', 'memory', 'format', 'price'];

$arr_product_keys_RAM = ['name', 'brand', 'frequency', 'capacity', 'memory', 'latency', 'price'];

$arr_product_keys_ssd = ['name', 'brand', 'interface', 'capacity', 'memory', 'form', 'price'];

$arr_product_keys_hdd = ['name', 'brand', 'interface', 'capacity', 'rotation', 'type', 'price'];

$arr_product_keys_sources = ['name', 'brand', 'format', 'power', 'modular', 'price'];

$arr_product_keys_cases = ['name', 'brand', 'type', 'format', 'source', 'fans', 'price'];

$arr_product_keys_coolers = ['name', 'brand', 'socket', 'cooling', 'price'];



// CHANGING FILTER APPEREANCE
$arr_filter_processors= [
    'cores' => 'No of cores',
    'cache' => 'Cache memory',
    ];

$arr_filter_videoCards= [
    'busMemory' => 'BUS memory',
    ];

$arr_filter_motherboards= [
    'socket' => 'CPU socket',
    ];

$arr_filter_RAM= [
    'latency' => 'CAS latency',
    ];

$arr_filter_ssd= [
    'form' => 'Form factor',
    ];

$arr_filter_hdd= [
    'rotation' => 'Rotation speed',
    'type' => 'HDD type',
    ];

$arr_filter_cases= [
    'fans' => 'Fans included',
    ];

$arr_filter_coolers= [
    'cooling' => 'Cooling type',
    ];



function filter_processors(){

    $filter=[
        'price' => [
            '200 - 500' => ' between 200 and 500 ',
            '501 - 1000' => ' between 501 and 1000 ',
            '1.000 - 1.500'=> ' between 1000 and 1500 ',
            '1.500 - 2.000'=> ' between 1500 and 2000 ',
        ],
        'brand' => [
            'Intel' => " = 'intel' ",
            'AMD' => " = 'amd' ",
        ],
        'type' => [
            'Intel Core i7' => " = 'i7' ",
            'Intel Core i5' => " = 'i5' ",
            'Intel Core i3' => " = 'i3' ",
            'AMD Ryzen 7' => " = '7' ",
            'AMD Ryzen 5' => " = '5' ",
            'AMD Ryzen 3' => " = '3' ",
        ],
        'socket' => [
            '1151' => " = '1151' ",
            '1150' => " = '1150' ",
            'AM4' => " = '4' ",
        ],
        'cores' => [
            'Dual Core' => " = '2' ",
            'Quad Core' => " = '4' ",
            'Hexa Core' => " = '6' ",
            'Octa Core' => " = '8' ",
        ],
        'cache' => [
            '2 MB' => " = '2' ",
            '3 MB' => " = '3' ",
            '4 MB' => " = '4' ",
            '6 MB' => " = '6' ",
            '8 MB' => " = '8' ",
            '16 MB' => " = '16' ",
        ],
    ];
    return $filter;
}


function filter_videoCards(){

    $filter=[
        'price' => [
            '200 - 500' => ' between 200 and 500 ',
            '500 - 1.000' => ' between 500 and 1000 ',
            '1.000 - 1.500'=> ' between 1000 and 1500 ',
            '1.500 - 2.000'=> ' between 1500 and 2000 ',
            '2.000 - 3.000'=> ' between 2000 and 3000 ',
            '3.000 - 4.000'=> ' between 3000 and 4000 ',
        ],
        'brand' => [
            'ASUS' => " = 'ASUS' ",
            'GIGABYTE' => " = 'GIGABYTE' ",
            'MSI' => " = 'MSI' ",
        ],
        'chipset' => [
            'AMD' => " = 'AMD' ",
            'nVidia' => " = 'nVidia' ",
        ],
        'model' => [
            'GeForce GTX 1080' => " = 'GeForce GTX 1080' ",
            'GeForce GTX 1070' => " = 'GeForce GTX 1070' ",
            'GeForce GTX 1060' => " = 'GeForce GTX 1060' ",
            'GeForce GTX 1050' => " = 'GeForce GTX 1050' ",
            'Radeon RX 580' => " = 'Radeon RX 580' ",
        ],
        'memory' => [
            '2 GB' => " = '2' ",
            '4 GB' => " = '4' ",
            '6 GB' => " = '6' ",
            '8 GB' => " = '8' ",
        ],
        'busMemory' => [
            '128 bit' => " = '128' ",
            '256 bit' => " = '256' ",
        ],
    ];
    return $filter;
}


function filter_motherboards(){

    $filter=[
        'price' => [
            '200-500' => ' between 200 and 500 ',
            '501-700' => ' between 501 and 700 ',
            '701-1.000'=> ' between 701 and 1000 ',
        ],
        'brand' => [
            'ASUS' => " = 'ASUS' ",
            'GIGABYTE' => " = 'GIGABYTE' ",
            'MSI' => " = 'MSI' ",
        ],
        'chipset' => [
            'AMD' => " = 'AMD' ",
            'Intel' => " = 'Intel' ",
        ],
        'socket' => [
            '1151' => " = '1151' ",
            '1150' => " = '1150' ",
            'AM4' => " = 'AM4' ",
        ],
        'memory' => [
            'DDR4' => " = 'DDR4' ",
            'DDR3' => " = 'DDR3' ",
        ],
        'format' => [
            'ATX' => " = 'ATX' ",
            'Micro ATX' => " = 'mATX' ",
        ],
    ];
    return $filter;
}


function filter_RAM(){

    $filter=[
        'price' => [
            '100-400' => ' between 100 and 400 ',
            '401-700' => ' between 401 and 700 ',
            '701-1.000'=> ' between 701 and 1000 ',
        ],
        'brand' => [
            'Corsair' => " = 'Corsair' ",
            'HyperX' => " = 'HyperX' ",
            'Kingston' => " = 'Kingston' ",
        ],
        'frequency' => [
            '1600 MHz' => " = '1600' ",
            '2133 MHz' => " = '2133' ",
            '2400 MHz' => " = '2400' ",
        ],
        'capacity' => [
            '4 GB' => " = '4' " ,
            '8 GB' => " = '8' ",
            '16 GB' => " = '16' ",
        ],
        'memory' => [
            'DDR4' => " = 'DDR4' ",
            'DDR3' => " = 'DDR3' ",
        ],
        'latency' => [
            '14 CL' => " = '14' ",
            '15 CL' => " = '15' ",
            '16 CL' => " = '16' ",
        ],
    ];
    return $filter;
}


function filter_ssd(){

    $filter=[
        'price' => [
            '200-500' => ' between 200 and 500 ',
            '501-700' => ' between 501 and 700 ',
            '701-1.000'=> ' between 701 and 1000 ',
        ],
        'brand' => [
            'Samsung' => " = 'Samsung' ",
            'ADATA' => " = 'ADATA' ",
            'Kingston' => " = 'Kingston' ",
        ],
        'interface' => [
            'SATA III' => " = 'SATA 3' ",
            'PCI Express' => " = 'PCI Express' ",
            'M.2' => " = 'M.2' ",
        ],
        'capacity' => [
            '60 - 128' => ' between 60 and 128 ' ,
            '129 - 256' => ' between 129 and 256 ',
            '257 - 512' => ' between 257 and 512 ',
        ],
        'memory' => [
            'MLC' => " = 'MLC' ",
            'TLC' => " = 'TLC' ",
        ],
        'form' => [
            '2.5"' => " = '2.5\"' ",
            'M.2' => " = 'M.2' ",
            'PCI-E' => " = 'PCI-E' ",
        ],
    ];
    return $filter;
}


function filter_hdd(){

    $filter=[
        'price' => [
            '200-500' => ' between 200 and 500 ',
            '501-700' => ' between 501 and 700 ',
            '701-1.000'=> ' between 701 and 1000 ',
            '1.001-1.500'=> ' between 1001 and 1500 ',
        ],
        'brand' => [
            'Seagate' => " = 'Seagate' ",
            'WD' => " = 'WD' ",
            'Toshiba' => " = 'Toshiba' ",
        ],
        'interface' => [
            'SATA III' => " = 'SATA 3' ",
            'SAS' => " = 'SAS' ",
            'SATA' => " = 'SATA' ",
        ],
        'capacity' => [
            '1 TB' => " = '1' " ,
            '2 TB' => " = '2' ",
            '4 TB' => " = '4' ",
        ],
        'rotation' => [
            '5400 rpm' => " = '5400' ",
            '7200 rpm' => " = '7200' ",
        ],
        'type' => [
            'Desktop PC' => " = 'Desktop PC' ",
            'Surveillance' => " = 'Surveillance' ",
            'Server' => " = 'Server' ",
        ],
    ];
    return $filter;
}


function filter_sources(){

    $filter=[
        'price' => [
            '200-500' => ' between 200 and 500 ',
            '501-700' => ' between 501 and 700 ',
            '701-1.000'=> ' between 701 and 1000 ',
            '1.001-1.500'=> ' between 1001 and 1500 ',
        ],
        'brand' => [
            'Seasonic' => " = 'Seasonic' ",
            'Corsair' => " = 'Corsair' ",
            'Inter-Tech' => " = 'Inter-Tech' ",
        ],
        'format' => [
            'ATX' => " = 'ATX' ",
            'SFX' => " = 'SFX' ",
            'TFX' => " = 'TFX' ",
        ],
        'power' => [
            '500 - 800 W' => ' between 500 and 800 ' ,
            '801 - 1000 W' => ' between 801 and 1000 ',
            'Over 1000 W' => ' > 1000 ',
        ],
        'modular' => [
            'Yes' => " = 'Yes' ",
            'No' => " = 'No' ",
        ],
    ];
    return $filter;
}


function filter_cases(){

    $filter=[
        'price' => [
            '200-500' => ' between 200 and 500 ',
            '501-700' => ' between 501 and 700 ',
            '701-1.000'=> ' between 701 and 1000 ',
        ],
        'brand' => [
            'Segotep' => " = 'Segotep' ",
            'Thermaltake' => " = 'Thermaltake' ",
            'Zalman' => " = 'Zalman' ",
        ],
        'format' => [
            'ATX' => " = 'ATX' ",
            'Micro ATX' => " = 'mATX' ",
            'Mini ITX' => " = 'mITX' ",
        ],
        'type' => [
            'Full Tower' => " = 'Full' ",
            'Middle Tower' => " = 'Middle' ",
            'Mini Tower' => " = 'Mini' ",
        ],
        'source' => [
            'Yes' => " = 'Yes' ",
            'No' => " = 'No' ",
        ],
        'fans' => [
            '1' => " = '1' ",
            '2' => " = '2' ",
            '3' => " = '3' ",
        ],
    ];
    return $filter;
}


function filter_coolers(){

    $filter=[
        'price' => [
            '100-400' => ' between 100 and 400 ',
            '401-700' => ' between 401 and 700 ',
            '701-1.000'=> ' between 701 and 1000 ',
        ],
        'brand' => [
            'DeepCool' => " = 'DeepCool' ",
            'ARCTIC' => " = 'ARCTIC' ",
            'Noctua' => " = 'Noctua' ",
        ],
        'socket' => [
            '1151' => " = '1151' ",
            '1150' => " = '1150' ",
            'AM4' => " = 'AM4' ",
        ],
        'cooling' => [
            'Air' => " = 'Air' ",
            'Liquid' => " = 'Liquid' ",
        ],
    ];
    return $filter;
}


?>