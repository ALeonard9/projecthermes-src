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

include('../footer.php');
echo "</div></body></html>";

 ?>
