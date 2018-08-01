<?php
session_start();

include_once 'inc.header.php';
include_once 'php/inc.functions.php';



$errors = [];
$success = [];


// LOGOUT
if (isset($_GET['logout'])) {
  unset($_SESSION['user_login']);
}

// DELETE ALL SHOPCART AFTER CHECKOUT
if (isset($_GET['delDelivery'])) {
  $db->where('cartid', $_SESSION['cartid']);
  $db->delete('shopcart');
}


// ===================================
// LOGIN
// ===================================

if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset( $_POST['username']  ) ) {

    if(isset($_POST['username']) && !empty($_POST['username'])){
        $username = input($_POST['username']);
    } else {
       $errors[] = 'Fill username!';
    }

    if(isset($_POST['password']) && !empty($_POST['password'])){
        $password = input($_POST['password']);
    } else {
      $errors[] = 'Fill password!';
    }
    if ( login($username, $password) ) {
      $_SESSION['user_login'] = $username;
      header("Location: index.php");
    } else {
      $errors[] = 'Username and password don\'t match!';
    }
}

// ===================================
// FORGOT PASSWORD
// ===================================

if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset( $_POST['femail']  ) ){

    if ( empty($_POST["femail"]) || !filter_var(input($_POST["femail"]), FILTER_VALIDATE_EMAIL)) {
       $errors[] = 'Email is required!';
    } else {
        $femail = input($_POST["femail"]);
    }
    if(!forgotPassword($femail)){
      $errors[] = 'You don\'t have an account';
    } else {
      $fPassword = forgotPassword($femail);
      sendPassword($femail, $fPassword);
    }
}
// ===================================
// REGISTER
// ===================================

if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rusername']) ){

    if(isset($_POST['rusername']) && !empty($_POST['rusername'])){
        $rusername = input($_POST['rusername']);
    } else {
        $errors[] = 'Fill username!';
    }

    if ( empty($_POST["remail"]) || !filter_var(input($_POST["remail"]), FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is required!';
    } else {
        $remail = input($_POST["remail"]);
    }

    if(isset($_POST['rpassword']) && !empty($_POST['rpassword'])){
        $rpassword = input($_POST['rpassword']);

        if(isset($_POST['rcpassword']) && !empty($_POST['rcpassword'])){
            $rcpassword = input($_POST['rcpassword']);
        } else {
            $errors[] = 'Fill "Confirm password"!';
        }
    } else {
        $errors[] = 'Fill password!';
    }

// REGISTER FUNCTION
    if(register($rusername, $remail, $rpassword)){
      $success[] = 'You have been registered succesfully!';
    } else {
      $errors[] = 'Username or email is taken!';
    }
}


include_once 'inc.navbar.php';

foreach ($arr_product_tables as $key => $vTable) {
  $deals[$vTable] = $db->rawQuery("SELECT * from $vTable WHERE price2 IS NOT NULL  ORDER BY RAND() LIMIT 1");

}
?>



<div class="container">
  <div class="row">

<?php
if ( count($errors) ) {
  $htmlErrors = implode("<BR>", $errors);
  echo '<div class="alert alert-danger alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><span class="glyphicon glyphicon-remove"></span> '.$htmlErrors.'</strong></div> <BR>';
}
if (count($success)) {
  $htmlSuccess = implode("<br>", $success);
  echo '<div class="alert alert-success alert-dismissible fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><span class="glyphicon glyphicon-ok"></span> ' .$htmlSuccess. ' </strong></div><br>';
}


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
                    <h4><strong>Price: </strong><del class="red">' .$vProduct[$key]['price']. '$ </del><span class="red"> ' .$vProduct[$key]['price2']. '$</span></h4>
                    <a href="shopcart.php?cat='.$cat.'&id='.$vProduct[$key]['id'].'" class="btn btn-danger btn-block">Add to cart!</a>
                </div>
            </div>
        </div>';
    }
}

?>

  </div>
</div><br>

<?php include_once 'inc.footer.php'; ?>
