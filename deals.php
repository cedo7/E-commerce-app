<?php
include_once 'inc.header.php';
include_once 'inc.navbar.php';
include_once 'php/inc.functions.php';



foreach ($arr_product_tables as $key => $vTable) {
    $deals[$vTable] = $db->rawQuery("SELECT * from $vTable WHERE price2 IS NOT NULL");

}
// prettyPrint($deals);



?>


<div class="container">
    <h1 style="font-size: 60px;" class="text-center">Best deals you can get!</h1><br><br>
    <div class="row">
<?php

foreach ($deals as $cat => $vProduct) {

    foreach ($vProduct as $key => $value) {
        echo '<div class="col-sm-4">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h5><a href="prod.php?cat='.$cat.'&id='.$vProduct[$key]['id'].'">' .$vProduct[$key]['name']. '</a></h5>
                </div>
                <div class="panel-body">
                    <img src="img/' .$cat. '/' .$vProduct[$key]['id']. '/1.jpg" class="img-responsive">
                </div>
                <div class="panel-footer text-center">
                    <h4><strong>Discount: </strong><span class="red"> ' .$vProduct[$key]['discount']. '%</span></h4>
                    <h4><strong>Price: </strong><del class="red">' .$vProduct[$key]['price']. '$</del> <span class="red"> ' .$vProduct[$key]['price2']. '$</span></h4>
                    <a href="shopcart.php?cat='.$cat.'&id='.$vProduct[$key]['id'].'" class="btn btn-danger btn-block">Add to cart!</a>
                </div>
            </div>
        </div>';
    }
}

?>
    </div>
</div>


<?php include_once 'inc.footer.php';?>