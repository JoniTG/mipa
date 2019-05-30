$(document).ready(function() {
  $(".ride_details_text").hide();

  // # Menu #
  $(".toolbar_expanded").hide();

  $(".menu_open").click(function() {
    $(".toolbar_expanded").fadeIn();
  });

  $(".exit_menu").click(function() {
    $(".toolbar_expanded").fadeOut();
  });

  // # Buttons #
  $("#giveRide").click(function() {
    window.location.assign("../rides/GiveRide/");
  });

  $("#set_contact").click(function() {
    window.location.assign("../pages/contact");
  });
});
