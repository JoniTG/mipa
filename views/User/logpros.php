<script type="text/javascript">
  $(document).ready(function() {
    var name  = localStorage.getItem("name");
    var phone = localStorage.getItem("phone");
    var pass  = localStorage.getItem("pass");

    $.ajax({
       method: "POST",
       url: "<?php echo ROOT_URL; ?>models/logpros.php",
       data: { name: name, phone: phone, pass: pass }
    }).done(function(msg) {
       if(msg == 1)
       {
         window.location.assign("<?php echo ROOT_URL; ?>user/logpros");
       } else {
         window.location.assign("<?php echo ROOT_URL; ?>user/login");
       }
    });
  });
</script>
