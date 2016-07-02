<?php
session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Posters ASAP</title>
        <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
<link href='../composer/vendor/kartik-v/bootstrap-fileinput/css/fileinput.min.css' media='all' rel='stylesheet' type='text/css' />
<script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
<!-- canvas-to-blob.min.js is only needed if you wish to resize images before upload.
     This must be loaded before fileinput.min.js -->
<script src='../composer/vendor/kartik-v/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js' type='text/javascript'></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
     This must be loaded before fileinput.min.js -->
<script src='../composer/vendor/kartik-v/bootstrap-fileinput/js/plugins/sortable.min.js' type='text/javascript'></script>
<!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
     This must be loaded before fileinput.min.js -->
<script src='../composer/vendor/kartik-v/bootstrap-fileinput/js/plugins/purify.min.js' type='text/javascript'></script>
<!-- the main fileinput plugin file -->
<script src='../composer/vendor/kartik-v/bootstrap-fileinput/js/fileinput.min.js'></script>
<!-- bootstrap.js below is needed if you wish to zoom and view file content
     in a larger detailed modal dialog -->
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js' type='text/javascript'></script>
";
include('../header.php');
echo "</head><body>";
include('../navigation.php');
$product = $_GET['p'];
$user_id = $_SESSION['userid'];
$stmt = $db->prepare("SELECT * FROM hermes.products WHERE `product_type` = :p");
$stmt->bindParam(':p', $product);
$stmt->execute();
$count = $stmt->rowCount();
$rows = $stmt->fetchAll();
if ( !$rows){
  die("An has occured. The product selected does not exist.");
}
else {
echo "
<div class='container text-center'><div class='col-md-3'></div><div class='col-md-6'>
<h1><u>".ucfirst($product)."</u></h1>
<form class='form-signin' action='addtocart.php' id='myForm2' method='POST'>
<div class='form-group text-left'>
  <label for='quantity'>Quantity</label>
  <input type='number' class='form-control' name='quantity' value='1'>
</div>
<div class='form-group text-left'>
  <label for='size'>Size</label>
  <select class='form-control' id='size'>";
  foreach($rows as $row) {
    echo "<option>".$row['size']."</option>";
  }

echo "</select>
</div>
<input id='input-id' type='file' class='file'
  data-resize-image='true'
  data-max-file-count='1'
  data-preview-file-type='text'>
</br>
<button class='btn btn-lg btn-inverse btn-block' name='update' type='submit'><span class='glyphicon glyphicon-plus'></span> Add to Cart</button>
<button class='btn btn-lg btn-warning btn-block' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>
</div></div></div>";
}
?>
</div></body>
<script>
 $("#input-id").fileinput({
   uploadUrl: "upload.php",
   uploadAsync: false,
   minFileCount: 1,
   maxFileCount: 1,
   showUpload: true,
   showRemove: true
 })
</script>
</html>
<?php
include('../footer.php');
?>
