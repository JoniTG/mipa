$(document).ready(function() {
  // Redirect
  $('#enter').click(function() {
    window.location.assign('../user/login');
  });

  $('#register').click(function() {
    window.location.assign('./../user/register');
  });

  // File trigger
  $('#photo1').click(function() {
    $('#block_addphoto').click();
  });

  $('#remove1').click(function() {
    $('#block_addphoto').click();
  });

  $('#photo2').click(function() {
    $('#block_addphoto2').click();
  });

  $('#remove2').click(function() {
    $('#block_addphoto2').click();
  });

  // Images handeling
  var times = 0;
  $('input').change(function() {
    var license = $('.license')[0].files.length;
    var taxi = $('.tax')[0].files.length;

    if (license != 0 && times % 2 == 0) {
      readURL(this);
      $('#block_image1').attr('style', '');
      $('#remove1').attr('style', '');
      $('#photo1').attr('style', 'display: none;');
      times++;
    } else if (taxi != 0 && times % 2 == 1) {
      readURL2(this);
      $('#block_image2').attr('style', '');
      $('#remove2').attr('style', '');
      $('#photo2').attr('style', 'display: none;');
      times++;
    }

    if (license != 0 && taxi != 0) {
      $('.addphotos_button').attr('disabled', false);
    }
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#block_image1').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#block_image2').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
});
