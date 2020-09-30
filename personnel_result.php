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
  if(isset($_SESSION["permissionPersonnel"]) && $_SESSION["permissionPersonnel"] == false){
    echo "<script>location.href = 'no_permission.php'</script>";
  }
?>
<body>
    
    <div class="container">
        <section class="col-md-12 content" id="home">
           <div class="col-lg-6 col-md-6 content-item tm-black-translucent-bg tm-logo-box" style="padding-top: 5%;">
              <h1 style="color: #dddddd;">Results:</h1>
              <?php
                  $sql = "SELECT hardworking, ontime, reliability FROM results WHERE id = ".$_SESSION["idPersonnel"]." ";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        $average = ($row["hardworking"] + $row["ontime"] + $row["reliability"]) / 3;
                        $floatAverage = number_format($average, 2);
                        echo "<div class='innerResult'> Hardworking: ".$row["hardworking"]."/10<br>Comes work on time: ".$row["ontime"]."/10<br>Reliability: ".$row["reliability"]."/10<br><br>Average: ".$floatAverage."/10</div>";

                        if($average < 5 && $average > 0){
                          echo "<div style='color:red;' class='innerResult'>Please reconsider your current performance.</div>";
                        }else if($average == 0){
                          echo "<div style='color:white;' class='innerResult'>You have not evaluated yet.</div>";
                        }else if($average >= 5){
                          echo "<div style='color:green;' class='innerResult'>Thanks for your performance.</div>";
                        }
                      }
                  }else {
                    echo "<div class='innerResult'>No records for this personnel.</div>";
                  }
                ?>
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
                <button type="submit" class="btn btnyeto btn-secondary" onclick="exitFunction()">Exit</button>
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
</script>
</html>