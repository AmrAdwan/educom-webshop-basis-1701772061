<!DOCTYPE html>
<?php echo "<html>"; ?>

<?php echo "<head>"; ?>
<?php echo "<title>Change Password</title>"; ?>
<link rel="stylesheet" href="./CSS/stylesheet.css">
<?php echo "</head>"; ?>

<?php echo "<body>"; ?>
<?php echo "<h1>Change Password</h1>"; ?>

<div class="text">
  <nav>
    <ul class="menu">
      <li><a href="index.php?page=home">Home</a></li>
      <li><a href="index.php?page=about">About</a></li>
      <li><a href="index.php?page=contact">Contact</a></li>
      <?php if (isset($_SESSION['user'])) : ?>
        <li><a href="index.php?page=logout">Logout [<?php echo htmlspecialchars($_SESSION['user']['logname']); ?>]</a></li>
        <li><a href="index.php?page=change_password">Change Password</a></li>
      <?php else : ?>
        <li><a href="index.php?page=register">Register</a></li>
        <li><a href="index.php?page=login">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <?php echo "<br>"; ?>
  <?php if (!isset($changeResult['changevalid']) || !$changeResult['changevalid']) { /* Show the next part only when $valid is false */ ?>
    <div class="formcarry-container">
      <form action="index.php" method="post" class="formcarry-form">
        <!-- Hidden field to identify the change_password form -->
        <input type="hidden" name="form_type" value="change_password">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password"><br>
        <span class="error">*<?php echo $changeResult['old_passwordErr'] ?? '';
                              ?></span>
        <?php echo "<br>"; ?>
        <?php echo "<br>"; ?>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password"><br>
        <span class="error">*<?php echo $changeResult['new_passwordErr'] ?? '';
                              ?></span>
        <?php echo "<br>"; ?>
        <?php echo "<br>"; ?>
        <label for="confirm_new_password">Confirm New Password:</label>
        <input type="password" id="confirm_new_password" name="confirm_new_password"><br>
        <span class="error">*<?php echo $changeResult['confirm_new_passwordErr'] ?? '';
                              ?></span>
        <?php echo "<br>"; ?>
        <?php echo "<br>"; ?>
        <button type="Submit">Send</button>
      </form>
    <?php } ?>
    </div>
</div>
<?php echo "</body>
<footer>
<p>&copy;Amr Adwan 2023</p>
</footer>

</html>"; ?>