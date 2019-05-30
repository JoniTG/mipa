<style type="text/css">
  body {
    background-color: #DADADA;
    overflow:hidden;
  }
  body > .grid {
    height: 100%;
  }
  .column {
    max-width: 450px;
  }
</style>

<div class="ui center aligned grid" style="margin-top: 12%; margin-left: 0%;">
  <div class="column">
    <h2 class="ui teal image header">
      <div class="content">
        התחבר
      </div>
    </h2>
    <form class="ui large form" method="post">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="userName" placeholder="שם משתמש">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="pass" placeholder="סיסמה">
          </div>
        </div>
        <button type="submit" class="ui fluid large teal submit button">התחבר!</button>
      </div>

      <?php
      if(!$viewmodel):
      ?>
        <div class="ui error visible message">
          שם משתמש או סיסמה שגויים!
        </div>
      <?php endif; ?>

    </form>
  </div>
</div>
