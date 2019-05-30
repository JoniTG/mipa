<?php
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

if(mysqli_connect_errno())
  die();
?>

<style>
a {color: white; text-decoration: none;}
.star_glyph{outline: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <button class="menu_glyph menu_open"></button>
    <button class="button small_button" id="giveRide">מסור נסיעה</button>
  </div>

  <div class="popup" style="display: none;">
    <div class="rideID-popup" style="display: none;"></div>
      <!-- POPUP -->
    <div class="overlay"></div>
    <div class="container popup_container">
      <div class="block popup">
        <span class="popup_header">דרג נסיעה בלחיצה</span>
        <div class="rating_group_container">
          <button class="star_glyph" id="one"></button>
          <button class="star_glyph" id="tow"></button>
          <button class="star_glyph" id="three"></button>
          <button class="star_glyph" id="four"></button>
          <button class="star_glyph" id="five"></button>
        </div>
        <span class="rating_count">0/5</span>
        <button class="button finishRate" disabled>סיים</button>
      </div>
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
      <h1 class="form_header">כל הנסיעות</h1>
    </header>

    <?php
    if($viewmodel != false)
    {
      foreach ($viewmodel as $item):
        $user = mysqli_query($con, "SELECT * FROM `users` WHERE `fullName` = '".$item['owner']."'");
        $user = mysqli_fetch_array($user);
    ?>
      <div class="block ride_block">
        <?php if($item['owner'] == $_SESSION['fullName']): ?>
            <div class="block_subject_header block_sh_orange">
                    <span>נסיעה שמסרתי</span>
            </div>
        <?php else: ?>
            <div class="block_subject_header block_sh_purple">
              <span>נסיעה שנבחרתי לבצע</span>
            </div>
        <?php endif; ?>
        <span class="label">פרטי הנסיעה</span>
        <div class="ride_attr">
          <div class="ride_taxi_glyph"></div>
          <span class="ride_attr_caption">
            <?php echo $item['exit']; ?> <div class="ride_attr_arrow"></div> <?php echo $item['target']; ?>
          </span>
        </div> <!-- /.ride_attr -->

        <div class="ride_attr">
          <div class="ride_clock_glyph"></div>
          <span class="ride_attr_caption"><?php echo $item['date']; ?></span>
        </div> <!-- /.ride_attr -->

        <div class="ride_attr">
          <div class="ride_passanger_glyph"></div>
          <span class="ride_attr_caption"><?php echo $item['passengers']; ?> נוסעים</span>
        </div> <!-- /.ride_attr -->

        <div class="ride_attr">
          <div class="ride_cost_glyph"></div>
          <span class="ride_attr_caption"><?php echo $item['price']; ?> ש״ח</span>
        </div> <!-- /.ride_attr -->

        <?php
        if($item['owner'] == $_SESSION['fullName'] && $item['driverID'] != 0):
            $driver = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$item['driverID']."'");
            $driver = mysqli_fetch_array($driver);
        ?>
            <span class="label">צור קשר עם הנהג הנבחר</span>
            <span>
              <a href="whatsapp://<?php echo '972'.substr($driver['phone'], 1); ?>">
                <img src="<?php echo ROOT_URL; ?>assets/images/whatsapp.png" width="45" height="45"
                 style="position: relative; left: -7%; margin-bottom: -5%;"/></a>
            </span>
            <div class="ride_attr attr_phone">
              <div class="ride_phone_glyph"></div>
              <span class="ride_attr_caption"><a href="tel: <?php echo $driver['phone']; ?>"><?php echo $driver['phone']; ?></a>
                <span class="gray_caption"><a href="tel: <?php echo $driver['phone']; ?>"><?php echo $driver['fullName']; ?></a></span>
              </span>
            </div> <!-- /.ride_attr -->
        <?php elseif($item['owner'] != $_SESSION['fullName']): ?>
            <span class="label">צור קשר עם מוסר הנסיעה</span>
            <span><a href="whatsapp://972<?php echo substr($user['phone'], 1);  ?>">
              <img src="<?php echo ROOT_URL; ?>assets/images/whatsapp.png" width="45" height="45"
              style="position: relative; left: -7%; margin-bottom: -5%;" /></a>
            </span>

            <div class="ride_attr attr_phone">
              <div class="ride_phone_glyph"></div>
              <span class="ride_attr_caption"><a href="tel: <?php echo $user['phone']; ?>"><?php echo $user['phone']; ?></a>
                <span class="gray_caption"><a href="tel: <?php echo $user['phone']; ?>"><?php echo $item['owner']; ?></a></span>

              </span>
            </div> <!-- /.ride_attr -->
        <?php endif; ?>

        <?php if($item['owner'] == $_SESSION['fullName'] && $item['driverID'] == 0): ?>
            <button class="button wide_button driver" value="<?php echo $item['ID']; ?>">בחר נהג</button>
        <?php
        endif;

        if($item['owner'] == $_SESSION['fullName'] && $item['driverID'] != 0):
        ?>
            <div class="ride_attr">
              <div class="ride_star_glyph"></div>
              <span class="ride_attr_caption"><button class="button small_button rate" id="<?php echo $item['driverID'] ?>">
                דרג נהג <span class="rideID" id="<?php echo $item['ID']; ?>" style="display: none;"></span></button></span>
            </div> <!-- /.ride_attr -->
        <?php endif; ?>

        <?php if($item['comments'] != ""): ?>
            <div class="ride_details" id="<?php echo $item['ID']; ?>-comments">
              <div class="ride_chevron_glyph"></div>
              <button class="text_button ride_details_caption">פרטים נוספים</button>
              <p class="ride_details_text">
                <?php echo $item['comments']; ?>
              </p>
            </div>
        <?php endif; ?>
      </div> <!-- /.block.ride_block -->

      <script>
        $(document).ready(function() {
          $("#<?php echo $item['ID']; ?>-comments").click(function(e) {
            e.preventDefault();
            $("#<?php echo $item['ID']; ?>-comments .ride_details_text").slideToggle( "slow" );
            return false;
          })
        });
      </script>
      </div> <!-- /.block.ride_block -->
    <?php
      endforeach;
    }
    ?>

  </main>
  <script>
    $(document).ready(function() {
      $(".driver").click(function() {
        window.location.assign("<?php echo ROOT_URL; ?>rides/ChooseDriver/" + $(this).val());
      });

      $(".rate").click(function() {
         var id   = $(this).attr('id');
         var ride = $(".rideID", this).attr('id');

         $(".popup").attr('id', id);
         $(".rideID-popup").attr('id', ride);
         $(".popup").fadeIn("slow");
      });

      $(".star_glyph").click(function() {
        $("#one").attr('class', 'star_glyph');
        $("#tow").attr('class', 'star_glyph');
        $("#three").attr('class', 'star_glyph');
        $("#four").attr('class', 'star_glyph');
        $("#five").attr('class', 'star_glyph');

        var star = $(this).attr('id');
        $(".finishRate").prop('disabled', false);

        switch (star) {
          case "one":
            $(this).addClass('yellow_star');
            $(".rating_count").html("1/5");

            $(".finishRate").attr('id', '1');
            break;
          case "tow":
            $("#one").addClass('yellow_star');
            $(this).addClass('yellow_star');
            $(".rating_count").html("2/5");

            $(".finishRate").attr('id', '2');
            break;
          case "three":
            $("#one").addClass('yellow_star');
            $("#tow").addClass('yellow_star');
            $(this).addClass('yellow_star');
            $(".rating_count").html("3/5");

            $(".finishRate").attr('id', '3');
            break;
          case "four":
            $("#one").addClass('yellow_star');
            $("#tow").addClass('yellow_star');
            $("#three").addClass('yellow_star');
            $(this).addClass('yellow_star');
            $(".rating_count").html("4/5");

            $(".finishRate").attr('id', '4');
            break;
          case "five":
            $("#one").addClass('yellow_star');
            $("#tow").addClass('yellow_star');
            $("#three").addClass('yellow_star');
            $("#four").addClass('yellow_star');
            $(this).addClass('yellow_star');
            $(".rating_count").html("5/5");

            $(".finishRate").attr('id', '5');
            break;
          default:
            $("#one").attr('class', 'star_glyph');
            $("#tow").attr('class', 'star_glyph');
            $("#three").attr('class', 'star_glyph');
            $("#four").attr('class', 'star_glyph');
            $("#five").attr('class', 'star_glyph');
            $(".rating_count").html("0/5");

            $(".finishRate").attr('id', '0');
            break;
        }
      });

      $(".finishRate").click(function() {
        var rate = $(this).attr('id');
        var ride = $(".rideID-popup").attr('id');

        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/rate.php",
           data: { driverID: $('.popup').attr('id'), rate: rate, ride: ride }
        }).done(function(msg) {
           window.location.assign("<?php echo ROOT_URL; ?>rides/MyRides/");
        });
      });
    });
  </script>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/main.js"></script>

  <script>
    $(document).ready(function() {
      $("#giveRide").click(function() {
        window.location.assign("<?php echo ROOT_URL; ?>rides/GiveRide/");
      });

      $(".menu_open").click(function() {
        $(".toolbar_expanded").css("visibility", "visible");
      });
    });
  </script>
</body>
