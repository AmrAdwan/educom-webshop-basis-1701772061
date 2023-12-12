<!DOCTYPE html>
<?php echo "<html>"; ?>

<?php echo "<head>"; ?>
<?php echo "<title>Register</title>"; ?>
<link rel="stylesheet" href="./CSS/stylesheet.css">
<?php echo "</head>"; ?>

<?php echo "<body>"; ?>
<?php echo "<h1>Register</h1>"; ?>

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
  <?php if (!isset($registerResult['regvalid']) || !$registerResult['regvalid']) { /* Show the next part only when $valid is false */
    // Extract form data for convenience
    $registerData = $registerResult['registerData'] ?? []; ?>
    <div class="formcarry-container">
      <form action="index.php" method="POST" class="formcarry-form">
        <!-- Hidden field to identify the register form -->
        <input type="hidden" name="form_type" value="register">
        <div class="input">
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="name">Name</label>
          <input type="text" id="regname" name="regname" value="<?php echo htmlspecialchars($registerData['regname'] ?? '');
                                                                ?>" />
          <span class="error">*<?php echo $registerResult['errors']['regnameErr'] ?? '';
                                ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="email">Email Address</label>
          <input type="email" id="regemail" name="regemail" value="<?php echo htmlspecialchars($registerData['regemail'] ?? '');
                                                                    ?>" />
          <span class="error">*<?php echo $registerResult['errors']['regemailErr'] ?? '';
                                ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="phone">Password</label>
          <input type="password" id="regpassword1" name="regpassword1" />
          <span class="error">*<?php echo $registerResult['errors']['regpassword1Err'] ?? '';
                                ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="phone">Repeat Password</label>
          <input type="password" id="regpassword2" name="regpassword2" />
          <span class="error">*<?php echo $registerResult['errors']['regpassword2Err'] ?? '';
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