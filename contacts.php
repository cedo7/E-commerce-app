<?php

include_once 'inc.header.php';
include_once 'inc.navbar.php';

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['comments'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $comments = $_POST['comments'];
  $content = "Name: ".$name."     Email: ".$email."\n Comments: ".$comments."\n\n\n";
  file_put_contents("feedback.txt", $content, FILE_APPEND | LOCK_EX);
}

?>

<div class="container">
  <h2 class="text-center">CONTACT</h2>
  <div class="row">
    <div class="col-sm-5">
      <p>Contact us and we'll get back to you within 24 hours.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span> 1303 Bacon Street, San Francisco, US</p>
      <p><span class="glyphicon glyphicon-phone"></span> +00 2273181516</p>
      <p><span class="glyphicon glyphicon-envelope"></span> optimus@store.com</p>
    </div>
    <form action="contacts.php" method="POST">
        <div class="col-sm-7">
          <div class="row">
            <div class="col-sm-6 form-group">
              <input class="form-control" name="name" placeholder="Name" type="text" required>
            </div>
            <div class="col-sm-6 form-group">
              <input class="form-control" name="email" placeholder="Email" type="email" required>
            </div>
          </div>
          <textarea class="form-control" name="comments" placeholder="Comment" rows="5" required></textarea><br>
          <div class="row">
            <div class="col-sm-12 form-group">
              <button class="btn btn-primary btn-lg pull-right" type="submit">Send</button>
            </div>
          </div>
        </div>
    </form>
  </div>

  <!-- GOOGLE MAP -->
  <div id="map" style="height:400px;width:100%;"></div>
    <script>
      function sfMap() {
        var location = {lat: 37.724321, lng: -122.416308};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: location
        });
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $APIkey;?>&callback=sfMap"></script>
</div>

<?php include_once 'inc.footer.php'; ?>