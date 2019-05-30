$(document).ready(function() {
  $(".splash").delay(3000).fadeOut("slow");

  setTimeout(function(){
    $("body").css("background-color", "white");
    window.location.assign("./user/register");
  }, 3500 );
});
