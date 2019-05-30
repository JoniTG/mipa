<?php
/**
 *
 */
class FcmModel extends Model
{
  public function register()
  {
    if(isset($_POST['token']) && isset($_POST['user_agent']))
    {
      $token      = $_POST['token'];
      $user_agent = $_POST['user_agent'];
      $phone      = $_POST['phone'];

      $this->query("INSERT INTO `fcm-users` (`token`,`user_agent`,`phone`) VALUES (:token,:user_agent,:phone) ON DUPLICATE KEY UPDATE `token` = :token;");
      $this->bind(':token', $token);
      $this->bind(':user_agent', $user_agent);
      $this->bind(':phone', $phone);
      $this->execute();
      return true;
    }

    return false;
  }

  public function Notification($tokens, $msg, $url)
  {
    $tokensArray = array_map(
      function($tokenRow)
      {
        return $tokenRow['token'];
      },
      $tokens
    );

    // API access key from Google API's Console
    define('API_ACCESS_KEY', 'AIzaSyB7lbQ6Wc8FqEg4MVM12uPK15DuavsA27o');

    // Notificaiton fields
    $fields = json_encode(
      array(
        'registration_ids' => $tokensArray,
        'priority' => 10,
        'data' => array(
          'url'  => $url,
          'body' => $msg,
        )
      )
    );

    $headers = array(
      'Authorization: key=' . API_ACCESS_KEY,
      'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    curl_close($ch);

    error_log('result'.$result);

    // Insert the notification into the db
    $date = date('d/m/y h:i:s');
    $this->query("INSERT INTO `notification` (`msg`, `key`, `date`)
        VALUES(:msg, :key, :datentime)");
    $this->bind(':msg', $msg);
    $this->bind(':key', $url);
    $this->bind(':datentime', $date);
    $this->execute();

    return;
  }
}
