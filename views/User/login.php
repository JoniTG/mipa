<style>
  .showbox{margin-top: 70%;visibility:hidden;}
  .showbox1{margin-top: 10%;visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar login_prompt">אין לך עוד משתמש? <button class="button" id="register">הירשם</button></div>
  <main class="container">
    <header class="form_head">
      <h1 class="form_header">משתמש רשום?</h1>
      <h2 class="form_subheader">מלא את הפרטים</h2>
    </header>
    <form method="post">
      <div class="input_group">
        <label class="label" for="phone">טלפון</label>
        <input type="text" class="input" id="phone" name="phone" placeholder="הקלד מספר טלפון">
      </div>
      <div class="input_group">
        <label class="label" for="password">סיסמה</label>
        <input type="password" class="input" id="password" name="pass" placeholder="הקלד כאן">
      </div>
      <br />

      <button class="button wide_button">התחבר</button>

      <div class="showbox1">
        <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
          </svg>
        </div>
      </div>

      <div class="showbox">
        <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
          </svg>
        </div>
      </div>
    </form>
  </main>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/reslog.js"></script>
  <script>
    $(document).ready(function() {
      var error = "<?php echo $viewmodel; ?>";
      if(error == "000")
        alert("שם משתמש או סיסמה שגויים");

      $("#register").click(function() {
        $(".showbox1").css("visibility", "visible");
        window.location.assign("<?php echo ROOT_URL; ?>user/register");
      });

      $("#wide_button").click(function() {
        $(".showbox").css("visibility", "visible");
      });
    });
  </script>
</body>
