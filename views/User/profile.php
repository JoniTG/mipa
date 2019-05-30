<style>
a {color: white; text-decoration: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <h1 class="page_subject">פרופיל אישי</h1>
    <button class="menu_glyph menu_open"></button>
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
    <header class="section_head" align="center">
      <h3><?php echo $viewmodel[0]['fullName']; ?></h3>
    </header>

    <div class="block ride_block wide_block">
      <div class="ride_attr">
        <h4>
          <i class="fas fa-phone fa-lg"></i> טלפון:
          <small><?php echo $viewmodel[0]['phone']; ?></small>
        </h4>
      </div>
      <!-- /.ride_attr -->

      <div class="ride_attr">
        <h4>
          <i class="fas fa-envelope fa-lg"></i> אימייל:
          <small><?php echo $viewmodel[0]['email']; ?></small>
        </h4>
      </div>
      <!-- /.ride_attr -->

      <div class="ride_attr">
        <span style="width: 50%;">
          <h4>
            <i class="far fa-id-badge fa-lg"></i> רישיון:<br />
            <img src="<?php echo $viewmodel[0]['licence']; ?>" style="width: 100%;" />
          </h4>

        </span>

        <span>
          <h4>
            <i class="fas fa-car fa-lg"></i> רכב:<br />
            <img src="<?php echo $viewmodel[0]['car']; ?>" style="width: 100%;" />
          </h4>
        </span>
      </div>
      <!-- /.ride_attr -->

      <div class="ride_attr" align="center">

      </div>
      <!-- /.ride_attr -->

    </div>
    <!-- /.block.ride_block -->


  </main>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/main.js"></script>
  <script>
    $(document).ready(function() {
      $(".menu_open").click(function() {
        $(".toolbar_expanded").css("visibility", "visible");
      });
    });
  </script>
</body>
