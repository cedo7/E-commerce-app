<?php
session_start();
//get var from session
$user_login = $_SESSION['user_login'];

if (!isset($_SESSION['user_login'])) {
  header("Location: index.php");
}

?>

<?php

include_once 'inc.header.php';
include_once 'inc.navbar.php';

?>







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
</div>

<?php include_once 'inc.footer.php'; ?>

