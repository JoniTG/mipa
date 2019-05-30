<?php
// TODO: Export tbale to csv/execl
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

if(mysqli_connect_errno())
  die();

$RateXML = '';
for((double) $i = 0.0; (double) $i <= 5.0; (double) $i+=0.1)
{
  $RateXML .= '<option value="'.$i.'">'.$i.'</option>';
}
?>
<div class="ui container">
  <?php
  include 'menu.php';
  ?>

  <br /><br /><br />

  <a href="#" id="showImg">הצג תמונות מוקטנות</a> | <a href="#" id="hideImg">הסתר תמונות</a>
  | <a href="#">ייצא לאקסל</a>

  <br /><br /><br />
  <div class="twelve wide column">
    <table class="ui teal table">
      <thead>
        <tr>
          <th>שם הנהג</th>
          <th>טלפון</th>
          <th>מייל</th>
          <th>רישיון</th>
          <th>רכב</th>
          <th>נסיעות שמסר</th>
          <th>נסיעות שקיבל</th>
          <th>סכום נצבר</th>
          <th>ציון דירוג</th>
          <th>ערוך דירוג</th>
          <th>מחק</th>
          <th>ניהול</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($viewmodel as $value) {
          $driver   = mysqli_query($con, "SELECT * FROM `rides` WHERE `owner` = '".$value['fullName']."'");
          $GiveRows = mysqli_num_rows($driver);

          $driver  = mysqli_query($con, "SELECT * FROM `rides` WHERE `driverID` = '".$value['ID']."'");
          $GetRows = mysqli_num_rows($driver);

          $allMoney = mysqli_query($con, "SELECT SUM(`price`) FROM `rides` WHERE `driverID` = '".$value['ID']."'");
          $allMoney = mysqli_fetch_array($allMoney);

          $admin = '<a href="'.ROOT_URL.'Admin/promotion/'.$value['ID'].'">הפוך למנהל</a>';
          if($value['rank'] > 0)
          {
            if($value['rank'] == 2)
              $admin = 'מתכנת';
            else
              $admin = '<a href="'.ROOT_URL.'Admin/demotion/'.$value['ID'].'">הסר מניהול</a>';
          }

          echo '<tr><td>'.$value['fullName'].'</td><td>'.$value['phone'].'</td><td>'.$value['email'].'</td>
          <td><a href="'.$value['licence'].'" target="_blank"><img src="'.$value['licence'].'" width="100" /></a></td>
          <td><a href="'.$value['car'].'" target="_blank"><img src="'.$value['car'].'" width="100" /></a></td>
          <td>'.$GiveRows.'</td><td>'.$GetRows.'</td><td>'.$allMoney['SUM(`price`)'].'</td>
          <td>'.number_format((float) ($value['rate'] / $value['rates']), 1, '.', '').'</td>
          <td><a href="#" class="edit" id="'.$value['ID'].'">ערוך</a></td>
          <td><a href="#" class="delete" id="'.$value['ID'].'">מחק חשבון</a></td>
          <td>'.$admin.'</td></tr>';

          echo '<div class="ui small modal" id="del-'.$value['ID'].'">
            <div class="header">
              מחק חשבון
            </div>
            <div class="description">
              <br />
              <h3>האם למחוק את החשבון של '.$value['fullName'].'? <small>פעולה זו היא בלתי הפיכה</small></h3>
              <br /><br />
            </div>
            <div class="actions">
              <div class="ui black deny right labeled icon button">
                <i class="remove icon"></i>
                ביטול
              </div>
              <a href="'.ROOT_URL.'Admin/DelUser/'.$value['ID'].'" class="ui positive right labeled icon button">
                <i class="checkmark icon"></i>
                אישור
              </a>
            </div>
          </div>';

          echo '<div class="ui small modal" id="edit-'.$value['ID'].'">
            <div class="header">
              ערוך דירוג ל'.$value['fullName'].'
            </div>
            <form class="ui form" method="post" action="'.ROOT_URL.'Admin/EditRate/'.$value['ID'].'">
              <div class="description">
                <br />

                <div class="field">
                  <select class="ui fluid dropdown" name="rate" style="width: 30%; right: 35%;">
                    <option value="">בחר דירוג</option>
                    '.$RateXML.'
                  </select>
                </div>
                <br />
              </div>
              <div class="actions">
                <div class="ui black deny right labeled icon button">
                  <i class="remove icon"></i>
                  ביטול
                </div>
                <button type="submit" class="ui positive right labeled icon button">
                  <i class="checkmark icon"></i>
                  אישור
                </button>
              </div>
            </form>
          </div>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.delete').click(function() {
        var id = $(this).attr('id');

        $("#del-" + id).modal('show');
      });

      $('.edit').click(function() {
        var id = $(this).attr('id');

        $("#edit-" + id).modal('show');
      });
    });
  </script>
  <br /><br />
</div>
