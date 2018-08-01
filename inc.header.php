<?php

session_start();
$APIkey = 'AIzaSyDkEwnQXjRLLo_pPP35WsuYHOYxuwqZt_I';


function get_visitor_ip() {
    $ip = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ip = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = 'none';

    return $ip;
}

// generate an unique ID for shopcart for this session/user
if ( !isset( $_SESSION['cartid'] ) ) {
  $_SESSION['cartid'] = md5( session_id() . get_visitor_ip() );
}

// echo $_SESSION['cartid'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Online store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


  <script type="text/javascript">

    // CHECK IF PASSWORDS MATCH AT REGISTER
    function checkPass(){
      var p1 = document.getElementById('pass1');
      var p2 = document.getElementById('pass2');
      var message = document.getElementById('message');
      var bad = "#ff6666";

      if(p1.value != p2.value){
        message.style.color = bad;
        message.innerHTML = "Passwords don't match!";
      } else {
        message.innerHTML = null;
      }
    }

    // CAROUSEL PROD.PHP
    $(document).ready(function() {
      //Set the carousel options
      $('#quote-carousel').carousel({
        pauseOnHover: true,
        interval: 2500,
      });
    });
  </script>


</head>
<body>

<div class="jumbotron">
  <div class="container text-center">
    <h1>Optimus online store</h1>
    <p>All your PC needs</p>
  </div>
</div>






