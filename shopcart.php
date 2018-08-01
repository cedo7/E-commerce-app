<?php
include_once 'inc.header.php';
include_once 'php/inc.functions.php';

// $shopcart_ahref = "shopcart.php?cat=$curCat&id=$curID";


// CHEC IF USER IS LOGGED
if (isset($_SESSION['user_login'])) {
    $login = 1;
} else {
    $login = 0;
}

// =========================
// CHECK IF ACTION
// =========================
if (isset($_GET['action']) ) {
    $action = $_GET['action'];

    // do not allow ADD
    if (isset($queryFilter['cat']) || isset($queryFilter['id']) ) {
        unset($queryFilter['cat']);
        unset($queryFilter['id']);
    }

    // ACTION DEL
    if ($action == 'del') {
        $tableid = $_GET['delid'];
        if(removeProdFromCart($tableid)){
            // echo "Product removed from CART<br>";
        }
    }

    // ACTION DEC or INC
    if ($action == 'inc' || $action == 'dec') {
        $tableid = $_GET['incid'];
        if(updateQantProdFromCart($tableid, $action)){
            //echo "Quantity updated<br>";
        }
    }
}







// check what is the current category and product to add to cart
if (isset($_GET['cat']) && isset($_GET['id']) ) {
    $curCat = $_GET['cat'];
    $curID = $_GET['id'];


    // check if product exists; if yes increment quantity
    $db->where ('cartid', $_SESSION['cartid']);
    $db->where ('cat_id',  $curCat);
    $db->where ('prod_id', $curID);
    $results = $db->get ('shopcart');

    // print_r($results);

    $curID_qant = 0;
    if (count($results)) {
        $curProdCartTableID = $results[0]['id'];
        $curID_qant = $results[0]['quantity'];
    }


    // increment current product quantity
    if ($curID_qant) {
        $data = Array (
            'quantity' => $db->inc(1),
            // editQuantity = editQuantity + 1;
        );
        $db->where ('id', $curProdCartTableID);
        if ($db->update ('shopcart', $data)){
            // echo $db->count . ' records were updated';
        }

    }else{
    // add new product to cart

        $data = Array ("cartid" => $_SESSION['cartid'],
                       "cat_id" => $curCat,
                       "prod_id" => $curID
        );
        $qid = $db->insert ('shopcart', $data);

        if($qid){
            // echo 'ADDED . Id=' . $qid;
        }


    } // end add product to cart or increment



unset($queryFilter['cat']);
unset($queryFilter['id']);
// end if cat and prod in get
}


// regenerate full URL
$fullUrl = $currentPath . "?" . http_build_query($queryFilter);






// ===================================
// GET ALL ENTRIES FROM SHOPPING CART
// ===================================

$db->where ('cartid', $_SESSION['cartid']);
$results = $db->get ('shopcart');

// prettyPrint($results);

$arr_display_products = [];
$tmpArrID = 0;
foreach ($results as $key => $vArrProdCart) {

    if ($vArrProdCart['quantity'] == 0) {
        removeProdFromCart($vArrProdCart['id']);
        continue;
    }

    $cols = Array ("id", "name", "price", "price2");
    $db->where ('id', $vArrProdCart['prod_id']);
    $tmpArrDetailsProd =  $db->get ($vArrProdCart['cat_id'], null, $cols);
    // prettyPrint($tmpArrDetailsProd);
    $arr_display_products[$tmpArrID]['id'] = $vArrProdCart['id'];
    $arr_display_products[$tmpArrID]['name'] = $tmpArrDetailsProd[0]['name'];


    // check if price2 < price
    if ( !is_null($tmpArrDetailsProd[0]['price2']) and ($tmpArrDetailsProd[0]['price2'] < $tmpArrDetailsProd[0]['price'] ) and $tmpArrDetailsProd[0]['price2'] >0 ) {
        $finalPrice = $tmpArrDetailsProd[0]['price2'];
    }else{
        $finalPrice = $tmpArrDetailsProd[0]['price'];
    }


    $arr_display_products[$tmpArrID]['price'] = $finalPrice * $vArrProdCart['quantity'];
    $arr_display_products[$tmpArrID]['quantity'] = $vArrProdCart['quantity'];

$tmpArrID++;
}

// prettyPrint($arr_display_products);

include_once 'inc.navbar.php';
?>



<div class="container">
    <h1 style="font-size: 60px;" class="text-center">SHOPPING CART</h1><br><br>
    <div class="row">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col" class="text-right">Price</th>
                            <th></th>
                            <th scope="col" class="text-right"><span class="glyphicon glyphicon-trash"></span></th>
                        </tr>
                    </thead>
                    <tbody>


<?php
$tmpTotalPrice = 0;
foreach ($arr_display_products as $key => $vArrDisplay) {
    echo '<tr>
        <td><img style="width: 100px;height: 100px;" src="img/'.$results[$key]['cat_id'].'/'.$results[$key]['prod_id'].'/1.jpg" /> </td>
        <td>'.$vArrDisplay['name'].'</td>
        <td>'.$vArrDisplay['quantity'].'&nbsp;&nbsp;&nbsp;
            <div class="btn-group">
                <a href="'.$fullUrl.'&action=inc&incid='.$vArrDisplay['id'].'" class="btn btn-danger">+</a>
                <a href="'.$fullUrl.'&action=dec&incid='.$vArrDisplay['id'].'" class="btn btn-danger">-</a>
            </div>
        </td>
        <td class="text-right">'.$vArrDisplay['price'].'$</td>
        <td></td>
        <td class="text-right"><a href="'.$fullUrl.'&action=del&delid='.$vArrDisplay['id'].'" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> </a> </td>
    </tr>';
    $tmpTotalPrice += $vArrDisplay['price'];
}

?>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Sub-Total</td>
                            <td class="text-right">
                                <?php echo $tmpTotalPrice; ?> $
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Shipping</td>
                            <td class="text-right">10 $</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong><?php echo $tmpTotalPrice + 10; ?> $</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    <a href="index.php" class="btn btn-block btn-default">Continue Shopping</a>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <a href="#checkModal" data-toggle="modal" class="btn btn-lg btn-block btn-success text-uppercase">Checkout</a>


                </div>
            </div>
        </div>
    </div>


                    <!-- CHECK MODAL -->

                    <div class="modal fade" id="checkModal" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button style="color: white;" type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h2 style="color: white;" class="text-center">Delivery</h2>
                                </div>
                                <div class="modal-body text-center">
                                    <br>

<?php
if ($login) {
    echo "<h3><strong>Your products will arrive soon.</strong></h3>
            <h3><strong>Your cart ID:".$_SESSION['cartid']."</strong></h3>";
    $delDelivery = 1;

} else {
    echo '<h3><strong>Please login to continue!</strong></h3>';
    $delDelivery = 0;
}
?>

                                </div>
                                <div class="moda-footer col-sm-12">
                                    <a href="<?php echo ($delDelivery)? 'index.php?delDelivery=1':'shopcart.php'?>" class="btn btn-primary btn-lg btn-block">Close</a><br>
                                </div>
                            </div>
                        </div>
                    </div>

</div>
<br><br><br>










<?php
include_once 'inc.footer.php';
?>