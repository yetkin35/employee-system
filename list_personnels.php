<?php 
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials/assets.php';?>
    <title>Gibson - Evaluator Page</title>
</head>
<?php
  if(isset($_SESSION["permissionEvaluator"]) && $_SESSION["permissionEvaluator"] == false){
    echo "<script>location.href = 'no_permission.php'</script>";
  }

  if(isset($_POST['type']) && $_POST['type'] == "update"){
    $sql = "UPDATE results SET hardworking=".$_POST['hw'].",ontime=".$_POST['ontime'].",reliability=".$_POST['reliability']." WHERE id=".$_POST['id'];
    if ($conn->query($sql) === TRUE) {
              echo "<script>setTimeout(function(){ 
                              swal({
                                type: 'success',
                                title: 'Updated', 
                                text: 'Personnel updated!'
                              });
                            }, 300);
                    </script>";
    } else {
      echo "<script>setTimeout(function(){ 
                      swal({
                        type: 'wrong',
                        title: 'Error', 
                        text: 'Personnel couldnt updated!'
                      });
                    }, 300);
            </script>";
    }
  }else if(isset($_POST['type']) && $_POST['type'] == "delete"){
    $sql = "DELETE FROM results WHERE id=".$_POST['id']." ";
    if ($conn->query($sql) === TRUE) {
      $sql2 = "DELETE FROM personnels WHERE id=".$_POST['id']." ";
              if ($conn->query($sql2) === TRUE) {
                echo "<script>setTimeout(function(){ 
                              swal({
                                type: 'success',
                                title: 'Deleted', 
                                text: 'Personnel deleted!'
                              });
                            }, 300);
                    </script>";
                }else {
                  echo "<script>setTimeout(function(){ 
                                  swal({
                                    type: 'wrong',
                                    title: 'Error', 
                                    text: 'Personnel couldnt deleted!'
                                  });
                                }, 300);
                        </script>";
                }
    } else {
      echo "<script>setTimeout(function(){ 
                      swal({
                        type: 'wrong',
                        title: 'Error', 
                        text: 'Personnel couldnt deleted!'
                      });
                    }, 300);
            </script>";
    }
  }else if(isset($_POST['type']) && $_POST['type'] == "personnelAdd"){
    $sql = "INSERT INTO personnels (name, surname, username, password) VALUES ('".$_POST['personnelName']."', '".$_POST['personnelSurname']."', '".$_POST['personnelUsername']."', '".$_POST['personnelPassword']."')";
    if ($conn->query($sql) === TRUE) {
        $sql2 = "INSERT INTO results (id) SELECT id FROM personnels WHERE username='".$_POST['personnelUsername']."' ";

        if ($conn->query($sql2) === TRUE) {
          $sql3 = "SELECT * FROM evaluators WHERE id=".$_SESSION['idEvaluator']."";
          $result = $conn->query($sql3);
          $row = $result->fetch_assoc();
          $sql4 = "UPDATE personnels SET department = '".$row["department"]."' WHERE username='".$_POST['personnelUsername']."' ";
          if ($conn->query($sql4) === TRUE) {
              echo "<script>setTimeout(function(){ 
                              swal({
                                type: 'success',
                                title: 'Added', 
                                text: 'Personnel added!'
                              });
                            }, 300);
                    </script>";
          }
        }
    }else {
      echo "<script>setTimeout(function(){ 
                      swal({
                        type: 'wrong',
                        title: 'Error', 
                        text: 'Personnel couldnt added!'
                      });
                    }, 300);
            </script>";
    }
  }
