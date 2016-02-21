<?php require_once('./config.php'); ?>

<form action="./process.php" method="post">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-amount="2000" //in cents
          data-name="PostersASAP"
          data-description="1 Poster ($20.00)"
          data-image="../apple-icon-120x120.png"
          data-locale="auto">
  </script>
  <input type="hidden" name="amount" value="2000" />
</form>
