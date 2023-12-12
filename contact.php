<!DOCTYPE html>
<?php echo "<html>"; ?>

<?php echo "<head>"; ?>
<?php echo "<title>Contact</title>"; ?>
<link rel="stylesheet" href="./CSS/stylesheet.css">
<?php echo "</head>"; ?>

<?php echo "<body>"; ?>
<?php echo "<h1>Contact</h1>"; ?>
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
  <?php if (!isset($formResult['valid']) || !$formResult['valid']) { /* Show the next part only when $valid is false */
    // Extract form data for convenience
    $formData = $formResult['formData'] ?? []; ?>
    <div class="formcarry-container">
      <form action="index.php" method="POST" class="formcarry-form">
        <!-- Hidden field to identify the contact form -->
        <input type="hidden" name="form_type" value="contact">
        <select name="gender" id="gender" class="select">
          <option value="">-Select your Gender-</option>
          <option value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'male') echo 'selected="selected"'; ?>>Male</option>
          <option value="female" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'female') echo 'selected="selected"'; ?>>Female</option>
          <option value="other" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'other') echo 'selected="selected"'; ?>>Other</option>
        </select>
        <span class="error">*<?php echo $formResult['errors']['genderErr'] ?? ''; ?></span>
        <?php echo "<br>"; ?>
        <?php echo "<br>"; ?>
        <div class="input">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>" />
          <span class="error">*<?php echo $formResult['errors']['nameErr'] ?? ''; ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" id="email" />
          <span class="error"><?php echo $formResult['errors']['emailErr'] ?? ''; ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <label for="phone">Phone number</label>
          <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>" />
          <span class="error"><?php echo $formResult['errors']['phoneErr'] ?? ''; ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <div class="wrapper">
            <label for="address-one">Street</label>
            <input autocomplete="address-line1" type="text" id="street" name="street" value="<?php echo htmlspecialchars($formData['street'] ?? ''); ?>">
            <span class="error"><?php echo $formResult['errors']['streetErr'] ?? ''; ?></span>
            <?php echo "<br>"; ?>
            <?php echo "<br>"; ?>
            <label for="address-one">House number</label>
            <input autocomplete="address-line1" type=" number" id="housenumber" name="housenumber" value="<?php htmlspecialchars($formData['housenumber'] ?? ''); ?>">
            <span class="error"><?php echo $formResult['errors']['housenumberErr'] ?? ''; ?></span>
            <?php echo "<br>"; ?>
            <?php echo "<br>"; ?>
            <label for="address-one">Addition</label>
            <input autocomplete="address-line1" type="text" id="address addition" name="address addition">
          </div>
          <?php echo "<br>"; ?>
          <div>
            <label for="zip">Zip code</label>
            <input autocomplete="postal-code" type="text" id="zip" name="zip" value="<?php echo htmlspecialchars($formData['zipcode'] ?? ''); ?>">
            <span class="error"><?php echo $formResult['errors']['zipcodeErr'] ?? ''; ?></span>
          </div>
          <?php echo "<br>"; ?>
          <div>
            <label for="city">City</label>
            <input autocomplete="address-level2" type="text" id="city" name="city" value="<?php echo htmlspecialchars($formData['city'] ?? ''); ?>">
            <span class="error"><?php echo $formResult['errors']['cityErr'] ?? ''; ?></span>
          </div>
          <?php echo "<br>"; ?>
          <div>
            <label for="province">Province</label>
            <input autocomplete="address-level1" type="text" id="province" name="province" value="<?php echo htmlspecialchars($formData['province'] ?? ''); ?>">
            <span class="error"><?php echo $formResult['errors']['provinceErr'] ?? ''; ?></span>
          </div>
          <?php echo "<br>"; ?>
          <div>
            <label for="country">Country</label>
            <input autocomplete="country" type="text" id="country" name="country" value="<?php echo htmlspecialchars($formData['country'] ?? ''); ?>">
            <span class="error"><?php echo $formResult['errors']['countryErr'] ?? ''; ?></span>
          </div>
          <?php echo "<br>"; ?>
          <label for="message">Your Message</label>
          <?php echo "<br>"; ?>
          <textarea name="message" id="message" cols="30" rows="10" value="<?php echo htmlspecialchars($formData['message'] ?? ''); ?>"></textarea>
          <span class="error">*<?php echo $formResult['errors']['messageErr'] ?? ''; ?></span>
          <?php echo "<br>"; ?>
          <?php echo "<br>"; ?>
          <?php echo "<fieldset>"; ?>
          <?php echo "<legend>Select the preferred contact method:</legend>"; ?>
          <div>
            <input type="radio" id="contactChoice1" name="contact" value="email" <?php if (isset($_POST['contact']) && $_POST['contact'] == 'email') echo ' checked="checked"'; ?> />
            <label for="contactChoice1">Email</label>
            <input type="radio" id="contactChoice2" name="contact" value="phone" <?php if (isset($_POST['contact']) && $_POST['contact'] == 'phone') echo ' checked="checked"'; ?> />
            <label for="contactChoice2">Phone</label>
            <input type="radio" id="contactChoice3" name="contact" value="post" <?php if (isset($_POST['contact']) && $_POST['contact'] == 'post') echo ' checked="checked"'; ?> />
            <label for="contactChoice3">Post</label>
            <span class="error">*<?php echo $formResult['errors']['contactmethodErr'] ?? ''; ?></span>
          </div>
          <?php echo "</fieldset>"; ?>
        </div>
        <?php echo "<br>"; ?>
        <?php echo "<br>"; ?>
        <button type="Submit">Send</button>
      </form>
    <?php } else { /* Show the next part only when $valid is true */
    $formData = $formResult['formData'] ?? []; ?>
      <?php echo "<p>Thank you for your submission:</p>"; ?>
      <?php echo "<h2>Your input:</h2>"; ?>
      <?php echo "<br>"; ?>
      <div>Gender: <?php echo htmlspecialchars($formData['gender'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Name: <?php echo htmlspecialchars($formData['name'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Email: <?php echo htmlspecialchars($formData['email'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Phone number: <?php echo htmlspecialchars($formData['phone'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Street: <?php echo htmlspecialchars($formData['street'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>House number: <?php echo htmlspecialchars($formData['housenumber'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Addition: <?php echo htmlspecialchars($formData['addition'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Zip code: <?php echo htmlspecialchars($formData['zipcode'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>City <?php echo htmlspecialchars($formData['city'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Province: <?php echo htmlspecialchars($formData['province'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Country: <?php echo htmlspecialchars($formData['country'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Message: <?php echo htmlspecialchars($formData['message'] ?? ''); ?></div>
      <?php echo "<br>"; ?>
      <div>Contact method: <?php echo htmlspecialchars($formData['contactmethod'] ?? ''); ?></div>
    <?php } /* End of conditional showing */ ?>
    </div>
</div>
<?php echo "</body>

<footer>
  <p>&copy;Amr Adwan 2023</p>
</footer>

</html>"; ?>