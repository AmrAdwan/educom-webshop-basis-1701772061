<!DOCTYPE html>
<?php echo "<html>"; ?>

<?php echo "<head>"; ?>
<?php echo "<title>Login</title>"; ?>
<link rel="stylesheet" href="./CSS/stylesheet.css">
<?php echo "</head>"; ?>

<?php echo "<body>"; ?>
<?php echo "<h1>Login</h1>"; ?>

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
  <?php if (!isset($loginResult['logvalid']) || !$loginResult['logvalid']) { /* Show the next part only when $valid is false */
    // Extract form data for convenience
    $loginData = $loginResult['loginData'] ?? []; ?>
    <div class="formcarry-container">
      <form action="index.php" method="POST" class="formcarry-form">
        <!-- Hidden field to identify the login form -->
        <input type="hidden" name="form_type" value="login">
        <div class="input">
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="email">Email Address</label>
          <input type="email" id="logemail" name="logemail" value="<?php echo htmlspecialchars($loginData['logemail'] ?? '');
                                                                    ?>" />
          <span class="error">*<?php echo $loginResult['errors']['logemailErr'] ?? '';
                                ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="phone">Password</label>
          <input type="password" id="logpassword" name="logpassword" />
          <span class="error">*<?php echo $loginResult['errors']['logpasswordErr'] ?? '';
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