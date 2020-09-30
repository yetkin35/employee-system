<?php 
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials/assets.php';?>
    <title>Gibson - Personnel Page</title>
</head>
<body>
    
    <div class="container">
        <section class="col-md-12 content" id="home">
           <div class="col-lg-12 col-md-12 content-item tm-black-translucent-bg tm-logo-box">
              <img src="images/gibson.png" style="width: 20vw;height: 10vw;">
              <h2 style="margin: 3%">No Permission to this page.</h1>
              <button type="submit" class="btn btn-secondary" style="margin-top:5%;margin:auto;" onclick="exitFunction()">Click here to return Home Page</button>
           </div>
       </section>     
       </div>

    </div>
    <div class="text-center footer">
    	<div class="container">
    		Copyright 2018 | Design: <a href="http://www.instagram.com/yetkinyurtsever" target="_blank">Yetkin Yurtsever</a>
        </div>
    </div>
</body>

<script>
function exitFunction() {
    <?php
        $_SESSION["permissionPersonnel"] = false;
    ?>
    location.href = 'index.php';
}
</script>
</html>