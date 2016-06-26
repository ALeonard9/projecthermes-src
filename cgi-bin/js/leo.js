windowsize = $(window).width();
if (windowsize > 767) {
    $(".navbar-header").css("margin-left","calc(50% - 90px)");
}
if (windowsize < 300) {
    $(".navbar-brand").removeAttr("style")
}

var windowsize = $(window).width();

$(window).resize(function() {
  windowsize = $(window).width();
  if (windowsize > 767) {
      $(".navbar-header").css("margin-left","calc(50% - 90px)");
  }
  else {
    $(".navbar-header").removeAttr("style")
  }
  if (windowsize < 300) {
      $(".navbar-brand").removeAttr("style")
  }
  else {
    $(".navbar-brand").css("margin-left","calc(50% - 90px)");
  }
});

$( document ).ready(function() {
  $(".navbar-brand").css("display","inline");
  $("#product1").fadeIn(1000);
  $("#product2").fadeIn(1500);
  $("#product3").fadeIn(2000);
});
