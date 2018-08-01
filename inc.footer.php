<?php
if (isset($_POST['emailDeals'])) {
    $emailDeals = $_POST['emailDeals'];
    $headers = "From: optimus@store.com\n";
    $subject = "New Deals";
    $message = "Hello from Optimus online store. We have new deals for you and your PC that you must see. Visit us www.optimusstore.com";
    mail($emailDeals,$subject,$message,$headers);
}

?>

<br><br>
<footer class="container-fluid text-center">
  <h2 style="color:#9d9d9d;">Optimus Online Store</h2><br>
  <form action="inc.footer.php" method="post" class="form-inline">
    <label style="color:#9d9d9d;"><h4>Get deals:</h4></label>
    <input type="email" class="form-control" size="50" name="emailDeals" placeholder="Email Address">
    <button type="submit" class="btn btn-danger">Sign Up</button>
  </form><br><br>
</footer>

</body>
</html>