?>
<body>  
    <div class="container">
        <section class="col-md-12 content" id="home">
           <div class="col-lg-6 col-md-6 yetoScroll content-item tm-black-translucent-bg tm-logo-box" style="padding-top: 5%;">
              <h2 style="color:#b50909;">Personnels of <?php
                  $sql2 = "SELECT * FROM evaluators WHERE id=".$_SESSION["idEvaluator"]."";
                  $result = $conn->query($sql2);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          $department = $row["department"];
                          echo "".$row["department"]." Department</h1>";
                      }
                  }
                 
                  $sql = "SELECT * FROM personnels WHERE department='".$department."'";
                  $result = $conn->query($sql);
                  $counter = 1;
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        $sql2 = "SELECT * FROM results WHERE id=".$row["id"]." ";
                        $result2 = $conn->query($sql2);

                        if ($result2->num_rows > 0) {
                          $row2 = $result2->fetch_assoc();
                          echo "<div class='innerPersonnel'> 
                          <div class='innerPersonnelText'>".$counter.") ".$row["name"]." ".$row["surname"]."
                          <a href='' data-toggle='modal' data-target='#updateModal' class='updateButton' data-hw='".$row2["hardworking"]."' data-ontime='".$row2["ontime"]."' data-reliability='".$row2["reliability"]."' data-id='".$row["id"]."'><i class='editDiv fa fa-edit'></i></a><a href='' data-toggle='modal' data-target='#deleteModal' class='deleteButton'data-id='".$row["id"]."'><i class='editDiv fa fa-trash'></i></a><br></div>
                          </div>";
                        }
                        $counter++;
                      }
                  }else {
                    echo "<div class='innerResult'>No personnels in system.</div>";
                  }
                ?>
                <a class='addDiv personnelButton' href='' data-toggle='modal' data-target='#personnelModal'>Add Personnel  <i class="fas fa-plus-circle"></i></i></a>
           </div>
           <div class="col-lg-6 col-md-6 content-item content-item-1 background tm-white-translucent-bg">
           
               <h1 class="main-title text-center dark-blue-text" style="font-size: 54px;margin-top: 5px">Welcome, <?php
                  $sql = "SELECT name,surname FROM evaluators WHERE id = ".$_SESSION["idEvaluator"]."";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo "".$row["name"]." ".$row["surname"]."";
                      }
                  }else {
                    echo "Error";
                  }
                ?>.</h1>
                <button type="submit" class="btn btnyeto btn-secondary" style="margin-bottom: 5%;" onclick="exitFunction()">Exit</button>
            </div>       
           </div>
       </section>
    </div>
    <div class="text-center footer">
      <div class="container">
        Copyright 2018 | Design: <a href="http://www.instagram.com/yetkinyurtsever" target="_blank">Yetkin Yurtsever</a>
        </div>
    </div>
    <div id="personnelModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Personnel</h4>
          </div>
          <form action="list_personnels.php" method="POST">
            <div class='modal-body'>
              Name<br>
              <input type='text' name='personnelName' placeholder="Enter name"><br><br>
              Surname<br>
              <input type='text' name='personnelSurname' placeholder="Enter surname"><br><br>
              Username<br>
              <input type='text' name='personnelUsername' placeholder="Enter username"><br><br>
              Password<br>
              <input type='password' name='personnelPassword' placeholder="Enter password"><br><br>
              <input type='hidden' name='type' value='personnelAdd'>
            </div>
            <div class="modal-footer">
            <input class="btn btnyeto btn-default" type="submit" name="submit" value="Submit">
            </div>
          </form>
       </div>
      </div>
    </div>
    <div id="updateModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Evaluate</h4>
          </div>
          <form action="list_personnels.php" method="POST">
            <div class='modal-body'>
              Hardworking<br>
              <input type='text' name='hw' value='' id='updateUserHw'><br>
              On time:<br>
              <input type='text' name='ontime' value='' id='updateUserOntime'><br>
              Reliability:<br>
              <input type='text' name='reliability' value='' id='updateUserReliability'><br>
              <input type="hidden" name="id" value="" id="updateUserId">
              <input type='hidden' name='type' value='update'>
            </div>
            <div class="modal-footer">
            <input class="btn btnyeto btn-default" type="submit" name="submit" value="Submit">
            </div>
          </form>
       </div>
      </div>
    </div>
    <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete</h4>
          </div>
          <form action="list_personnels.php" method="post">
          <div class="modal-body">
          Are you sure ?
          <input type="hidden" name="type" value="delete">
          <input type="hidden" name="id" value="" id="deleteUserId"/>
          </div>
          <div class="modal-footer">
          <input class="btn btn-default" type="submit" name="submit" value="Submit">
          </div>
          </form>
       </div>
      </div>
    </div>
    <script>
      $(".deleteButton").click(function(){
          $("#deleteUserId").val($(this).data('id'));
      });
    </script>
    <script>
      $(".updateButton").click(function(){
        $("#updateUserId").val($(this).data('id'));
        $("#updateUserHw").val($(this).data('hw'));
        $("#updateUserOntime").val($(this).data('ontime'));
        $("#updateUserReliability").val($(this).data('reliability'));
      });
    </script>
</body>

<script>
  function exitFunction() {
      <?php
          $_SESSION["permissionEvaluator"] = false;
          $_SESSION["permissionPersonnel"] = false;
      ?>
      location.href = 'index.php';
  }
  function evaluateFunction() {
      <?php
          $_SESSION["permissionEvaluator"] = true;
      ?>
  }
</script>
</html>