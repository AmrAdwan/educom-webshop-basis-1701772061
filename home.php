<!DOCTYPE html>
<?php echo "<html>"; ?>

<?php echo "<head>"; ?>
<?php echo "<title>Home</title>"; ?>
<link rel="stylesheet" href="./CSS/stylesheet.css">
<?php echo "</head>"; ?>

<?php echo "<body>"; ?>
<?php
echo "<h1>Home</h1>"; ?>
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
  <?php echo "<p> Welcome to the homepage of this website!</p>"; ?>
</div>
<?php echo "</body>"; ?>

<?php echo "<footer>
  <p>&copy; Amr Adwan 2023</p>
</footer>

</html>"; ?>