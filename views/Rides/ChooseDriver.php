<?php
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

if(mysqli_connect_errno())
  die();

$drivers = mysqli_query($con, "SELECT * FROM `drive` WHERE `rideID` = '".$_GET['id']."'");
?>

<style>
.navbar a {color: white; text-decoration: none;}
.toolbar_expanded {visibility:hidden;}
</style>

<body dir="rtl">
  <div class="sticky_bar toolbar_prompt">
    <button class="menu_glyph menu_open"></button>
    <a href="<?php echo ROOT_URL; ?>rides/MyRides/" style="position: absolute;left: 5%;">
      <img src="<?php echo ROOT_URL; ?>assets/images/baseline_keyboard_backspace_black_24dp.png"
        style="-webkit-filter: invert(100%);" />
    </a>
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
      <h1 class="form_header">בחר נהג</h1>
    </header>

    <div class="block ride_block wide_block">
      <span class="label">פרטי הנסיעה</span>

      <?php foreach ($viewmodel as $item): ?>
        <div class="ride_attr">
          <div class="ride_taxi_glyph"></div>
          <span class="ride_attr_caption">
            <?php echo $item['exit']; ?>  <div class="ride_attr_arrow"></div> <?php echo $item['target']; ?>
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

        <?php if($viewmodel[0]['driverID'] == 0): ?>
          <button class="button" id="cancelRide" style="background: #3b75ce;">בטל נסיעה</button>
        <?php endif; ?>

        <div class="ride_details" id="main">
          <div class="ride_chevron_glyph"></div>
          <button class="text_button ride_details_caption">פרטים נוספים</button>
          <p class="ride_details_text" id="comments-main">
            <?php echo $item['comments']; ?>
          </p>
        </div>

      <?php endforeach; ?>
    </div> <!-- /.block.ride_block -->

    <?php
    if($viewmodel[0]['driverID'] == 0):
      while($temp = mysqli_fetch_assoc($drivers)) {
        $user = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$temp['driverID']."'");
        $user = mysqli_fetch_array($user);
    ?>

        <div class="block driver_block">
          <h2 class="driver_block_name"><?php echo $user['fullName']; ?></h2>
          <div class="ride_attr">
            <div class="ride_star_glyph"></div>
            <span class="ride_attr_caption small_caption">דירוג
              <?php
              if($user['rates'] != 0)
                echo number_format((float) ($user['rate'] / $user['rates']), 1, '.', '');
              else
                echo 0;
              ?>/5
            </span>
          </div> <!-- /.ride_attr -->

          <button class="button floating_button choose" name="driver" value="<?php echo $temp['driverID']; ?>">בחר</button>
          <input type="hidden" name="rideID" value="<?php echo $_GET['id']; ?>" />

          <div class="ride_details" id="<?php echo $temp['ID']; ?>-comments">
            <div class="ride_chevron_glyph"></div>
            <button class="text_button ride_details_caption">פרטים נוספים</button>
            <p class="ride_details_text">
              תמונת רכב:<br />
              <img src="<?php echo $user['car']; ?>" width="200" height="200" />
            </p>
          </div>
        </div> <!-- /.block.driver_block -->

        <script>
          $(document).ready(function() {
            $("#<?php echo $temp['ID']; ?>-comments").click(function(e) {
              e.preventDefault();
              $("#<?php echo $temp['ID']; ?>-comments .ride_details_text").slideToggle( "slow" );
              return false;
            })
          });
        </script>
    <?php
      }
    else:
      $driver = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$viewmodel[0]['driverID']."'");
      $driver = mysqli_fetch_array($driver);
    ?>

    <div class="block driver_block">
      <h2 class="driver_block_name"><?php echo $driver['fullName']; ?></h2>
      <div class="ride_attr">
        <div class="ride_star_glyph"></div>
        <span class="ride_attr_caption small_caption">דירוג
        <?php
        if($user['rates'] != 0)
          echo number_format((float) ($user['rate'] / $user['rates']), 1, '.', '');
        else
          echo 0;
        ?>/5</span>
      </div> <!-- /.ride_attr -->
      <div class="driver_checkmark_complete"></div>
      <span class="label">בחרת ב<?php echo $driver['fullName']; ?> לביצוע הנסיעה. תוכל ליצור איתו קשר בטלפון</span>
      <div class="ride_attr attr_phone">
        <div class="ride_phone_glyph"></div>
        <span class="ride_attr_caption"><a href="tel: <?php echo $driver['phone']; ?>"><?php echo $driver['phone']; ?></a></span>
        <span><a href="whatsapp://<?php echo '972'.substr($driver['phone'], 1);  ?>"><img src="<?php echo ROOT_URL; ?>assets/images/whatsapp.png" width="45" height="45" style="position: absolute; left: 7%;"/></a></span>
      </div> <!-- /.ride_attr -->
      <span class="label">או דרך ״הנסיעות שלי״ בתפריט</span>

      <div class="ride_details" id="chosen-comments">
        <div class="ride_chevron_glyph"></div>
        <button class="text_button ride_details_caption">פרטים נוספים</button>
        <p class="ride_details_text">
          תמונת רכב:<br />
          <img src="<?php echo $driver['car']; ?>" width="200" height="200" />
        </p>
      </div>
      <!-- <button class="text_button" id="cancel">בטל בחירה</button> -->
    </div> <!-- /.block.driver_block -->
    <?php endif; ?>

    <div class="block driver_block" id="chosenDriver" style="display: none;">
      <h2 class="driver_block_name"></h2>
      <div class="ride_attr">
        <div class="ride_star_glyph"></div>
        <span class="ride_attr_caption small_caption" id="rate"></span>
      </div> <!-- /.ride_attr -->
      <div class="driver_checkmark_complete"></div>
      <span class="label" id="chosen"></span>
      <div class="ride_attr attr_phone">
        <div class="ride_phone_glyph"></div>
        <span class="ride_attr_caption" id="phone"></span>
        <span>
          <a href="" id="whatsapp">
            <img src="<?php echo ROOT_URL; ?>assets/images/whatsapp.png" width="45" height="45" style="position: absolute; left: 7%;"/>
          </a>
        </span>
      </div> <!-- /.ride_attr -->
      <span class="label">או דרך ״הנסיעות שלי״ בתפריט</span>

      <div class="ride_details" id="chosen-comments">
        <div class="ride_chevron_glyph"></div>
        <button class="text_button ride_details_caption">פרטים נוספים</button>
        <p class="ride_details_text">
          תמונת רכב:<br />
          <img src="" width="200" height="200" />
        </p>
      </div>
      <!-- <button class="text_button" id="cancel">בטל בחירה</button> -->
    </div> <!-- /.block.driver_block -->

    <script>
      $(document).ready(function() {
        $("#chosen-comments").click(function() {
          $("#chosen-comments .ride_details_text").slideToggle( "slow" );
          return false;
        })
      });
    </script>
  </main>

  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-database.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-firestore.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.1.0/firebase-functions.js"></script>
  <script>
    $(document).ready(function() {
      var name = "<?php echo $_SESSION['fullName']; ?>";

      $(".choose").click(function() {
        var id = $(this).val();

        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/chooseDriver.php",
           data: { rideID: <?php echo $_GET['id']; ?>, fullName: name, id: id }
        }).done(function(res) {
           var json = jQuery.parseJSON(res);

           // Initialize Firebase
           var config = {
             apiKey: "AIzaSyBv88M0w7Kc-ducgP1M2Hyk0uiS3zDidpA",
             authDomain: "mipanooy-6c8d3.firebaseapp.com",
             databaseURL: "https://mipanooy-6c8d3.firebaseio.com",
             projectId: "mipanooy-6c8d3",
             storageBucket: "mipanooy-6c8d3.appspot.com",
             messagingSenderId: "117466017337"
           };
           firebase.initializeApp(config);

           var fullName = json.fullName;
           var phone    = json.phone;
           var rate     = 0;

           // Ref to firebase
           var UserRef  = firebase.database().ref('drives');
           AddDriver(fullName, phone); // Add drive to firebase

           if(json.rates != 0)
            rate = json.rate / json.rates;

           $(".driver_block").hide();
           $("#cancelRide").hide();
           $("#chosenDriver .driver_block_name").html(fullName);
           $("#chosenDriver #rate").html("דירוג " + rate.toFixed(1) + "/5");
           $("#chosenDriver #chosen").html("בחרת ב" + fullName + " לביצוע הנסיעה. תוכל ליצור איתו קשר בטלפון");
           $("#chosenDriver #phone").html("<a href='tel: " + phone + "'>" + phone + "</a>");
           $("#chosenDriver #chosen-comments img").attr('src', json.car);
           $("#chosenDriver #whatsapp").attr('href', 'whatsapp://972' + phone.substr(1));

           $("#chosenDriver").show();
           window.scrollTo(0,document.body.scrollHeight);

           function AddDriver(name, phone) {
             var newUserRef = UserRef.push();
             newUserRef.set({
               driver: fullName,
               phone: phone
             });
           }
        });

        var message = "נבחרת לביצוע הנסיעה!";
        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/sendNotification.php",
           data: { rideID: <?php echo $_GET['id']; ?>, message: message, key: 3 }
        }).done(function(res) {
          console.log(res);
        });
      });

      $("#cancel").click(function() {
        $.ajax({
           method: "POST",
           url: "<?php echo ROOT_URL; ?>models/cancelDriver.php",
           data: { rideID: <?php echo $_GET['id']; ?>, fullName: name }
        }).done(function(msg) {
           window.location.assign("<?php echo ROOT_URL; ?>rides/ChooseDriver/<?php echo $_GET['id']; ?>");
        });
      });

      $("#cancelRide").click(function() {
         $.ajax({
             method: "POST",
             url: "<?php echo ROOT_URL; ?>models/cancelRide.php",
             data: { rideID: <?php echo $_GET['id']; ?>, fullName: name }
         }).done(function(msg) {
            window.location.assign("<?php echo ROOT_URL; ?>rides/MyRides/");
         });
      });

      $("#main").click(function() {
        $("#comments-main").slideToggle( "slow" );
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
