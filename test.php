<?php


$currentUrl =  $_SERVER['REQUEST_URI'];
$currentPath = parse_url($currentUrl, PHP_URL_PATH);
parse_str( parse_url($currentUrl, PHP_URL_QUERY), $queryFilter);



print_r($queryFilter);
echo "\n<BR>";

$fullUrl = $currentPath . "?" . http_build_query($queryFilter);

echo "\n<BR>";



// declare filters
$filter=[
    'price' => [
        '200-500' => ' between 200 and 500 ',
        '501-700' => ' between 501 and 700 ',
        '701-1000'=> ' between 701 and 1000 ',
    ],
    'brand' => [
        'Intel' => " = 'intel' ",
        'Amd' => " = 'amd' ",
    ]
];

$filters = array_keys($filter); // get the keys only
// print_r($filters);

echo "\n<br><br>";


// generate the filter menu
foreach ($filters as $kcat => $fcat) {
    echo "<br>-------  ". strtoupper($fcat) ."  --------------------<br>";
    foreach ($filter[$fcat] as $k => $v) {
        echo '<a href="' .$fullUrl. '&' .$fcat.'='.$k.'">'.$k.'</a>';  echo "\n<br>";
    }
}





if (count($queryFilter)) {
    // we have filters
    $sql = 'select * from cpu ';
    $countFilters = 0;
    foreach ($queryFilter as $kF => $vF) {
        if ($countFilters==0) {
            $sql .= " where $kF  " . $filter[$kF][$vF];
        }else{
            $sql .= " and  $kF " . $filter[$kF][$vF];

        }
        $countFilters++;
    }

    $sql .= ' limit 6';

    // run sql now
}else{
    $sql = "select * from processors";
}

echo $sql;


?>