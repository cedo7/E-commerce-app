<?php

include_once 'php/inc.functions.php';
include_once 'inc.header.php';
include_once 'inc.navbar.php';


// check what is the current category
if (isset($_GET['cat']) && isset($_GET['id']) ) {
    $curCat = $_GET['cat'];
    $curID = $_GET['id'];
    // generate the shopcart query
    $shopcart_ahref = "shopcart.php?cat=$curCat&id=$curID";
}else{
    exit();
}


$prodDetails = $db->rawQueryOne("SELECT * FROM $curCat where id = $curID");

if (count($prodDetails)) {
    // print_r( $prodDetails );
    $title = $prodDetails['name'];
    if ( !is_null($prodDetails['price2']) && $prodDetails['price2'] < $prodDetails['price'] && $prodDetails > 0) {

        $price = $prodDetails['price2'];
    } else {
        $price = $prodDetails['price'];
    }

}else{
    echo "NO PRODUCT";
}



// TAKE THE NR OF PHOTOS
$path = 'img/'.$curCat.'/'.$curID;
$imgs = scandir($path);
$imgCount = count($imgs)-2;
// echo $imgCount;

?>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
        <h1><?php echo $title; ?></h1>
    </div>
    <div class='col-sm-6'>
      <div class="carousel slide" data-ride="carousel" id="quote-carousel">

    <!-- Bottom Carousel Indicators -->
        <ol class="carousel-indicators">

<?php

for ($i=0; $i < $imgCount; $i++) {
    if ($i == 0) {
        $active = 'active';
    } else {
        $active = '';
    }
    echo '<li data-target="#quote-carousel" data-slide-to="'.$i.'" class="'.$active.'"></li>';
}

?>

        </ol>

    <!-- Carousel Slides / Quotes -->
        <div class="carousel-inner">

          <!-- Quotes -->

<?php

for ($j=1; $j <= $imgCount; $j++) {
    if ($j == 1) {
        $active = 'active';
    } else {
        $active = '';
    }
    echo '<div class="item '.$active.'">
            <blockquote>
              <div class="row">
                <div class="col-md-3 text-center">
                <center>
                  <img src="img/'.$curCat.'/'.$curID.'/'.$j.'.jpg">
                </center>
                </div>

              </div>
            </blockquote>
          </div>';
}

?>

        </div>
      </div>
    </div>

    <div class="col-sm-6">
        <h3><strong>Technical specifications:</strong></h3>
        <ul class="list-group">

<!-- FILTERS FROM PROD.PHP -->
<?php

foreach (${'arr_product_keys_'.$curCat} as $key => $vCol) {
    if ($vCol == 'name' || $vCol == 'price') {
        continue;
    }else{
        echo  '<li class="list-group-item"><strong>'.ucfirst($vCol) .': </strong>' . $prodDetails[$vCol];
    }
}

?>

        </ul>
        <form class="text-center">
            <h3><strong>Price: </strong> <?php echo $price; ?>$</h3><br>
            <div class="form-group">
                <a  class="btn btn-primary btn-lg" href="<?php echo $shopcart_ahref; ?>">Add to cart!</a>
            </div>
        </form>
    </div>

  </div><br><br><br><br><br><br><br><br>

<?php

for ($i=1; $i <= $imgCount; $i++) {
    echo '<img class="img-responsive" src="img/'.$curCat.'/'.$curID.'/'.$i.'.jpg">';
}

?>

</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


<?php include_once 'inc.footer.php'; ?>