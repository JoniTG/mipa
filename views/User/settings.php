<style>
a {color: white; text-decoration: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<script type="text/javascript">

</script>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <h1 class="page_subject">מי פנוי?</h1>
    <button class="menu_glyph menu_open"></button>
  </div>

  <div class="popup" style="visibility: hidden;">
      <!-- POPUP -->
    <div class="overlay"></div>
    <div class="container popup_container">
      <i class="fas fa-times fa-2x" style="float: left; color: white;" id="close"></i>
      <iframe id="frame" style="width: 97%; height: 500px;" src="https://www.mipanooy.com/takanonmipanooy" frameborder="0"
      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <!-- POPUP ENDS -->
  </div>

  <div class="sticky_bar toolbar_prompt toolbar_expanded">
    <h1 class="page_subject">תפריט</h1>
    <button class="menu_glyph exit_menu"></button>
    <nav class="navbar">
      <ul>
        <a href="<?php echo ROOT_URL; ?>user/"><li>קבל נסיעה</li></a>
        <a href="<?php echo ROOT_URL; ?>rides/GiveRide"><li>מסור נסיעה</li></a>
        <a href="<?php echo ROOT_URL; ?>rides/MyRides"><li>הנסיעות שלי</li></a>
        <a href="<?php echo ROOT_URL; ?>user/sum"><li>סיכום נסיעות</li></a>
        <a href="<?php echo ROOT_URL; ?>user/settings"><li>הגדרות</li></a>
      </ul>
    </nav>
  </div>

  <main class="container">
    <header class="section_head">
      <h1 class="form_header">הגדרות</h1>
    </header>

    <div class="block setting_block" id="profile">
      <div class="ride_attr">
        <div class="ride_camera_glyph"></div>
        <span class="ride_attr_caption">פרופיל אישי</span>
      </div>
    </div>

    <div class="block setting_block" id="update">
      <div class="ride_attr">
        <div class="ride_camera_glyph"></div>
        <span class="ride_attr_caption">עדכנו תמונות מונית ורישיון נהיגה</span>
      </div>
    </div>

    <div class="block setting_block" id="terms">
      <div class="ride_attr">
        <div class="ride_card_glyph"></div>
        <span class="ride_attr_caption">תקנון קהילת מי פנוי?</span>
      </div>
    </div>

    <div class="block setting_block" id="usage">
      <div class="ride_attr">
        <div class="ride_card_glyph"></div>
        <span class="ride_attr_caption">תנאי שימוש ומדיניות פרטיות</span>
      </div>
    </div>

    <div class="block setting_block" id="cancel">
      <div class="ride_attr">
        <div class="ride_cancel_glyph"></div>
        <span class="ride_attr_caption">בטל את החשבון שלי</span>
      </div>
    </div>

    <div class="block setting_block">
      <div class="ride_attr">
        <div class="ride_contact_glyph"></div>
        <span class="ride_attr_caption" id="set_contact">צור קשר</span>
      </div>
    </div>
  </main>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/main.js"></script>
  <script>
    $(document).ready(function() {

      var mailme = function() {
          console.log('Caught!');
      }

      $("iframe").on('load', function(e) {
          // console.log('FOO!');

          if(e.message !== undefined)
          {
            window.location.assign("https://www.mipanooy.com/takanonmipanooy");
          }
      });

      $(".menu_open").click(function() {
        $(".toolbar_expanded").css("visibility", "visible");
      });

      $("#profile").click(function() {
        window.location.assign("<?php echo ROOT_URL; ?>user/profile/");
      });

      $("#cancel").click(function() {
        window.location.assign("<?php echo ROOT_URL; ?>user/cancel/");
      });

      $("#update").click(function() {
        window.location.assign("<?php echo ROOT_URL; ?>user/UpdatePic/");
      });

      $("#terms").click(function() {
        window.location.assign("https://www.mipanooy.com/takanonmipanooy");
        // $(".popup").css("visibility", "visible");
      });

      $("#usage").click(function() {
        window.location.assign("https://www.mipanooy.com/termsandprivacy");
      });

      $("#close").click(function() {
        $(".popup").css("visibility", "hidden");
      });
    });
  </script>
</body>
