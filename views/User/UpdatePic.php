<style media="screen">
  body {
    background: #3b75ce;
    background: -moz-linear-gradient(135deg, #3b75ce 0%, #598ddd 100%);
    background: -webkit-linear-gradient(135deg, #3b75ce 0%, #598ddd 100%);
    background: linear-gradient(135deg, #3b75ce 0%, #598ddd 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3b75ce', endColorstr='#598ddd', GradientType=1);
  }

  input{display: none;}

  .showbox{margin-top: 10%;visibility:hidden;}
</style>

<body dir="rtl">

  <div class="showbox">
    <div class="loader">
      <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
      </svg>
    </div>
  </div>

  <main class="container blue_container">
    <form method="post" enctype="multipart/form-data" id="myform">
      <div class="select_group">
        <h1 class="header">העלה צילום רישיון נהיגה</h1>
        <div class="block">
          <div class="block_driverslicense"></div>
          <span class="block_caption">רשיון נהיגה</span>
          <div class="block_photo">
            <label for="block_addphoto">
              <img src="" class="block_image" alt="רשיון רכב" id="block_image1" style="display: none;">
              <button class="block_removephoto" id="remove1" style="display: none;"></button>
              <button type="file" class="block_addphoto" id="photo1"></button>
            </label>
            <input type="file" id="block_addphoto" class="license" name="license[]" />
          </div>
        </div> <!-- /.block -->
      </div> <!-- /.select_group -->
      <div class="select_group">
        <h1 class="header">העלה צילום המונית שלך</h1>
        <div class="block">
          <div class="block_cab"></div>
          <span class="block_caption">תמונה מונית</span>
          <div class="block_photo">
            <label for="block_addphoto2">
              <img src="" class="block_image" alt="רשיון רכב" id="block_image2" style="display: none;">
              <button class="block_removephoto" id="remove2" style="display: none;"></button>
              <button class="block_addphoto" id="photo2"></button>
            </label>
            <input type="file" id="block_addphoto2" class="tax" name="license[]" />
          </div>
        </div> <!-- /.block -->
      </div> <!-- /.select_group -->
      <span class="small_prompt">העלו את התמונות והמשיכו בתהליך</span>
      <button type="submit" class="button wide_button addphotos_button" disabled>המשך</button><br /><br />
    </form>
  </main>
  <script>
    $(document).ready(function() {
      $("form").submit(function(e){
        e.preventDefault();
        var license = $(".license")[0].files.length;
        var taxi    = $(".tax")[0].files.length;

        if(license != 0 && taxi != 0)
        {
          $(this).unbind('submit').submit();
        }
      });

      $('input').change(function() {
        var license = $('.license')[0].files.length;
        var taxi = $('.tax')[0].files.length;

        if (license != 0 || taxi != 0) {
          $('#con').attr('disabled', true);
        }
      });

      $(".addphotos_button").click(function() {
        $(".showbox").css("visibility", "visible");
      });

    });
  </script>
  <script src="<?php echo ROOT_URL; ?>assets/scripts/reslog.js"></script>
</body>
