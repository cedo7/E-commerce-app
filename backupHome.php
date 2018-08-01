<?php
session_start();
//get var from session
$user_login = $_SESSION['user_login'];

if (!isset($_SESSION['user_login'])) {
  header("Location: index.php");
}

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

</head>
<body>

<div class="jumbotron">
  <div class="container text-center">
    <h1>Optimus online store</h1>
    <p>All your PC needs</p>
  </div>
</div>

<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="240">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li class="dropdown">

        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Processors</a></li>
          <li><a href="#">Video cards</a></li>
          <li><a href="#">Motherboards</a></li>
          <li><a href="#">RAM Memory</a></li>
          <li><a href="#">SSD</a></li>
          <li><a href="#">Hard drives</a></li>
          <li><a href="#">Sources</a></li>
          <li><a href="#">Cases</a></li>
          <li><a href="#">Coolers</a></li>
        </ul>

        </li>
        <li><a href="#">Deals</a></li>
        <li><a href="#">Contact</a></li>
        <form action="NavBarServlet" method="post" class="navbar-form navbar-left">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="searchField">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit" name="searchDrugs">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
          </div>
        </form>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#">Hello,</a></li> -->

<?php

if (isset($_SESSION['user_login'])) {
  echo '<li><a href="#loginModal" data-toggle="modal">Welcome '. $_SESSION['user_login'] .'</a></li>';
}else{
  echo '<li><a href="#loginModal" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
}
?>


<?php

if (condition) {
  # code...

?>


<span>bla bla </span>


<?php
}

?>



        <!-- SHOPPING CART DROPDOWN -->

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
            <span class="glyphicon glyphicon-shopping-cart"></span> Cart
            <sup class="badge">3</sup>
          </a>
          <ul class="dropdown-menu dropdown-cart" role="menu">
            <form action="NavBarServlet" method="post">
              <li>
                <div class="item">
                  <div class="item-left">
                    <img class="img-cart" src="https://placehold.it/50x50?text=IMAGE" alt="" />
                    <div class="item-info">
                      <span>Item name</span>
                      <span><small class="form-text text-muted">Quantity: </small>1x</span>
                      <span><small class="form-text text-muted">Price: </small>23$</span>
                    </div>
                  </div>
                  <div class="item-right">
                    <button type="button" class="close" data-dismiss="item" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </li>

              <li>
                <div class="item">
                  <div class="item-left">
                    <img class="img-cart" src="https://placehold.it/50x50?text=IMAGE" alt="" />
                    <div class="item-info">
                      <span>Item name</span>
                      <span><small class="form-text text-muted">Quantity: </small>1x</span>
                      <span><small class="form-text text-muted">Price: </small>23$</span>
                    </div>
                  </div>
                  <div class="item-right">
                    <button type="button" class="close" data-dismiss="item" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </li>

              <li>
                <div class="item">
                  <div class="item-left">
                    <img class="img-cart" src="https://placehold.it/50x50?text=IMAGE" alt="" />
                    <div class="item-info">
                      <span>Item name</span>
                      <span><small class="form-text text-muted">Quantity: </small>1x</span>
                      <span><small class="form-text text-muted">Price: </small>23$</span>
                    </div>
                  </div>
                  <div class="item-right">
                    <button type="button" class="close" data-dismiss="item" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </li>
              <li class="divider"></li>
              <li class="text-center" style="letter-spacing: 0 !important;">
                <p><strong>Total</strong>: $0.00</p>
              </li>
              <li class="text-center">
                <button class="btn btn-primary btn-block" type="submit" name="cartButton">Cart</button>
              </li>
            </form>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>

<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>


<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">Title</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">
          <p>Description</p>
          <div class="text-center">
            <button class="btn btn-primary">Buy now!</button>
            <button class="btn btn-default">Add to cart!</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br><br>

<footer class="container-fluid text-center">
  <p>Online Store</p>
  <form class="form-inline">Get deals:
    <input type="email" class="form-control" size="50" placeholder="Email Address">
    <button type="button" class="btn btn-danger">Sign Up</button>
  </form>
</footer>

</body>
</html>
