<div class="ui container">
  <?php
  include 'menu.php';
  ?>

  <br /><br /><br />

  <div class="twelve wide column">
    <form method="post" class="ui form">
      <div class="two fields">
        <div class="field">
          <label for="title">נושא</label>
          <input type="text" name="title" id="title" placeholder="נושא" />
        </div>

        <div class="field">
          <label for="type">סוג הודעה</label>
          <select class="ui fluid dropdown" name="type" id="type">
            <option value="1">נוטיפיקציה</option>
            <option value="2">דף ראשי</option>
            <option value="3">גם וגם</option>
          </select>
        </div>
      </div>

      <div class="field">
        <label for="message">הודעה</label>
        <textarea name="message" rows="8" id="message" cols="80"></textarea>
      </div>

      <div class="field">
        <button type="submit" name="sub" class="ui primary button">
          שלח הודעה!
        </button>
      </div>
    </form>
  </div>
</div>
