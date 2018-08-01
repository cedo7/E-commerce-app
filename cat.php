<?php

include_once 'php/inc.functions.php';
include_once 'inc.header.php';
include_once 'inc.navbar.php';



// check what is the current category
if (isset($_GET['cat'])) {
    $curCat = $_GET['cat'];
}else{
    exit();
}

// delete some filters
if (isset($_GET['delFilter'])) {
    $delFilter = $_GET['delFilter'];
    if (in_array($delFilter, $queryFilter)) {
        unset($queryFilter[$delFilter]);
        unset($queryFilter['delFilter']);
        $fullUrl = $currentPath . "?" . http_build_query($queryFilter);
    }
}

// echo "<br>";
// print_r($queryFilter);
// echo "<br>";


// get filters from functions dinamically
$filterFunc = 'filter_'.$curCat;
$filter = $filterFunc();
$filter_keys = array_keys($filter); // get the keys only



// check if there are filters
$arrWeHaveFilters = array_intersect($filter_keys,array_keys($queryFilter));
// print_r($arrWeHaveFilters);
// echo "<br>";


// generate sql complex query
$sql = 'select * from  '. $curCat . ' ' ;
$sqlFilter = '';
if (count($arrWeHaveFilters)) {
    // we have filters
    $countFilters = 0;
    foreach ($arrWeHaveFilters as $kF => $vF) {
        $tmpValueFilter = $queryFilter[$vF];
        if ($countFilters==0) {
            $sqlFilter .= " where $vF  " . $filter[$vF][$tmpValueFilter];
        }else{
            $sqlFilter .= " and  $vF " . $filter[$vF][$tmpValueFilter];
        }
        $countFilters++;
    }

    // $sql .= ' limit 6';

}else{
    // $sql = "select * from $curCat";
}
$sql .= $sqlFilter;

//echo $sql;







$curPage = 1;
$items_per_page = 6; // => FROM functions.php !!!

if (isset($_GET['page'])) {
    $curPage = $_GET['page'];
}
// offset used for query limitation
$offset = ($curPage - 1) * $items_per_page;

$q = $db->rawQuery( $sql . " order by id asc LIMIT " . $offset . "," . $items_per_page);


// calculate total pages for pagination
$countCpu = $db->rawQueryOne("SELECT count(*) as cnt FROM $curCat " . $sqlFilter);
$totalPages = ceil($countCpu['cnt'] / $items_per_page );






?>

<div class="container">
    <div class="row">
        <aside class="col-sm-2">
            <h1>Filters</h1>
            <ul class="list-group"><br>

<?php

// generate the filter menu
foreach ($filter_keys as $kcat => $fcat) {
    $tmpFilterTitle = $fcat;
    if (isset( ${'arr_filter_'.$curCat}  )) {
        if (  array_key_exists($fcat, ${'arr_filter_'.$curCat}) ) {
            $tmpFilterTitle = ${'arr_filter_'.$curCat}[$fcat];
        }
    }
    echo '<li class="list-group-item">
                    <a data-toggle="collapse" href="#'.$fcat.'" style="font-size:20px;">'.ucfirst($tmpFilterTitle).' <span class="glyphicon glyphicon-chevron-down" style="font-size:15px;"></span></a>
            <ul class="list-group collapse in" id="'.$fcat.'">';

    foreach ($filter[$fcat] as $k => $v) {
        echo '<li class="list-group-item">
                <a href="' .$fullUrl. '&' .$fcat.'='.$k.'&page=1">'.$k.'</a><BR>
            </li>';
    }
echo '     </ul>
                </li>';
}

?>



            </ul>
        </aside>
        <div class="col-sm-10">
            <h1><?php echo strtoupper($curCat);?></h1>
            <p><strong>Current filters:</strong><p>
            <div class="filter">

<?php
foreach ($arrWeHaveFilters as $key => $value) {
    echo '<button class="btn btn-primary disabled">'. ucfirst($value) .': ' . $queryFilter[$value] .' ' . '</button><a href="' .$fullUrl. '&delFilter='.$value.'" class="btn btn-danger text-danger"><i class="glyphicon glyphicon-remove"></i></a>&nbsp;&nbsp;';
}
?>
            </div>
            <hr class="line"><br>

<?php

echo '<div class="row">';

$counter = 1;
foreach ($q as $key => $prod) {

if ( ($counter ) % 3 == 0) {
    echo '<div class="row">';
}

echo '
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading"><h5><a href="prod.php?cat='.$curCat.'&id='.$prod['id'].'">'.$prod['name'].'</a></h5></div>
        <div class="panel-body"><img src="img/'.$curCat.'/'.$prod['id'].'/1.jpg" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <div class="text-center">
            <h5 style="font-size:15px;"><strong>Price:</strong> ' .$prod['price'].' $</h5>
            <a href="shopcart.php?cat='.$curCat.'&id='.$prod['id'].'" class="btn btn-primary btn-block">Add to cart!</a>
          </div>
        </div>
      </div>
    </div>
    ';
if ( ($counter ) % 3 == 0) {
    echo '</div>';
}

$counter++;
}

echo '</div>';
?>


            <div class="text-center">
                <ul class="pagination">

<?php
$page = 1;
while ( $page <= $totalPages) {
    if ($page == $curPage) {
        $activePage = ' class="active" ';
    }else{
        $activePage ='';
    }
    echo '<li '.$activePage.'><a href="'.$fullUrl.'&page='.$page.'">'.$page.'</a></li>';
    $page++;
}
?>
                </ul>
            </div><br>

        </div>
    </div>
</div>


<?php include_once 'inc.footer.php'; ?>