<!DOCTYPE html>
<html>

<head>
  <title>Contact</title>
  <link rel="stylesheet" href="./CSS/stylesheet.css">
</head>

<body>
  <?php
  // initate the variables 
  $gender = $name = $email = $phone = $street = $housenumber = $addition = $zipcode = 
  $city = $province = $country = $message = $contactmethod = '';
  $genderErr = $nameErr = $emailErr = $phoneErr = $streetErr = 
  $housenumberErr = $zipcodeErr = $cityErr = $provinceErr = $countryErr = 
  $messageErr = $contactmethodErr = '';
  
  $valid = false;

  // Controleren of het formulier is verstuurd
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verzamel de ingevoerde waarden
    $gender = $_POST['gender'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $street = $_POST['street'] ?? '';
    $housenumber = $_POST['housenumber'] ?? '';
    $addition = $_POST['address addition'] ?? '';
    $zipcode = $_POST['zip'] ?? '';
    $city = $_POST['city'] ?? '';
    $province = $_POST['province'] ??'';
    $country = $_POST['country'] ?? '';
    $message = $_POST['message'] ?? '';
    $contactmethod = $_POST['contact'] ?? '';

    // Valideren van de data
    if (empty($gender)) {
      $genderErr = 'Select your gender.';
    }
    if (empty($name)) {
      $nameErr = 'Insert a name.'; 
    }
    if (empty($message)) {
      $messageErr = "Write your message";
    }
    if (empty($contactmethod)) {
      $contactmethodErr = "Choose your preferred contact method";
    }
    if ($contactmethod === 'email' && (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email))) {
      $emailErr = 'Insert a valid e-mailaddress.';
    }
    if ($contactmethod === 'phone' && empty($phone)) {
      $phoneErr = 'Insert a phone number.';
    }
    if ($contactmethod === 'post' && (empty($street) || empty($housenumber) || empty($zipcode) || empty($city) || empty($province) || empty($country))) {
      $streetErr = 'Inster a street name.';
      $housenumberErr = 'Insert a house number.';
      $zipcodeErr = 'Insert a zip code.';
      $cityErr = 'Insert a city.';
      $provinceErr = 'Insert a province.';
      $countryErr = 'Insert a country.';
    }
    
    if (empty($genderErr) && empty($nameErr) && empty($emailErr) && empty($phoneErr) 
    && empty($streetErr) && empty($housenumberErr) && empty($zipcodeErr) && empty($cityErr)
    && empty($provinceErr) && empty($countryErr) && empty($messageErr) && empty($contactmethodErr)) {
      $valid = true;
    }
  }
  ?>
  <h1>Contact</h1>
  <div class="text">
    <nav>
      <ul class="menu">
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html"> About</a></li>
        <!-- <li><a href="index.php?page=about"> About </a></li> -->
        <li><a href="contact.php">Contact </a></li>
      </ul>
    </nav>
    <br>
    <?php if (!$valid) { /* Show the next part only when $valid is false */ ?>
    <div class="formcarry-container">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="formcarry-form">
        <select name="gender" id="gender">
          <option value="">-Select your Gender-</option>
          <option value="male" <?php if (isset($_POST['gender']) && $_POST['gender']=='male') echo 'selected="selected"';?>>Male</option>
          <option value="female" <?php if (isset($_POST['gender']) && $_POST['gender']=='female') echo 'selected="selected"';?>>Female</option>
          <option value="other" <?php if (isset($_POST['gender']) && $_POST['gender']=='other') echo 'selected="selected"';?>>Other</option>
        </select>
        <span class="error">* <?php echo $genderErr; ?></span>
        <br>
        <br>
        <div class="input">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" value="<?php echo $name; ?>" />
          <span class="error">* <?php echo $nameErr; ?></span>
          <br>
          <br>
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email"  value="<?php echo $email; ?>" id="email" />
          <span class="error"> <?php echo $emailErr; ?></span>
          <br>
          <br>
          <label for="phone">Phone number</label>
          <input type="tel" id="phone" name="phone"  placeholder="123-45-678" value="<?php echo $phone; ?>" />
          <span class="error"> <?php echo $phoneErr; ?></span>
          <br>
          <br>
          <div class="wrapper">
            <label for="address-one">Street</label>
            <input autocomplete="address-line1"  type="text" id="street" name="street" value="<?php echo $street; ?>">
            <span class="error"> <?php echo $streetErr; ?></span>
            <br>
            <br>
            <label for="address-one">House number</label>
            <input autocomplete="address-line1"  type=" number" id="housenumber" name="housenumber"
              value="<?php echo $housenumber; ?>">
            <span class="error"> <?php echo $housenumberErr; ?></span>
            <br>
            <br>
            <label for="address-one">Addition</label>
            <input autocomplete="address-line1" type="text" id="address addition" name="address addition">
          </div>
          <br>
          <div>
            <label for="zip">Zip code</label>
            <input autocomplete="postal-code"  type="text" id="zip" name="zip" value="<?php echo $zipcode; ?>">
            <span class="error"><?php echo $zipcodeErr; ?></span>
          </div>
          <br>
          <div>
            <label for="city">City</label>
            <input autocomplete="address-level2"  type="text" id="city" name="city" value="<?php echo $city; ?>">
            <span class="error"> <?php echo $cityErr; ?></span>
          </div>
          <br>
          <div>
            <label for="province">Province</label>
            <input autocomplete="address-level1"  type="text" id="province" name="province"
              value="<?php echo $province; ?>">
            <span class="error"> <?php echo $provinceErr; ?></span>
          </div>
          <br>
          <div>
            <label for="country">Country</label>
            <input autocomplete="country"  type="text" id="country" name="country" value="<?php echo $country; ?>">
            <span class="error"> <?php echo $countryErr; ?></span>
          </div>
          <br>
          <label for="message">Your Message</label>
          <br>
          <textarea name="message" id="message"  cols="30" rows="10" value="<?php echo $message; ?>"></textarea>
          <span class="error">* <?php echo $messageErr; ?></span>
          <br>
          <br>
          <fieldset>
            <legend>Select the preferred contact method:</legend>
            <div>
              <input type="radio" id="contactChoice1" name="contact" value="email"  <?php if (isset($_POST['contact']) && $_POST['contact']=='email') echo ' checked="checked"';?> />
              <label for="contactChoice1">Email</label>
              <input type="radio" id="contactChoice2" name="contact" value="phone"  <?php if (isset($_POST['contact']) && $_POST['contact']=='phone') echo ' checked="checked"';?>/>
              <label for="contactChoice2">Phone</label>
              <input type="radio" id="contactChoice3" name="contact" value="post"  <?php if (isset($_POST['contact']) && $_POST['contact']=='post') echo ' checked="checked"';?>/>
              <label for="contactChoice3">Post</label>
              <span class="error">* <?php echo $contactmethodErr; ?></span>
            </div>
          </fieldset>
        </div>
        <br>
        <br>
        <button type="submit">Verstuur</button>
      </form>
      <?php } else { /* Show the next part only when $valid is true */ ?>
      <p>Thank you for your submission:</p>
      <?php echo "<h2>Your input:</h2>";?>
      <?php echo "<br>";?>
      <div>Gender: <?php echo $gender; ?></div>
      <?php echo "<br>";?>
      <div>Name: <?php echo $name; ?></div>
      <?php echo "<br>";?>
      <div>Email: <?php echo $email; ?></div>
      <?php echo "<br>";?>
      <div>Phone number: <?php echo $phone; ?></div>
      <?php echo "<br>";?>
      <div>Street: <?php echo $street; ?></div>
      <?php echo "<br>";?>
      <div>House number: <?php echo $housenumber; ?></div>
      <?php echo "<br>";?>
      <div>Addition: <?php echo $addition; ?></div>
      <?php echo "<br>";?>
      <div>Zip code: <?php echo $zipcode; ?></div>
      <?php echo "<br>";?>
      <div>Province: <?php echo $province; ?></div>
      <?php echo "<br>";?>
      <div>City <?php echo $city; ?></div>
      <?php echo "<br>";?>
      <div>Country: <?php echo $country; ?></div>
      <?php echo "<br>";?>
      <div>Message: <?php echo $message; ?></div>
      <?php echo "<br>";?>
      <div>Contact method: <?php echo $contactmethod; ?></div>
      <?php } /* End of conditional showing */ ?>
    </div>
  </div>
</body>

<footer>
  <p>&copy;Amr Adwan 2023</p>
</footer>

</html>