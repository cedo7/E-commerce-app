<?php
include_once 'php/inc.functions.php';
include_once 'inc.header.php';
include_once 'inc.navbar.php';


// CHECK IF A CATEGORY WAS SELECTED
$html_category=0; // used to display the products

if (isset($_GET['cat'])) {
    $curCat = $_GET['cat'];
    $html_category=1;
    $arrAllProductsInOneCateg = getAllProductsFromOneCategory($curCat);
    // prettyPrint($arrAllProductsInOneCateg);
}




// CHECK IF A PRODUCT WAS SELECTED
$html_product=0; // used to display the products

if (isset($_GET['cat']) && isset($_GET['prodid']) ) {
    $curCat = $_GET['cat'];
    $curProdID = $_GET['prodid'];
    $arrOneProductInOneCateg = getOneProductFromOneCategory($curCat, $curProdID);
    // prettyPrint($arrAllProductsInOneCateg);
    if ($arrOneProductInOneCateg) {
        $html_product=1;

    }
}

$success = '';

// CHECK IF NEWPRICE IS SET
if (isset($_POST['cat']) && isset($_POST['newprice']) ) {
    $curCat = $_POST['cat'];
    $curProdID = $_POST['prodid'];
    $newPrice = $_POST['newprice'];
    $oldPrice = $_POST['oldprice'];
    $discount = 100 - 100*$newPrice/$oldPrice; //calculate discount %
    $discount = number_format((float)$discount, 2, '.', '');

    if (updatePrice($curCat, $curProdID, $newPrice, $discount)) {
        $success = '<div class="alert alert-success alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><span class="glyphicon glyphicon-ok"></span> Price updated!</strong></div><br>';
    }
}


?>


<div class="container">
    <?php echo $success;?>
    <h1 class="text-center "><strong>Administration</strong></h1><br><br>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">
                <a href="#product" data-toggle="collapse" data-parent="#accordion"><h2>Add discount!</h2></a>
            </div>
        </div>
        <div id="product" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="col-sm-offset-2 col-sm-8 text-center">
                <h3 for="productsList">Categories:</h3>
                <select class="form-control" id="productsList" onchange="location = this.value;">
                    <option></option>
                    <option class="active" value="admin_deals.php?cat=cases">Cases</option>
                    <option value="admin_deals.php?cat=videoCards">Video cards</option>
                    <option value="admin_deals.php?cat=hdd">Hard drives</option>
                    <option value="admin_deals.php?cat=motherboards">Motherboards</option>
                    <option value="admin_deals.php?cat=processors">Processors</option>
                    <option value="admin_deals.php?cat=sources">Sources</option>
                    <option value="admin_deals.php?cat=ssd">SSD</option>
                    <option value="admin_deals.php?cat=RAM">RAM memory</option>
                    <option value="admin_deals.php?cat=coolers">Coolers</option>
                </select>
                <hr>
                <h2 style="color: #31708f;
                           background-color: #d9edf7;
                           border-color: #bce8f1;
                           padding: 10px 15px;
                           border-radius: 6px;">Category: <?php echo ucfirst($curCat);?></h2>
                <hr>
            </div>
            <div class="row col-sm-offset-2 col-sm-8">
                <table class="table table-striped">
<?php

// ALL ELEMENTS IN ONE CATEGORY
if ($html_category) {

?>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-right">Stock</th>
                            <th class="text-right"><span class="glyphicon glyphicon-edit"></span></th>
                        </tr>
                    </thead>
                    <tbody>

<?php

    foreach ($arrAllProductsInOneCateg as $key => $vProd) {
        echo '<tr>
                <td>' .$vProd['name']. '</td>
                <td class="text-center">' .$vProd['price']. '</td>
                <td class="text-right">' .$vProd['stock']. '</td>
                <td class="text-right"><a href="'.$currentPath.'?cat='.$curCat.'&prodid='.$vProd['id'].'">Change Price</a></td>
              </tr>';
    }
}


?>

                    </tbody>
                </table><br><br>

<?php
// CHANGE PRICE
if ($html_product) {

?>

        <hr>
            <h2 style="color: #31708f;
                       background-color: #d9edf7;
                       border-color: #bce8f1;
                       padding: 10px 15px;
                       border-radius: 6px;" class="text-center">Edit price!</h2>
        <hr>
<form action="<?php echo $currentPath;?>" method="post">
    <h4><strong>Product: </strong> <?php echo $arrOneProductInOneCateg['name'];?></h4>
    <h4><strong>Old price: </strong> <?php echo $arrOneProductInOneCateg['price'];?>$</h4>
    <h4><strong>New price:</strong></h4>
    <input class="form-control" type="text" name="newprice" placeholder="new price">
    <input type="hidden" name="cat" value="<?php echo $curCat?>">
    <input type="hidden" name="prodid" value="<?php echo $curProdID?>">
    <input type="hidden" name="oldprice" value="<?php echo $arrOneProductInOneCateg['price']?>"><br>
    <button class="btn btn-primary btn-lg btn-block" type="submit" name="Submit">Change</button><br>
</form>

<?php
}
?>

            </div>


        </div>
        </div>
    </div>
</div>


<?php include_once 'inc.footer.php';?>
