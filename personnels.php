<?php 
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials/assets.php';?>
    <title>Gibson - Personnel Page</title>
</head>
<?php
  echo "".$_SESSION["permissionPersonnel"]."";
  if(isset($_SESSION["permissionPersonnel"]) && $_SESSION["permissionPersonnel"] == false){
    echo "<script>location.href = 'no_permission.php'</script>";
  }
?>
<body>
    
    <div class="container">
        <section class="col-md-12 content" id="home">
           <div class="col-lg-6 col-md-6 content-item tm-black-translucent-bg tm-logo-box">
              <img src="images/gibson.png" style="width: 20vw;height: 10vw;">
           </div>
           <div class="col-lg-6 col-md-6 content-item content-item-1 background tm-white-translucent-bg">
           
               <h1 class="main-title text-center dark-blue-text" style="font-size: 54px;margin-top: 5px">Welcome, <?php
                  $sql = "SELECT name,surname FROM personnels WHERE id = ".$_SESSION["idPersonnel"]."";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo "".$row["name"]." ".$row["surname"]."";
                      }
                  }else {
                    echo "Error";
                  }
                ?>.</h1>
                <button type="submit" class="btn btnyeto btn-secondary" style="margin-bottom: 5%" onclick="resultFunction()">My Results</button>
                <button type="submit" class="btn btnyeto btn-secondary" style="margin-bottom: 5%" onclick="exitFunction()">Exit</button>
            </div>       
           </div>
       </section>
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
        $_SESSION["permissionEvaluator"] = false;
        $_SESSION["permissionPersonnel"] = false;
    ?>
    location.href = 'index.php';
}
function resultFunction() {
  <?php
        $_SESSION["permissionPersonnel"] = true;
    ?>
    location.href = 'personnel_result.php';
}
</script>
</html>