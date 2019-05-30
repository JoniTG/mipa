<body dir="rtl" class="splash">
  <main class="splash_container">
    <h1 class="splash_header">ברוכים הבאים</h1>
    <div class="splash_glyph"></div>
    <h2 class="splash_brand">מי פנוי?</h2>
    <div class="splash_road"></div>
  </main>

  <script type="text/javascript">
    $(document).ready(function() {
      var header = <?php echo $viewmodel; ?>;
      $(".splash").delay(3000).fadeOut("slow");

      var phone = localStorage.getItem("phone");
      var pass  = localStorage.getItem("pass");

      setTimeout(function(){
        $("body").css("background-color", "white");
        if(header == 1 || pass) {
            window.location.assign("./user/logpros");
        }
        else {
          window.location.assign("./user/register");
        }
      }, 3500 );
    });

  </script>
</body>
