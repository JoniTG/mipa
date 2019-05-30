<?php
/**
 *
 */
class PagesModel extends Model
{
  public function Contact()
  {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if((isset($_POST['sub'])) && ($post['name'] != NULL) && ($post['phone'] != NULL)
    && ($post['subject'] != NULL) && ($post['message'] != NULL))
    {
      $to      = '';
      $subject = "הודעה חדשה מMiPanooy".$post['subject'];
      $message = 'טלפון: '.$post['message']."\n שם:".$post['name']."\n".$post['message'];
      $email   = 'info@mipannoy.com';

      if(mail($to, $subject, $message, $email))
        return true;
      return false;
    }

    return;
  }
}
