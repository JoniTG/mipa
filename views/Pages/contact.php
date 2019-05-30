<style>
a {color: white; text-decoration: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <button class="menu_glyph menu_open"></button>
    <button class="button small_button" id="giveRide">מסור נסיעה</button>
  </div>

  <div class="sticky_bar toolbar_prompt toolbar_expanded">
    <h1 class="page_subject">תפריט</h1>
    <button class="menu_glyph exit_menu"></button>
    <nav class="navbar">
      <ul>
        <a href="<?php echo ROOT_URL; ?>user/"><li>קבל נסיעה</li></a>
        <a href="<?php echo ROOT_URL; ?>rides/GiveRide"><li>מסור נסיעה</li></a>
        <a href="<?php echo ROOT_URL; ?>rides/MyRides"><li>הנסיעות שלי</li></a>
        <a href="<?php echo ROOT_URL; ?>user/stars"><li>דרג נהגים</li></a>
        <a href="<?php echo ROOT_URL; ?>user/settings"><li>הגדרות</li></a>
      </ul>
    </nav>
  </div>

  <main class="container">
    <header class="section_head">
      <h1 class="form_header">צור קשר</h1>
      <h2 class="form_subheader">נשמח לשמוע על השירות שלנו</h2>
    </header>

    <form>
      <div class="input_group">
        <label class="label" for="name">שם</label>
        <input type="text" class="input" id="name" placeholder="הקלד כאן">
      </div>
      <div class="input_group">
        <label class="label" for="phone">טלפון</label>
        <input type="text" class="input" id="phone" placeholder="הקלד כאן">
      </div>
      <div class="input_group">
        <label class="label" for="subject">נושא הפנייה</label>
        <input type="text" class="input" id="subject" placeholder="הקלד כאן">
      </div>
      <div class="input_group">
        <label class="label" for="body">פרט את תוכן הפנייה</label>
        <textarea class="input" id="body" placeholder="הקלד כאן"></textarea>
      </div>
      <button class="button wide_button space_above_button">שלח</button>
    </form>
  </main>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/main.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".menu_open").click(function() {
        $(".toolbar_expanded").css("visibility", "visible");
      });
    });
  </script>
</body>
