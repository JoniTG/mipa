<style>
a {color: white; text-decoration: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <h1 class="page_subject">מי פנוי?</h1>
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
      <h1 class="form_header">ביטול חשבון</h1>
    </header>

    <p>
      לביטול החשבון באפליקציה מי פנוי? עלייך לשלוח דואר אלקטרוני (אימייל) למנהלי הקהילה,
      הכולל בקשה ברורה לביטול החשבון. לאחר שנשלח הדוא"ל כאמור לעיל, ביטול החשבון יבוצע בתוך כעשרים ימי עבודה
      וכל הנתונים והמידע המקושר לחשבונך - יימחק. שימו לב - לא ניתן לשחזר חשבון שנמחק!
    </p>

    <p>
      בקשת ביטול יש לשלוח לאימייל <br />
      contact@mipanooy.com או דרך יצירת קשר באפליקציה
    </p>
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
