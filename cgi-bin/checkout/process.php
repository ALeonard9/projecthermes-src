<?php
session_start();
ob_start();
require_once('./config.php');
include '../connectToDB.php';

$token  = $_POST['stripeToken'];
$email  = $_POST['stripeEmail'];
$amount  = $_POST['amount'];
// $random = uniqid();
$random1 = uniqid();
$dollars = number_format($amount/100, 2, '.', ' ');
// $phone = '';
// $city = '';
// $cc = '';
// $line1 = '';
// $line2 = '';
// $zip = '';
//
//
// if (isset($_SESSION['stripe_id'])){
//   $stripe_id = $_SESSION['stripe_id'];
// } else {
//   try {
//     $customer = \Stripe\Customer::create(array(
//       'email' => $email,
//       'card'  => $token
//       // 'currency' => 'usd',
//       // 'tax_percent' => '6.75',
//       // 'phone' => $phone,
//       // 'shipping' => array('address' => array(
//       //              'city' => $city,
//       //              'country' => $cc,
//       //              'line1' => $line1,
//       //              'line2' => $line2,
//       //              'postal_code' => $zip)
//       //    )
//   ), array(
// "idempotency_key" => $random
// ));
// } catch(\Stripe\Error\Card $e) {
//   // Since it's a decline, \Stripe\Error\Card will be caught
//   $body = $e->getJsonBody();
//   $err  = $body['error'];
//
//   print('Status is:' . $e->getHttpStatus() . "\n");
//   print('Type is:' . $err['type'] . "\n");
//   print('Code is:' . $err['code'] . "\n");
//   // param is '' in this case
//   print('Param is:' . $err['param'] . "\n");
//   print('Message is:' . $err['message'] . "\n");
// } catch (\Stripe\Error\RateLimit $e) {
//   die('Too many requests made to the API too quickly');
// } catch (\Stripe\Error\InvalidRequest $e) {
//   die("Invalid parameters were supplied to Stripe's API");
// } catch (\Stripe\Error\Authentication $e) {
//   die("Authentication with Stripe's API failed");
// } catch (\Stripe\Error\ApiConnection $e) {
//   die("Network communication with Stripe failed");
// } catch (\Stripe\Error\Base $e) {
//   die $e;
// } catch (Exception $e) {
//   die $e;
// }
//   $stripe_id = $customer->id;
//   $stmt = $db->prepare("INSERT INTO hermes.users(`stripe_id`, `email`) VALUES (:stripe_id, :email)");
//   $stmt->bindParam(':stripe_id', $stripe_id);
//   $stmt->bindParam(':email', $email);
//   $stmt->execute();
//   $user_id =  $db->lastInsertId();
// }

// Create the charge on Stripe's servers - this will charge the user's card
try {
  $charge = \Stripe\Charge::create(array(
    "amount" => $amount,
    "currency" => "usd",
    "source" => $token,
    "description" => "Example charge",
    "receipt_email" => $email,
    "metadata" => array("order_id" => "6735")
    ), array(
  "idempotency_key" => $random1
));
} catch(\Stripe\Error\Card $e) {
  // Since it's a decline, \Stripe\Error\Card will be caught
  $body = $e->getJsonBody();
  $err  = $body['error'];

  print('Status is:' . $e->getHttpStatus() . "\n");
  print('Type is:' . $err['type'] . "\n");
  print('Code is:' . $err['code'] . "\n");
  // param is '' in this case
  print('Param is:' . $err['param'] . "\n");
  print('Message is:' . $err['message'] . "\n");
} catch (\Stripe\Error\RateLimit $e) {
  die('Too many requests made to the API too quickly');
} catch (\Stripe\Error\InvalidRequest $e) {
  die("Invalid parameters were supplied to Stripe's API");
} catch (\Stripe\Error\Authentication $e) {
  die("Authentication with Stripe's API failed");
} catch (\Stripe\Error\ApiConnection $e) {
  die("Network communication with Stripe failed");
} catch (\Stripe\Error\Base $e) {
  die($e);
} catch (Exception $e) {
  die($e);
}
  echo '<h1>Successfully charged $'.$dollars.'</h1>';
?>
