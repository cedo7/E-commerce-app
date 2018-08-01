<?php
include_once 'php/inc.functions.php';

$homeActive = 0;
$productsActive = 0;
$dealsActive = 0;
$contactsActive = 0;


if( strcmp($_SERVER['PHP_SELF'], '/Licenta/index.php') == 0){
   $homeActive = 1;

} elseif (strcmp($_SERVER['PHP_SELF'], '/Licenta/cat.php') == 0 || strcmp($_SERVER['PHP_SELF'], '/Licenta/prod.php') == 0) {
    $productsActive = 1;

} elseif (strcmp($_SERVER['PHP_SELF'], '/Licenta/deals.php') == 0) {
    $dealsActive = 1;

} elseif (strcmp($_SERVER['PHP_SELF'], '/Licenta/contacts.php') == 0) {
    $contactsActive = 1;
}


// ===================================
// GET ALL ENTRIES FROM SHOPPING CART
// ===================================

$db->where ('cartid', $_SESSION['cartid']);
$resultsNav = $db->get ('shopcart');
$countItems = count($resultsNav);

// prettyPrint($results);

$arr_display_productsNav = [];
$tmpArrIDNav = 0;
foreach ($resultsNav as $key => $vArrProdCartNav) {

    if ($vArrProdCartNav['quantity'] == 0) {
        removeProdFromCart($vArrProdCartNav['id']);
        continue;
    }

    $colsNav = Array ("id", "name", "price", "price2");
    $db->where ('id', $vArrProdCartNav['prod_id']);
    $tmpArrDetailsProdNav =  $db->get ($vArrProdCartNav['cat_id'], null, $colsNav);
    // prettyPrint($tmpArrDetailsProd);
    $arr_display_productsNav[$tmpArrIDNav]['id'] = $vArrProdCartNav['id'];
    $arr_display_productsNav[$tmpArrIDNav]['name'] = $tmpArrDetailsProdNav[0]['name'];

    // check if price2 < price
    if ( !is_null($tmpArrDetailsProdNav[0]['price2']) and ($tmpArrDetailsProdNav[0]['price2'] < $tmpArrDetailsProdNav[0]['price'] ) and $tmpArrDetailsProdNav[0]['price2'] >0 ) {
        $finalPriceNav = $tmpArrDetailsProdNav[0]['price2'];
    }else{
        $finalPriceNav = $tmpArrDetailsProdNav[0]['price'];
    }


    $arr_display_productsNav[$tmpArrIDNav]['price'] = $finalPriceNav * $vArrProdCartNav['quantity'];
    $arr_display_productsNav[$tmpArrIDNav]['quantity'] = $vArrProdCartNav['quantity'];

$tmpArrIDNav++;
}


?>


<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="290">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Optimus</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="<?php echo ($homeActive)? 'active':''?>"><a href="index.php">Home</a></li>
        <li class="dropdown <?php echo ($productsActive)? 'active':''?>">

        <a href="#" class="dropdown-toggle " data-toggle="dropdown">Products <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="cat.php?cat=processors">Processors</a></li>
          <li><a href="cat.php?cat=videoCards">Video cards</a></li>
          <li><a href="cat.php?cat=motherboards">Motherboards</a></li>
          <li><a href="cat.php?cat=RAM">RAM Memory</a></li>
          <li><a href="cat.php?cat=ssd">SSD</a></li>
          <li><a href="cat.php?cat=hdd">Hard drives</a></li>
          <li><a href="cat.php?cat=sources">Sources</a></li>
          <li><a href="cat.php?cat=cases">Cases</a></li>
          <li><a href="cat.php?cat=coolers">Coolers</a></li>
        </ul>

        </li>
        <li class="<?php echo ($dealsActive)? 'active':''?>"><a href="deals.php">Deals</a></li>
        <li class="<?php echo ($contactsActive)? 'active':''?>"><a href="contacts.php">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">

<?php

