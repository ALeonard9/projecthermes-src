<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>PostersASAP</title>";
include('../header.php');
echo "</head><body>";
include('../navigation.php');

if (isset($_SESSION['userid'])) {
  echo "<div class='container text-center'><div class='col-md-3'></div><div class='col-md-6'>
  <h1>Manage Your Addresses</h1></br><h2><u>Current Addresses</u></h2>";
  $user_id = $_SESSION['userid'];
  $stmt = $db->prepare("SELECT * FROM hermes.addresses WHERE `active` = 1 and `user_id` = :user_id");
  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();
  $rows = $stmt->fetchAll();
  if ( !$rows){
    echo "<i>No current addresses.</i>";
  }
  else {
    echo "<ul class='list-group text-left'>";
    foreach ($rows as $item) {
      echo "<li id='".$item['id']."' class='list-group-item'>".$item['full_name'].", ".$item['line1'].", ".$item['city'].", ".$item['state']." ".$item['zip']."  <a href='removeaddress.php?id=".$item['id']."''><span title='Remove Address' class='glyphicon glyphicon-remove' style='float:right'></span></a><a href='editaddress.php?id=".$item['id']."'><span title='Edit Address' class='glyphicon glyphicon-pencil' style='float:right'></span></a></li>";

    }
    echo "</ul>";
  }
    echo "</br><h2><u>Add Address</u></h2>
    <form class='form-signin' action='address.php' id='myForm2' method='POST'>
    <div class='form-group text-left'>
      <label for='full_name'>Full Name</label>
      <input type='text' class='form-control' name='full_name' value='".$_SESSION['username']."'>
    </div>
    <div class='form-group text-left'>
      <label for='line1'>Line 1</label>
      <input type='text' class='form-control' name='line1'>
    </div>
    <div class='form-group text-left'>
      <label for='line2'>Line2</label>
      <input type='text' class='form-control' name='line2'>
    </div>
    <div class='form-group text-left'>
      <label for='city'>City</label>
      <input type='text' class='form-control' name='city'>
    </div>
    <div class='form-group text-left'>
      <label for='state'>State</label>
      <input type='text' class='form-control' name='state'>
    </div>
    <div class='form-group text-left'>
      <label for='zip'>Postal Code/ Zip Code</label>
      <input type='text' class='form-control' name='zip'>
    </div>
    <div class='form-group text-left'>
      <label for='cc'>Country (Currently only delivering within the US)</label>
      <input type='text' class='form-control' name='cc' value='US' readonly>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' name='update' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Add</button></div>";
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
      $stmt = $db->prepare("INSERT INTO hermes.addresses (`full_name`, `line1`, `line2`, `city`, `state`, `zip`, `user_id`) VALUES (:full_name, :line1, :line2, :city, :state, :zip, :user_id)");
      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':full_name', $full_name);
      $stmt->bindParam(':line1', $line1);
      $stmt->bindParam(':line2', $line2);
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
