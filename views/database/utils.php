<h1>Database utilities</h1>

<h2>Switch database</h2>

<form action="<?= URL ?>/database/switch" method="post">
<label for="database">Choose database</label>
  <select name="database" id="cars">
    <?php
    foreach($dbs as $sdb){
      if ($sdb === $db){
        echo '<option value="' . $sdb . '" selected>' . $sdb . '</option>';
      } else {
        echo '<option value="' . $sdb . '">' . $sdb . '</option>';
      }
    }
    ?>
  </select>
  <button type="submit">Switch database</button>
</form>

<h2>Reset database</h2>
<form action="<?= URL ?>/database/switch" method="post">
<label for="database2">Choose database</label>
<select name="database2" id="cars">
  <?php
    foreach($dbs as $sdb){
      if ($sdb === $db){
        echo '<option value="' . $sdb . '" selected>' . $sdb . '</option>';
      } else {
        echo '<option value="' . $sdb . '">' . $sdb . '</option>';
      }
    }
  ?>
  </select>
    <button type="submit">Reset all data</button>
</form>

