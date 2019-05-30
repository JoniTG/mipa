<style>
a {color: white; text-decoration: none;}
.showbox{margin-top: 250%; visibility:hidden;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <button class="menu_glyph menu_open"></button>
    <!--<button class="button small_button">מסור נסיעה</button>-->
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
      <h1 class="form_header">מסור נסיעה</h1>
      <h2 class="form_subheader">אנא מלא את פרטי הנסיעה</h2>
    </header>

    <form method="post" id="ride-form">
      <div class="input_group">
        <label class="label" for="area">איזור יציאת הנסיעה <span class="label_note">(צפון,מרכז,דרום)</span></label>
        <div class="select_container wide_select">
          <select class="select" id="area" name="area">
            <option value="1">צפון הארץ</option>
            <option value="2">מרכז הארץ</option>
            <option value="3">דרום הארץ</option>
          </select>
        </div>
      </div>

      <div class="input_group">
        <label class="label" for="origin">מוצא</label>
        <input type="text" class="input" id="origin" name="exit" placeholder="הקלד כאן">
      </div>

      <div class="input_group">
        <label class="label" for="destination">יעד הנסיעה</label>
        <input type="text" class="input" id="destination" name="target" placeholder="הקלד כאן">
      </div>

      <div class="input_group">
        <label class="label" for="dateandtime">תאריך ושעה</label>
        <input type="text" class="input" id="dateandtime" name="date" placeholder="לדוגמא: מחר, 10.01, שעה 16:30">
      </div>

      <div class="input_group">
        <label class="label" for="passangers">מספר נוסעים</label>
        <div class="select_container wide_select">
          <select class="select" id="passangers" name="passengers">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
      </div>

      <div class="input_group">
        <label class="label" for="price">מחיר הנסיעה</label>
        <input type="number" class="input" id="price" name="price" placeholder="הקלד סכום">
      </div>

      <div class="input_group">
        <label class="label" for="notes">הערות <span class="label_note">(מספר נוסעים, מזוודות,  דרישות ותנאים מיוחדים)</span></label>
        <textarea class="input" id="notes" name="comments" placeholder="הקלד כאן"></textarea>
      </div>

      <div class="showbox">
        <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
          </svg>
        </div>
      </div>

      <button class="button wide_button space_above_button">שלח לאישור</button>
    </form>
  </main>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/main.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $(".wide_button").click(function() {
        $(".showbox").css("visibility", "visible");
        $(".wide_button").attr('disabled', true);

        var price = parseInt($("#price").val(), 10);
        if(price < 120)
        {
          alert("מחיר הנסיעה חייב להיות מעל 120 שקלים");
        } else {
          $("#ride-form").submit();
        }
      });

      $("#price").keyup(function() {
        var price = parseInt($(this).val(), 10);
        if(price >= 120)
        {
          $(".wide_button").attr('disabled', false);
        }
      });

      $(".menu_open").click(function() {
        $(".toolbar_expanded").css("visibility", "visible");
      });
    });
  </script>
</body>
