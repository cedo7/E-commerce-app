<?php
include_once 'inc.header.php';
include_once 'inc.navbar.php';
include_once 'php/inc.functions.php';

$curCat = '';
if (isset($_GET['cat'])) {
    $curCat = $_GET['cat'];
    $lastID = $db->rawquery("SELECT MAX(id) from $curCat");
    $lastID = $lastID[0]['MAX(id)'];
    $newID = $lastID + 1;
}


// ====================================
// UPLOAD PHOTO
// ====================================
if (isset($_POST['submit'])) {

// 10485760 5mb
    $target_dir = "img/uploads/";
    $fileName = $_FILES['fileToUpload']['name'];
    $fileError = $_FILES['fileToUpload']['error'];
    $fileSize = $_FILES['fileToUpload']['size'];
    $fileNameTmp = $_FILES['fileToUpload']['tmp_name'];
    $fileType = explode('.', $fileName);
    $fileType = strtolower(end($fileType));


    $allowed = array('jpg');

    if(in_array($fileType, $allowed)){
        if ($fileError === 0) {
            if ($fileSize < 10485760) {

                if (!file_exists('img/'.$curCat.'/'.$newID)) {
                    mkdir('img/'.$curCat.'/'.$newID, 0775, true);
                }
                $fileNameNew = "1.". $fileType;
                $fileDestination = 'img/'.$curCat.'/'.$newID.'/'. $fileNameNew;
                move_uploaded_file($fileNameTmp, $fileDestination);
                echo 'succes';
            } else {
                echo 'Failed to upload';
            }
        } else {
            echo 'Failed to upload';
        }
    } else {
        echo 'Failed to upload';
    }

}





$data = [];
$success = [];
$errors = [];

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

    foreach (${'arrProduct_keys_'.$curCat} as $key => $vData) {

        if(isset($_POST[$vData]) && !empty($_POST[$vData])){
            $data[$vData] = input($_POST[$vData]);
        }
    }
    // print_r($data);
    $query  = $db->insert($curCat, $data);
    if($query){
        $success[] = 'Product inserted successfully';
    } else {
        $errors[] = 'Product failed to insert';
    }

}


?>

<div class="container">

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

?>

    <h1 class="text-center "><strong>Administration</strong></h1><br><br>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div class="panel-title text-center">
        <a data-toggle="collapse" data-parent="#accordion" href="#product"><h2>Add product!</h2></a>
      </div>
    </div>
    <div id="product" class="panel-collapse collapse in">
      <div class="panel-body">
        <div class="col-sm-offset-2 col-sm-8 form-group text-center">
            <label for="productsList"><h4>Select product: </h4></label>
            <select class="form-control" id="productsList" onchange="location = this.value;">
                <option></option>
                <option class="active" value="adminProduct.php?cat=cases">Cases</option>
                <option value="adminProduct.php?cat=videoCards">Video cards</option>
                <option value="adminProduct.php?cat=hdd">Hard drives</option>
                <option value="adminProduct.php?cat=motherboards">Motherboards</option>
                <option value="adminProduct.php?cat=processors">Processors</option>
                <option value="adminProduct.php?cat=sources">Sources</option>
                <option value="adminProduct.php?cat=ssd">SSD</option>
                <option value="adminProduct.php?cat=RAM">RAM memory</option>
                <option value="adminProduct.php?cat=coolers">Coolers</option>
            </select>
            <hr>
            <h2 style="color: #31708f;
                       background-color: #d9edf7;
                       border-color: #bce8f1;
                       padding: 10px 15px;
                       border-radius: 6px;">Category: <?php echo ucfirst($curCat);?></h2>
            <hr>
        </div>
        <form action="adminProduct.php?cat=<?php echo $curCat;?>" method="POST" enctype="multipart/form-data">
            <div class="row">

<?php
foreach (${'arrProduct_keys_'.$curCat} as $key => $vLabel) {
    $tmpLabel = $vLabel;
    if (isset( ${'arr_filter_'.$curCat}  )) {
        if (  array_key_exists($vLabel, ${'arr_filter_'.$curCat}) ) {
            $tmpLabel = ${'arr_filter_'.$curCat}[$vLabel];
        }
    }
    echo '<div class="col-sm-offset-2 col-sm-8 form-group">
            <label><h3>'.ucfirst($tmpLabel).': </h3></label>
            <input type="text" class="form-control" name="'.$vLabel.'" required>
        </div>';
}

?>
                <div class="col-sm-offset-2 col-sm-8">
                    <h3>Upload an image:</h3>
                    <p class="text-muted">Image can't be bigger than 5MB and must be .jpg</p>
                    <input type="file" name="fileToUpload">
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Add product!</button><br>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div><br><br><br>
</div>


</body>
</html>

