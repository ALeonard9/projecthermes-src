<?php

session_start();
ob_start();

include '../connectToDB.php';

$id = $_GET['id'];
$user_id = $_SESSION['userid'];

if (isset($_SESSION['userid']))
	{

		$stmt = $db->prepare("UPDATE `hermes`.`addresses` SET `active`='0' WHERE `user_id`= :user and `id` = :id");
		$stmt->bindParam(':user', $user_id);
		$stmt->bindParam(':id', $id);
    $stmt->execute();
  	header("Location: address.php");
		exit;
	}
else
	{
	header("location: ../users/signin.php");
	}
?>
