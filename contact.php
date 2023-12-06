<!DOCTYPE html>
<html>

<head>
  <title>Contact</title>
  <link rel="stylesheet" href="./CSS/stylesheet.css">
</head>

<body>
  <?php
  // initate the variables 
  $geslacht = $naam = $email = $telefoon = $straat = $huisnummer = $toevoeging = $postcode = 
  $stad = $provincie = $land = $bericht = $contactmethode = '';
  $geslachtErr = $naamErr = $emailErr = $telefoonErr = $straatErr = 
  $huisnummerErr = $postcodeErr = $stadErr = $provincieErr = $landErr = 
  $berichtErr = $contactmethodeErr = '';
  
  $valid = false;

  // Controleren of het formulier is verstuurd
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verzamel de ingevoerde waarden
    $geslacht = $_POST['geslacht'] ?? '';
    $naam = $_POST['Naam'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $straat = $_POST['straat'] ?? '';
    $huisnummer = $_POST['huisnummer'] ?? '';
    $toevoeging = $_POST['address toevoeging'] ?? '';
    $postcode = $_POST['zip'] ?? '';
    $stad = $_POST['stad'] ?? '';
    $provincie = $_POST['state'] ??'';
    $land = $_POST['land'] ?? '';
    $bericht = $_POST['bericht'] ?? '';
    $contactmethode = $_POST['contact'] ?? '';

    // Valideren van de data
    if (!empty($geslacht)) {
      $valid = true;
    }
    else {
      $valid = false;
      $geslachtErr = 'Selecteer een geslacht.';
    }
    if (!empty($naam)) {
      $valid = true;
    }
    else {
      $valid = false;
      $naamErr = 'Voer een naam in.'; 
    }
    // if (!empty($email)) {
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $emailErr = "Voer een email in.";
    // }
    // if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $emailErr = itoast("Ongeldig e-mailadres", "error", "Extra opties hier");
    // }
    // if (!empty($telefoon)) {
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $telefoonErr = 'Voer een telefoonnummer in.';
    // }

    // if (!empty($straat))
    // {
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $straatErr = "Voer een straat naam in.";
    // }

    // if (!empty($huisnummer)){
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $huisnummerErr = "Voer een huisnummer in.";
    // }

    // if (!empty($postcode)) {
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $postcodeErr = "Voer een postcode in.";
    // }

    // if (!empty($stad)) {
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $stadErr = "Voer een stand in.";
    // }

    // if (!empty($land)) {
    //   $valid = true;
    // }
    // else {
    //   $valid = false;
    //   $landErr = "Voer een land in";
    // }

    if (!empty($bericht)) {
      $valid = true;
    }
    else {
      $valid = false;
      $landErr = "Schrijf een bericht";
    }

    if ($contactmethode === 'Email' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $valid = false;
      $emailErr = 'Voer een geldig e-mailadres in.';
    }
    else {
      $valid = true;
    }
    if ($contactmethode === 'Telefoon' && empty($telefoon)) {
      $valid = false;
      $telefoonErr = 'Voer een telefoonnummer in.';
    }
    else {
      $valid = true;
    }
    if ($contactmethode === 'Post' && (empty($straat) || empty($huisnummer) || empty($postcode) || empty($stad) || empty($provincie) || empty($land))) {
      $valid = false;
      $straatErr = 'Voer een straatnaam in.';
      $huisnummerErr = 'Voer een huisnummer in.';
      $postcodeErr = 'Voer een postcode in.';
      $stadErr = 'Voer een stad in.';
      $provincieErr = 'Voer een provincie in.';
      $landErr = 'Voer een land in.';
    }
    else {
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
        <form action="#" method="POST" class="formcarry-form">
          <select naam="geslacht" id="geslacht" required>
            <option value="">-Selecteer Gender-</option>
            <option value="hr">Hr</option>
            <option value="mw">Mw</option>
            <option value="anders">anders</option>
          </select>
          <br>
          <br>
          <div class="input">
            <label for="naam">Naam</label>
            <input type="text" id="naam" naam="naam" required value="<?php echo $naam; ?>"/>
            <span class="error">* <?php echo $naamErr; ?></span>
            <br>
            <br>
            <label for="email">Email Address</label>
            <input type="email" id="email" naam="email" value="<?php echo $email; ?>" id="email" />
            <span class="error">* <?php echo $emailErr; ?></span>
            <br>
            <br>
            <label for="telefoon">Telefoonnummer</label>
            <input type="tel" id="telefoon" naam="telefoon" placeholder="123-45-678" value="<?php echo $telefoon; ?>" />
            <span class="error">* <?php echo $telefoonErr; ?></span>
            <br>
            <br>
            <div class="wrapper">
              <label for="address-one">Straat</label>
              <input autocomplete="address-line1" type="text" id="straat" naam="straat" value="<?php echo $straat; ?>">
              <span class="error">* <?php echo $straatErr; ?></span>
              <br>
              <br>
              <label for="address-one">Huisnummer</label>
              <input autocomplete="address-line1" type="nummer" id="huisnummer" naam="huisnummer" value="<?php echo $huisnummer; ?>">
              <span class="error">* <?php echo $huisnummerErr; ?></span>
              <br>
              <br>
              <label for="address-one">Toevoeging</label>
              <input autocomplete="address-line1" type="text" id="address toevoeging" naam="address toevoeging">
            </div>
            <br>
            <div>
              <label for="zip">Postcode</label>
              <input autocomplete="postal-code" type="text" id="zip" naam="zip" value="<?php echo $postcode; ?>">
              <span class="error">* <?php echo $postcodeErr; ?></span>
            </div>
            <br>
            <div>
              <label for="stad">Stad</label>
              <input autocomplete="address-level2" type="text" id="stad" naam="stad" value="<?php echo $stad; ?>">
              <span class="error">* <?php echo $stadErr; ?></span>
            </div>
            <br>
            <div>
              <label for="provincie">Provincie</label>
              <input autocomplete="address-level1" type="text" id="provincie" naam="provincie" value="<?php echo $provincie; ?>">
              <span class="error">* <?php echo $provincieErr; ?></span>
            </div>
            <br>
            <div>
              <label for="land">Land</label>
              <input autocomplete="land" type="text" id="land" naam="land" value="<?php echo $land; ?>">
              <span class="error">* <?php echo $landErr; ?></span>
            </div>
            <br>
            <label for="bericht">Uw Bericht</label>
            <textarea naam="bericht" id="bericht" cols="30" rows="10" value="<?php echo $bericht; ?>"></textarea>
            <span class="error">* <?php echo $berichtErr; ?></span>
            <br>
            <br>
            <fieldset>
              <legend>Selecteer de gewenste contactmethode:</legend>
              <div>
                <input type="radio" id="contactChoice1" naam="contact" value="email" required />
                <label for="contactChoice1">Email</label>
                <span class="error">* <?php echo $contactmethodeErr; ?></span>
                <input type="radio" id="contactChoice2" naam="contact" value="telefoon" required />
                <label for="contactChoice2">Telefoon</label>
                <span class="error">* <?php echo $contactmethodeErr; ?></span>
                <input type="radio" id="contactChoice3" naam="contact" value="Post" required />
                <label for="contactChoice3">Post</label>
                <span class="error">* <?php echo $contactmethodeErr; ?></span>
              </div>
            </fieldset>
          </div>
        <br>
        <br>
        <button type="submit">Verstuur</button>
      </form>
      <?php } else { /* Show the next part only when $valid is true */ ?>
        <p>Bedankt voor uw reactie:</p> 
        <?php echo "<h2>Uw ingevoerde gegevens:</h2>";?>
        <?php echo "<br>";?>
        <div>Geslacht: <?php echo $geslacht; ?></div>
        <?php echo "<br>";?>
        <div>Naam: <?php echo $naam; ?></div>
        <?php echo "<br>";?>
        <div>Email: <?php echo $email; ?></div>
        <?php echo "<br>";?>
        <div>Telefoonnummer: <?php echo $telefoon; ?></div>
        <?php echo "<br>";?>
        <div>Straat: <?php echo $straat; ?></div>
        <?php echo "<br>";?>
        <div>Huisnummer: <?php echo $huisnummer; ?></div>
        <?php echo "<br>";?>
        <div>Toevoeging: <?php echo $toevoeging; ?></div>
        <?php echo "<br>";?>
        <div>Postcode: <?php echo $postcode; ?></div>
        <?php echo "<br>";?>
        <div>Provincie: <?php echo $provincie; ?></div>
        <?php echo "<br>";?>
        <div>Stad <?php echo $stad; ?></div>
        <?php echo "<br>";?>
        <div>Land: <?php echo $land; ?></div>
        <?php echo "<br>";?>
        <div>Bericht: <?php echo $bericht; ?></div>
        <?php echo "<br>";?>
        <div>Contactmethode: <?php echo $contactmethode; ?></div>
    <?php } /* End of conditional showing */ ?>
    </div>
  </div>
</body>

<footer>
  <p>&copy;Amr Adwan 2023</p>
</footer>

</html>