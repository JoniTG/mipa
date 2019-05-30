<?php
$month = $viewmodel['month'];
$all   = $viewmodel['all'];
?>

<style>
a {color: white; text-decoration: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <h1 class="page_subject">סיכום הנסיעות שלי</h1>
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
    <header class="section_head">
          נתוני ההכנסות והנסיעות המוצגים מהווים סיכום טכני בלבד של
תיעוד המערכת. אין בנתונים אלה הצהרה או התחייבות כלשהי
לפעילות ו/או תשלומים ו/או הכנסות כלשהן.
    </header>

    <div class="block ride_block wide_block">
      <div class="ride_attr" align="center">
        <h3>סה"כ נסיעות החודש</h3>
        <?php echo $month['num']; ?>
      </div>
      <!-- /.ride_attr -->

      <div class="ride_attr" align="center">
        <h3>סה"כ הכנסות החודש</h3>
        <?php echo $month['money']; ?> ש"ח
      </div>
      <!-- /.ride_attr -->

      <br /><hr />

      <div class="ride_attr" align="center">
        <h3>סה"כ נסיעות במצטבר</h3>
        <?php echo $all['num']; ?>
      </div>
      <!-- /.ride_attr -->

      <div class="ride_attr" align="center">
        <h3>סה"כ הכנסות במצטבר</h3>
        <?php echo $all['money']; ?> ש"ח
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
