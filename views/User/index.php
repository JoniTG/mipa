<?php
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

if(mysqli_connect_errno())
  die();

$user = mysqli_query($con, "SELECT `ID` FROM `users` WHERE `phone` = '".$_SESSION['phone']."' AND `pass` = '".$_SESSION['pass']."'");
$user = mysqli_fetch_array($user);

$messages = mysqli_query($con, "SELECT * FROM `messages` WHERE `driverID` = '".$user['ID']."' AND `read` = 0");
$msgRows  = mysqli_num_rows($messages);
?>

<style>
a {color: white; text-decoration: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">

  <div class="popup" style="display: none;">
    <!-- POPUP -->
      <div class="overlay"></div>
      <div class="container popup_container">
        <div class="block popup">
          <div class="taxi_wait_glyph"></div>
          <span class="popup_caption">הצעת את עצמך לביצוע הנסיעה, אנא המתן בבקשה שמוסר הנסיעה יבחר בנהג המבצע.</span>
          <button class="button wide_button close">המשך</button>
          <button class="button wide_button inverted_button cancel">בטל נסיעה</button>
        </div>
      </div>
      <!-- POPUP ENDS -->
  </div>

  <div class="sticky_bar toolbar_prompt">
    <button class="menu_glyph menu_open"></button>
    <a href="<?php echo ROOT_URL; ?>user" class="refresh" style="position: relative; right: 30%;">
      <i class="fas fa-sync-alt"></i></a>
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
        <a href="<?php echo ROOT_URL; ?>user/sum"><li>סיכום נסיעות</li></a>
        <a href="<?php echo ROOT_URL; ?>user/settings"><li>הגדרות</li></a>
      </ul>
    </nav>
  </div>

  <main class="container">

    <header class="section_head">
      <h1 class="form_header">נסיעות פתוחות</h1>
      <h2 class="form_subheader">הצע/י את עצמך לאחת הנסיעות. מוסר הנסיעה או המערכת יבחרו מי יבצע אותה</h2>

      <?php if($viewmodel[1] != NULL): ?>
        <div class="block ride_block area-2">
          <div class="ride_attr">
            <b>הודעת מנהל: <?php echo $viewmodel[1][0]['subject']; ?></b>
            <p><?php echo $viewmodel[1][0]['content']; ?></p>
          </div> <!-- /.ride_attr -->
        </div>
      <?php endif; ?>
    </header>

    <section class="radio_group_container">
      <div class="radio_group">
        <input type="radio" name="radio_group" class="radio" id="central" checked>
        <label for="central">מהמרכז</label>
      </div> <!-- /.radio_group -->

      <div class="radio_group">
        <input type="radio" name="radio_group" class="radio" id="north">
        <label for="north">מהצפון</label>
      </div> <!-- /.radio_group -->

      <div class="radio_group">
        <input type="radio" name="radio_group" class="radio" id="south">
        <label for="south">מהדרום</label>
      </div> <!-- /.radio_group -->
    </section> <!-- /.radio_group_container -->

    <?php
    if($viewmodel[0] != false)
    {
      $rides = array();
      foreach ($viewmodel[0] as $item):
        $query = mysqli_query($con, "SELECT * FROM `drive` WHERE `driverID` = '".$user['ID']."' AND `rideID` = '".$item['ID']."'");
        $rows  = mysqli_num_rows($query);

        $rides[] = $item['ID'];
    ?>
      <div class="block ride_block area-<?php echo $item['area']; ?>">
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
        if($item['driverID'] != 0):
          $driverName = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$item['driverID']."'");
          $driverName = mysqli_fetch_array($driverName);
        ?>
          <button class="button wide_button dark" disabled>
            <?php echo 'נמסרה ל'.$driverName['fullName'].'!'; ?>
          </button>

        <?php else: ?>
          <?php if($item['owner'] != $_SESSION['fullName'] && $rows == 0): ?>
            <button class="button wide_button offer" value="<?php echo $item['ID']; ?>"
              id="btn-<?php echo $item['ID']; ?>">הצע את עצמך</button>

          <?php elseif($rows > 0): ?>
            <button class="button wide_button dark" disabled>
              ממתין לאישור <div class="clock_glyph"></div>
            </button>

          <?php else: ?>
            <button class="button wide_button " value="<?php echo $item['ID']; ?>" disabled>זו נסיעה שמסרת</button>

          <?php endif; ?>
        <?php endif; ?>
        <!-- <button class="button wide_button dark" disabled>
          ממתין לאישור <div class="clock_glyph"></div>
        </button> -->

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
            $("#<?php echo $item['ID']; ?>-comments .ride_details_text").slideToggle( "slow" );
            return false;
          })
        });
      </script>
    <?php
      endforeach;

      $rides = json_encode($rides);
    }

    if($viewmodel[0] == false):
    ?>
      <div class="block ride_block">
        <div class="ride_attr">
          <span class="ride_attr_caption">
            אין נסיעות זמינות!
          </span>
        </div>
      </div>
    <?php
    endif;
    ?>
  </main>

  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-database.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-firestore.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-functions.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {

      var fullName = "<?php echo $_SESSION['fullName']; ?>";
      var phone    = "<?php echo $_SESSION['phone']; ?>";

      $(".area-1").hide();
      $(".area-3").hide();

      var name  = "<?php echo $_SESSION['fullName']; ?>";
      var phone = "<?php echo $_SESSION['phone']; ?>";
      var pass  = "<?php echo $_SESSION['pass']; ?>";
      var rides = '<?php echo $rides; ?>';

      localStorage.setItem("name", name);
      localStorage.setItem("phone", phone);
      localStorage.setItem("pass", pass);

      $(".radio").click(function() {
        if($(this).prop("checked", true))
        {
          switch ($(this).attr('id')) {
            case 'north':
              $(".area-2").hide();
              $(".area-3").hide();
              $(".area-1").slideDown('slow');
              break;
            case 'south':
              $(".area-1").hide();
              $(".area-2").hide();
              $(".area-3").slideDown('slow');
              break;
            case 'central':
              $(".area-1").hide();
              $(".area-3").hide();
              $(".area-2").slideDown('slow');
              break;
            default:
              $(".area-1").hide();
              $(".area-3").hide();
              $(".area-2").slideDown('slow');
              break;
          }
        }
      });

      $(".refresh").click(function() {
        $.ajax({
          method: "POST",
          url: "<?php echo ROOT_URL; ?>models/refresh.php",
          data: {phone: phone, pass: pass, rides: rides}
        }).done(function(msg) {
          console.log(msg);
        });

        console.log(rides);
      });

      $(".offer").click(function() {
        var id = $(this).val();
        var message = "נהג חדש הציע את עצמו לנסיעה שלך!";
        $(".popup").fadeIn("fast");

        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/chooseRide.php",
           data: { rideID: id, fullName: name }
        }).done(function(msg) {
           $("#btn-" + id).prop('disabled', true);
           $(".cancel").attr("id", id);
        });

        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/sendNotification.php",
           data: { rideID: id, message: message, key: 2 }
        }).done(function(msg) {
           console.log(msg);
        });
      });

      $(".close").click(function() {
        $(".popup").fadeOut("slow");
      });

      $(".close2").click(function() {
        var id = $(this).attr('id');

        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/updateMsg.php",
           data: { msgID: id, user: <?php echo $user['ID']; ?> }
        }).done(function(msg) {
           $(".popup").fadeOut("slow");
        });

      });

      $(".cancel").click(function() {
        var id = $(this).attr("id");
        $(".popup").fadeOut("slow");
        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/cancekRideDriver.php",
           data: { rideID: id, fullName: name }
        }).done(function(msg) {
           $("#btn-" + id).prop('disabled', false);
           console.log(msg)
        });
      });
    });
  </script>

  <script src="<?php echo ROOT_URL; ?>assets/scripts/main.js"></script>
  <script>
    $(document).ready(function() {
      $(".menu_open").click(function() {
        $(".toolbar_expanded").css("visibility", "visible");
      });
    });
  </script>
</body>
