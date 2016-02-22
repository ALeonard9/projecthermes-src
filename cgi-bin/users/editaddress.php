<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Posters ASAP</title>";
include('../header.php');
echo "</head><body>";
include('../navigation.php');
$id = $_GET['id'];

if (isset($_SESSION['userid']) && isset($_GET['id'])) {
  $user_id = $_SESSION['userid'];
  echo "<div class='container text-center'><div class='col-md-3'></div><div class='col-md-6'>
  <h1>Edit Address</h1>";
  $user_id = $_SESSION['userid'];
  $stmt = $db->prepare("SELECT * FROM hermes.addresses WHERE `id` = :id and `user_id` = :user_id");
  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $rows = $stmt->fetch();
  if ( !$rows){
    die("An has occured. The address selected does not exist or does not belong to the user.");
  }
  else {
    echo "<form class='form-signin' action='editaddress.php?id=".$id."' id='myForm2' method='POST'>
    <div class='form-group text-left'>
      <label for='full_name'>Full Name</label>
      <input type='text' class='form-control' name='full_name' value='".$rows['full_name']."'>
    </div>
    <div class='form-group text-left'>
      <label for='line1'>Line 1</label>
      <input type='text' class='form-control' name='line1' value='".$rows['line1']."'>
    </div>
    <div class='form-group text-left'>
      <label for='line2'>Line2</label>
      <input type='text' class='form-control' name='line2' value='".$rows['line2']."'>
    </div>
    <div class='form-group text-left'>
      <label for='city'>City</label>
      <input type='text' class='form-control' name='city' value='".$rows['city']."'>
    </div>
    <div class='form-group text-left'>
      <label for='state'>State</label>
      <input type='text' class='form-control' name='state' value='".$rows['state']."'>
    </div>
    <div class='form-group text-left'>
      <label for='zip'>Postal Code/ Zip Code</label>
      <input type='text' class='form-control' name='zip' value='".$rows['zip']."'>
    </div>
    <div class='form-group text-left'>
      <label for='cc'>Country (Currently only delivering within the US)</label>
      <input type='text' class='form-control' name='cc' value='US' readonly>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' name='update' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Submit</button>
    <button class='btn btn-lg btn-warning btn-block' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>
  </div>";
  }
    include('../footer.php');
    echo "</div></body></html>";
    $full_name='';
    if (isset($_POST['full_name'])){
       $full_name=$_POST['full_name'];
    }
    $line1='';
    if (isset($_POST['line1'])){
       $line1=$_POST['line1'];
    }
    $line2='';
    if (isset($_POST['line2'])){
       $line2=$_POST['line2'];
    }
    $city='';
    if (isset($_POST['city'])){
       $city=$_POST['city'];
    }
    $state='';
    if (isset($_POST['state'])){
       $state=$_POST['state'];
    }
    $zip='';
    if (isset($_POST['zip'])){
       $zip=$_POST['zip'];
    }

    if (isset($_POST['line1'])){
      try{
      $stmt = $db->prepare("UPDATE hermes.addresses SET `full_name` = :full_name, `line1` = :lineA, `line2` = :lineB, `city` = :city, `state` = :state, `zip` = :zip WHERE `id` = :id");
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':full_name', $full_name);
      $stmt->bindParam(':lineA', $line1);
      $stmt->bindParam(':lineB', $line2);
      $stmt->bindParam(':city', $city);
      $stmt->bindParam(':state', $state);
      $stmt->bindParam(':zip', $zip);
      $stmt->execute();
      }
      catch(PDOException $e)
      {
       print "An error occurred.";
       exit;
      }
      header("Location: address.php");
      exit;
    }

}

else {
    header("location: ../users/signin.php");
}
?>