if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 'admin') {
  echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome '. $_SESSION['user_login'] .'</a>
          <ul class="dropdown-menu">
            <li><a href="index.php?logout=1">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">ADMIN <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="adminProduct.php"> Add product</a></li>
            <li><a href="admin_deals.php"> Add discount</a></li>
          </ul>
        </li>';


} else if (isset($_SESSION['user_login'])) {
  echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome '. $_SESSION['user_login'] .'</a>
          <ul class="dropdown-menu">
            <li><a href="index.php?logout=1">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
          </ul>
        </li>';

?>

<!-- USER LOGGED LOGIN = OK -->

        <!-- SHOPPING CART DROPDOWN -->

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
            <span class="glyphicon glyphicon-shopping-cart"></span> Cart
            <sup style="background-color: #343a40;" class="badge"><?php echo $countItems;?></sup>
          </a>
          <ul class="dropdown-menu dropdown-cart" role="menu">
            <form action="" method="post">

<?php
$totalPriceNav = 0;
foreach ($arr_display_productsNav as $key => $vArrNav) {
  echo '<li>
                <div class="item">
                  <div class="item-left">
                    <img class="img-cart" style="width:70px; height:70px;" src="img/'.$resultsNav[$key]['cat_id'].'/'.$resultsNav[$key]['prod_id'].'/1.jpg" alt="Image" />
                    <div class="item-info">
                      <span class="text-muted">'.$vArrNav['name'].'</span>
                      <span class="text-muted"><small class="form-text text-muted">Quantity: </small>'.$vArrNav['quantity'].'x</span>
                      <span class="text-muted"><small class="form-text text-muted">Price: </small>'.$vArrNav['price'].'$</span>
                    </div>
                  </div>
                </div>
              </li>';
  $totalPriceNav += $vArrNav['price'];
}



?>


              <li class="divider"></li>
              <li class="text-center" style="letter-spacing: 0 !important;">
                <p class="text-muted"><strong>Total: </strong><?php echo $totalPriceNav;?> $</p>
              </li>
              <li class="col-sm-12 text-center">
                <a href="shopcart.php" class="btn btn-primary btn-block" type="submit" name="cartButton">View cart</a>
              </li>
            </form>
          </ul>
        </li>

<?php

}else{

?>

<!-- USER NOT LOGGED (code for login and register buttons) -->

        <li><a href="#loginModal" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

        <li><a href="#registerModal" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> Register</a></li>

        <!-- loginModal -->

        <div class="modal fade" id="loginModal" role="dialog" tabindex="-1">
          <div class="modal-dialog">

            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><span class="glyphicon glyphicon-log-in"></span> Login</h2>
              </div>
              <div class="modal-body">
                <form action="index.php" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-log-in"></span> Login</button>
                  <button data-target="#forgotModal" data-toggle="modal" data-dismiss="modal" id="forgotPassword" class="btn btn-link"><h4>Forgot password?</h4></button>
                </form>
              </div>
            </div>

          </div>
        </div>

        <!-- forgotPassword -->

        <div class="modal fade" id="forgotModal" role="dialog" tabindex="-1">
          <div class="modal-dialog">

            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><span class="glyphicon glyphicon-lock"></span> Forgot password</h2>
              </div>
              <div class="modal-body">
                <form action="index.php" method="POST">
                  <div class="form-group">
                    <input type="email" class="form-control" name="femail" placeholder="Email" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-lock"></span> Send</button>
                </form>
              </div>
            </div>

          </div>
        </div>

        <!-- registerModal -->

        <div class="modal fade" id="registerModal" role="dialog">
          <div class="modal-dialog">

            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center"><span class="glyphicon glyphicon-user"></span> Register</h2>
              </div>
              <div class="modal-body">
                <form action="index.php" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control" name="rusername" placeholder="Username" required>
                    <input type="email" class="form-control" name="remail" placeholder="Email" required>
                    <input type="password" class="form-control" id="pass1" name="rpassword" placeholder="Password" required>
                    <input type="password" class="form-control" id="pass2" name="rcpassword" onkeyup="checkPass();" placeholder="Confirm password" required>
                    <span id="message"></span>
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-user"></span> Register</button>
                </form>
              </div>
            </div>

          </div>
        </div>

<?php

} // CLOSING ELSE FROM NOT LOGGED

?>

      </ul>
    </div>
  </div>
</nav>

