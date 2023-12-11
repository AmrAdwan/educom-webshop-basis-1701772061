<!DOCTYPE html>
<?php echo "<html>"; ?>

<?php echo "<head>"; ?>
<?php echo "<title>About</title>"; ?>
<link rel="stylesheet" href="./CSS/stylesheet.css">
<?php echo "</head>"; ?>

<?php echo "<body>"; ?>
<?php echo "<h1>About</h1>"; ?>
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

  <div class="about">
    <?php echo "<p>My name is Amr Adwan, I am a software developer and am following the traineeship at Educom.
        <br>
        <br>
        I have done so many projects with different programming languages; 
        such as C/C++, Python, C#. I also have experience with web development such as HTML, CSS, JavaScript.
        <br>
        <br>
        I do one of these hobbies in my free time
      </p>";
    ?>
  </div>
  <div class="hobbies">
    <ul style="list-style-type:square">
      <?php echo "<li>Chess</li>
        <li>Tennis</li>
        <li>Solve puzzles</li>
        <li>Fitness</li>
      </ul>"; ?>
  </div>
</div>
<?php echo "</body>

<footer>
  <p>&copy; Amr Adwan 2023</p>
</footer>

</html>"; ?>