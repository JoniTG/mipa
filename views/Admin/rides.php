<?php
// TODO: Export tbale to csv/execl
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

if(mysqli_connect_errno())
  die();

$drivers = mysqli_query($con, "SELECT * FROM `users` ORDER BY `fullName`");

$driversXML = '';

while($temp = mysqli_fetch_assoc($drivers))
{
  $driversXML .= '<option value='.$temp['ID'].'>'.$temp['fullName'].'</option>';
}
?>

<script type="text/javascript">
  function exportExcel()
  {
      var tab_text="<table border='2px'><tr>";
      var textRange; var j=0;
      tab = document.getElementById('all'); // id of table

      for(j = 0 ; j < tab.rows.length ; j++)
      {
          tab_text = tab_text+tab.rows[j].innerHTML+"</tr>";
          //tab_text=tab_text+"</tr>";
      }

      tab_text=tab_text+"</table>";
      tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
      tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
      tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");

      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
      {
          txtArea1.document.open("txt/html","replace");
          txtArea1.document.write(tab_text);
          txtArea1.document.close();
          txtArea1.focus();
          sa=txtArea1.document.execCommand("SaveAs",true,"report.xls");
      }
      else                 //other browser not tested on IE 11
          sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

      return (sa);
  }
</script>

<div class="ui container">
  <?php
  include 'menu.php';
  ?>

  <br /><br /><br />

  <div class="twelve wide column">
    <a href="#" id="showAll">כל הנסיעות</a> | <a href="#" id="showActive">נסיעות פעילות</a>
    | <a href="#" id="deleteAll">מחק הכל</a> | <a href="#" onclick="exportExcel();">ייצא לאקסל</a>

    <br /><br /><br />

    <table class="ui teal table" id="all">
      <thead>
        <tr>
          <th>נסיעה מס'</th>
          <th>סטטוס</th>
          <th>מאיפה לאיפה?</th>
          <th>תאריך רישום</th>
          <th>תאריך נסיעה</th>
          <th>מחיר</th>
          <th>הערות</th>
          <th>נהג מוסר</th>
          <th>נהג מבצע</th>
          <th>ערוך</th>
          <th>מחק</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($viewmodel[1] as $value) {
          $status = 'ממתינה להקצאה';

          if($value['driverID'] != 0)
            $status = 'הוקצה';
          else if($value['show'] == 0)
            $status = 'הסתיימה';

          $driver = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$value['driverID']."'");
          $driver = mysqli_fetch_array($driver);

          if($driver == NULL || $driver == "")
            $driver = 'לא נבחר';
          else
            $driver = $driver['fullName'];

          echo '<tr><td>'.$value['ID'].'</td><td>'.$status.'</td>
          <td>מ'.$value['exit'].' ל'.$value['target'].'</td><td>'.$value['lastAction'].'</td>
          <td>'.$value['date'].'</td><td>'.$value['price'].' ש"ח</td>
          <td>'.$value['comments'].'</td><td>'.$value['owner'].'</td>
          <td>'.$driver.'</td>
          <td><a href="#" class="edit" id="'.$value['ID'].'">ערוך נהג מבצע</a></td>
          <td><a href="#" class="delete" id="'.$value['ID'].'">מחק נסיעה</a></td></tr>';

          echo '<div class="ui small modal" id="ride-'.$value['ID'].'">
            <div class="header">
              בחר נהג מבצע מהרשימה
            </div>
            <form class="ui form" method="post" action="'.ROOT_URL.'Admin/Edit/'.$value['ID'].'">
              <div class="description">
                <br />

                <div class="field">
                  <select class="ui fluid dropdown" name="driverID" style="width: 30%; right: 35%;">
                    <option value="">נהג</option>
                    '.$driversXML.'
                  </select>
                </div>

                <input type="hidden" name="fullName" value="'.$value['owner'].'" />

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

          echo '<div class="ui small modal" id="delete-'.$value['ID'].'">
            <div class="header">
              בחרת למחוק את נסיעה מספר '.$value['ID'].'
            </div>
            <div class="description">
              <br />
              אם הנסיעה פעילה, עלייך לעדכן את הנהג המוסר והמבצע
              <br /><br />
            </div>
            <div class="actions">
              <div class="ui black deny right labeled icon button">
                <i class="remove icon"></i>
                ביטול
              </div>
              <a href="'.ROOT_URL.'Admin/Delete/'.$value['ID'].'" class="ui positive right labeled icon button">
                <i class="checkmark icon"></i>
                אישור
              </a>
            </div>
          </div>';


        }
        ?>
      </tbody>
    </table>

    <table class="ui teal table" style="visibility: hidden;" id="active">
      <thead>
        <tr>
          <th>נסיעה מס'</th>
          <th>סטטוס</th>
          <th>מאיפה לאיפה?</th>
          <th>תאריך רישום</th>
          <th>תאריך נסיעה</th>
          <th>מחיר</th>
          <th>הערות</th>
          <th>נהג מוסר</th>
          <th>נהג מבצע</th>
          <th>ערוך</th>
          <th>מחק</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($viewmodel[0] as $value) {
          $status = 'ממתינה להקצאה';

          if($value['driverID'] != 0)
            $status = 'הוקצה';
          else if($value['show'] == 0)
            $status = 'הסתיימה';

          $driver = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$value['driverID']."'");
          $driver = mysqli_fetch_array($driver);

          if($driver == NULL || $driver == "")
            $driver = 'לא נבחר';
          else
            $driver = $driver['fullName'];

          echo '<tr><td>'.$value['ID'].'</td><td>'.$status.'</td>
          <td>מ'.$value['exit'].' ל'.$value['target'].'</td><td>'.$value['lastAction'].'</td>
          <td>'.$value['date'].'</td><td>'.$value['price'].' ש"ח</td>
          <td>'.$value['comments'].'</td><td>'.$value['owner'].'</td>
          <td>'.$driver.'</td>
          <td><a href="#" class="edit" id="'.$value['ID'].'">ערוך נהג מבצע</a></td>
          <td><a href="#" class="delete" id="'.$value['ID'].'">מחק נסיעה</a></td></tr>';

          echo '<div class="ui small modal" id="ride-'.$value['ID'].'">
            <div class="header">
              בחר נהג מבצע מהרשימה
            </div>
            <form class="ui form" method="post" action="'.ROOT_URL.'Admin/Edit/'.$value['ID'].'">
              <div class="description">
                <br />

                <div class="field">
                  <select class="ui fluid dropdown" name="driverID" style="width: 30%; right: 35%;">
                    <option value="">נהג</option>
                    '.$driversXML.'
                  </select>
                </div>

                <input type="hidden" name="fullName" value="'.$value['owner'].'" />

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

          echo '<div class="ui small modal" id="delete-'.$value['ID'].'">
            <div class="header">
              בחרת למחוק את נסיעה מספר '.$value['ID'].'
            </div>
            <div class="description">
              <br />
              אם הנסיעה פעילה, עלייך לעדכן את הנהג המוסר והמבצע
              <br /><br />
            </div>
            <div class="actions">
              <div class="ui black deny right labeled icon button">
                <i class="remove icon"></i>
                ביטול
              </div>
              <a href="'.ROOT_URL.'Admin/Delete/'.$value['ID'].'" class="ui positive right labeled icon button">
                <i class="checkmark icon"></i>
                אישור
              </a>
            </div>
          </div>';


        }
        ?>
      </tbody>
    </table>

    <div class="ui small modal" id="delete">
      <div class="header">
        מחק הכל
      </div>
      <div class="description">
        <br />
        האם אתה בטוח שאתה רוצה למחוק את כל הנסיעות?
        <br /><br />
      </div>
      <div class="actions">
        <div class="ui black deny right labeled icon button">
          <i class="remove icon"></i>
          ביטול
        </div>
        <a href="<?php echo ROOT_URL.'Admin/Delete/0'; ?>" class="ui positive right labeled icon button">
          <i class="checkmark icon"></i>
          אישור
        </a>
      </div>
    </div>

    <iframe id="txtArea1" style="display:none"></iframe>

    <script type="text/javascript">
      $(document).ready(function () {
        $(".edit").click(function() {
          var id = $(this).attr('id');

          $('#ride-' + id).modal('show');
        });

        $("#deleteAll").click(function() {
          $("#delete").modal('show');
        });

        $(".delete").click(function() {
          var id = $(this).attr('id');

          $('#delete-' + id).modal('show');
        });

        $("#showAll").click(function() {
          $("#active").css('visibility', 'hidden');
          $("#active").css('display', 'none');
          $("#all").css('visibility', 'visible');
          $("#all").css('display', '');
        });

        $("#showActive").click(function() {
          $("#all").css('visibility', 'hidden');
          $("#all").css('display', 'none');
          $("#active").css('visibility', 'visible');
          $("#active").css('display', '');
        });
      });
    </script>
  </div>
</div>
