<style>
  .showbox{margin-top: 150%;visibility:hidden;}
</style>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<body dir="rtl">
  <div class="sticky_bar login_prompt">כבר משתמש רשום? <button class="button" id="enter">היכנס</button></div>

  <div class="popup" style="visibility: hidden;">
      <!-- POPUP -->
    <div class="overlay"></div>
    <div class="container popup_container">
      <i class="fas fa-times fa-2x" style="float: left; color: white;" id="close"></i>
      <iframe style="width: 97%; height: 500px;" src="https://www.mipanooy.com/termsandprivacy" frameborder="0"
      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <!-- POPUP ENDS -->
  </div>

  <main class="container">
    <header class="form_head">
      <h1 class="form_header">משתמש חדש?</h1>
      <h2 class="form_subheader">מלא את הפרטים</h2>
    </header>
    <form method="post">
      <div class="input_group">
        <label class="label" for="fullname">שם מלא</label>
        <input type="text" class="input" name="fullName" id="fullname" placeholder="הקלד שם מלא">
      </div>
      <div class="input_group">
        <label class="label" for="phonenumber">מספר טלפון</label>
        <input type="phone" class="input" name="phone" id="phonenumber" placeholder="הקלד כאן"
          pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}|[0-9]{3}-[0-9]{3}[0-9]{4}|[0-9]{3}[0-9]{3}[0-9]{4}">
      </div>
      <div id="phone-msg" style="color: red; font-weight: bold;">

      </div>
      <div class="input_group">
        <label class="label" for="mail">כתובת אימייל</label>
        <input type="email" class="input" name="email" id="mail" placeholder="הקלד כאן">
      </div>
      <div class="" id="mail-msg" style="color: red; font-weight: bold;">

      </div>
      <div class="input_group">
        <label class="label" for="password">בחר סיסמה</label>
        <input type="password" class="input" name="pass" id="password" placeholder="הקלד כאן">
      </div>
      <div class="input_group">
        <label class="label" for="password2">אימות סיסמה</label>
        <input type="password" class="input" name="confPass" id="password2" placeholder="הקלד כאן">
      </div>
      <div class="" id="pass-msg" style="color: red; font-weight: bold;">

      </div>
      <div class="input_group checkbox_group">
        <label class="label" for="terms">אני מאשר/ת שקראתי והסכמתי <a href="https://www.mipanooy.com/termsandprivacy" id="terms1">לתנאי השימוש</a> </label>
        <input type="checkbox" class="checkbox" id="terms" name="check" value="1"><label for="terms"></label>
      </div>

      <div class="showbox">
        <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
          </svg>
        </div>
      </div>
      <br /><br />

      <!-- <span class="center_prompt">עם השלמת הנתונים ולחיצה על ״אישור״ יישלח אלייך קוד אימות בסמס</span> -->
      <button class="button wide_button" disabled>אישור</button>
    </form>
  </main>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/reslog.js"></script>

  <script>
    $(document).ready(function() {
      $(".wide_button").click(function() {
        $(".showbox").css("visibility", "visible");
      });

      // $("#terms1").click(function() {
      //   $(".popup").css("visibility", "visible");
      // });

      $("#close").click(function() {
        $(".popup").css("visibility", "hidden");
      });

      $("form").change(function() {
        var name  = $("#fullname").val();
        var phone = $("#phonenumber").val();
        var mail  = $("#mail").val();
        var pass  = $('#password').val();
        var conf  = $('#password2').val();
        var check = $(".checkbox").is(":checked");

        if((name) && (name != "") && (pass == conf) && (check) && IsValid(phone) && (mail))
        {
          $.ajax({
             method: "POST",
             url: "<?php echo ROOT_URL; ?>models/checkDetails.php",
             data: { mail: mail, phone: phone }
          }).done(function(msg) {
             var json = JSON.parse(msg);

             if(json.phone == "000" && json.mail == "000")
             {
               $("#phone-msg").html("קיים משתמש בעל טלפון זה");
               $("#mail-msg").html("קיים משתמש בעל מייל זה");
             } else if (json.phone == "000") {
               $("#phone-msg").html("קיים משתמש בעל טלפון זה");
             } else if (json.mail == "000") {
               $("#mail-msg").html("קיים משתמש בעל מייל זה");
             } else {
               $('.wide_button').prop('disabled', false);
               $("#pass-msg").html("");
               $("#phone-msg").html("");
             }
          });
        }
        else if(pass != conf && conf)
        {
          $("#pass-msg").html("הסיסמאות לא תואמות");
          $("#phone-msg").html("");
        }
        else if (phone && !IsValid(phone))
        {
          $("#phone-msg").html("פורמט הטלפון שגוי");
          $("#pass-msg").html("");
        }
        else if(pass != conf && conf && phone && !IsValid(phone))
        {
          $("#phone-msg").html("פורמט הטלפון שגוי");
          $("#pass-msg").html("הסיסמאות לא תואמות");
        } else {
          $('.wide_button').prop('disabled', true);
          $("#pass-msg").html("");
          $("#phone-msg").html("");
        }

      });

      function IsValid(str) {
        var isphone = /^(1\s|1|)?((\(\d{3}\))|\d{3})(\-|\s)?(\d{3})(\-|\s)?(\d{4})$/.test(str);
        return isphone;
      }
    });
  </script>
</body>
