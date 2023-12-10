<?php
function getRequestedPage()
{
  // A list of allowed pages
  $allowedPages = ['home', 'about', 'contact', 'register'];

  // Check if it's a POST request
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the form_type field to determine which form was submitted
    if (isset($_POST['form_type'])) {
      if ($_POST['form_type'] === 'register') {
        return 'register';
      } else if ($_POST['form_type'] === 'contact') {
        return 'contact';
      }
    }
  }

  // Retrieving the 'page' parameter from the GET request
  $requestedPage = $_GET['page'] ?? null;

  // Check whether the requested page is in the list of allowed pages
  if (in_array($requestedPage, $allowedPages)) {
    return $requestedPage;
  }

  // Return '404' for any other cases
  return '404';
}

function validateContactForm()
{
  $gender = $name = $email = $phone = $street = $housenumber = $addition = $zipcode =
    $city = $province = $country = $message = $contactmethod = '';
  $genderErr = $nameErr = $emailErr = $phoneErr = $streetErr =
    $housenumberErr = $zipcodeErr = $cityErr = $provinceErr = $countryErr =
    $messageErr = $contactmethodErr = '';

  $valid = false;

  // check whether the form is sent
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gender = $_POST['gender'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $street = $_POST['street'] ?? '';
    $housenumber = $_POST['housenumber'] ?? '';
    $addition = $_POST['address addition'] ?? '';
    $zipcode = $_POST['zip'] ?? '';
    $city = $_POST['city'] ?? '';
    $province = $_POST['province'] ?? '';
    $country = $_POST['country'] ?? '';
    $message = $_POST['message'] ?? '';
    $contactmethod = $_POST['contact'] ?? '';


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
    if (
      $contactmethod === 'post' && (empty($street) || empty($housenumber) ||
        empty($zipcode) || empty($city) || empty($province) || empty($country))
    ) {
      $streetErr = 'Inster a street name.';
      $housenumberErr = 'Insert a house number.';
      $zipcodeErr = 'Insert a zip code.';
      $cityErr = 'Insert a city.';
      $provinceErr = 'Insert a province.';
      $countryErr = 'Insert a country.';
    }

    if (
      empty($genderErr) && empty($nameErr) && empty($emailErr) && empty($phoneErr)
      && empty($streetErr) && empty($housenumberErr) && empty($zipcodeErr) && empty($cityErr)
      && empty($provinceErr) && empty($countryErr) && empty($messageErr) && empty($contactmethodErr)
    ) {
      $valid = true;
    }
  }
  // Collect form data
  $formData = [
    'gender' => $gender,
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'street' => $street,
    'housenumber' => $housenumber,
    'addition' => $addition,
    'zipcode' => $zipcode,
    'city' => $city,
    'province' => $province,
    'country' => $country,
    'message' => $message,
    'contactmethod' => $contactmethod
  ];
  return [
    'valid' => $valid,
    'errors' => [
      'genderErr' => $genderErr,
      'nameErr' => $nameErr,
      'emailErr' => $emailErr,
      'phoneErr' => $phoneErr,
      'streetErr' => $streetErr,
      'housenumberErr' => $housenumberErr,
      'zipcodeErr' => $zipcodeErr,
      'cityErr' => $cityErr,
      'provinceErr' => $provinceErr,
      'countryErr' => $countryErr,
      'messageErr' => $messageErr,
      'contactmethodErr' => $contactmethodErr
    ],
    'formData' => $formData
  ];
}


function validateRegisterForm()
{
  $regname = $regemail = $regpassword1 = $regpassword2 = '';
  $regnameErr = $regemailErr = $regpassword1Err = $regpassword2Err = '';
  $regvalid = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $regname = $_POST['regname'] ?? '';
    $regemail = $_POST['regemail'] ?? '';
    $regpassword1 = $_POST['regpassword1'] ?? '';
    $regpassword2 = $_POST['regpassword2'] ?? '';

    if (empty($regname)) {
      $regnameErr = 'Please insert your name';
    }

    if (empty($regemail) || !filter_var($regemail, FILTER_VALIDATE_EMAIL)) {
      $regemailErr = 'Please insert a valid email';
    }

    if (empty($regpassword1)) {
      $regpassword1Err = 'Please insert a password';
    }
    if (empty($regpassword2)) {
      $regpassword2Err = 'Please insert the password one more time';
    }
    if (isset($regpassword1) && isset($regpassword2)) {
      if ($regpassword1 != $regpassword2) {
        $regpassword2Err = 'The second password does not match the first password!';
      }
    }
    // if (isset($regemail)) {
    //   $myfile = fopen("users/users.txt", "r") or die("Unable to open file!");
    //   while (($line = fgets($myfile)) !== false) {
    //     // Split the line into parts
    //     $lineParts = explode('|', trim($line));

    //     // Check if the first part (email) matches the input email
    //     if (isset($lineParts[0]) && $lineParts[0] === $regemail) {
    //       $regemailErr = 'Email already exists! Please try another email';
    //       break; // Break the loop if email is found
    //     }
    //   }
    //   fclose($myfile);
    // }

    if (isset($regemail)) {
      // Open the file to check if the email already exists
      $emailExists = false;
      $myfile = fopen("users/users.txt", "r") or die("Unable to open file!");
      while (($line = fgets($myfile)) !== false) {
        $lineParts = explode('|', trim($line));
        if (isset($lineParts[0]) && $lineParts[0] === $regemail) {
          $emailExists = true;
          $regemailErr = 'Email already exists! Please try another email';
          break;
        }
      }
      fclose($myfile);

      // If the email does not exist, append new data to the file
      if (!$emailExists && empty($regnameErr) && empty($regemailErr) && empty($regpassword1Err) && empty($regpassword2Err)) {
        $myfile = fopen("users/users.txt", "a") or die("Unable to open file!");
        $newLine = $regemail . "|" . $regname . "|" . $regpassword1 . "\n";
        fwrite($myfile, $newLine);
        fclose($myfile);
      }
    }

    if (empty($regnameErr) && empty($regemailErr) && empty($regpassword1Err) && empty($regpassword2Err)) {
      $regvalid = true;
    }
  }
  $registerData = [
    'regname' => $regname,
    'regemail' => $regemail,
    'regpassword1' => $regpassword1,
    'regpassword2' => $regpassword2
  ];
  return [
    'valid' => $regvalid,
    'errors' => [
      'regnameErr' => $regnameErr,
      'regemailErr' => $regemailErr,
      'regpassword1Err' => $regpassword1Err,
      'regpassword2Err' => $regpassword2Err
    ],
    'registerData' => $registerData
  ];
}

function showResponsePage($page)
{
  if ($page === 'contact') {
    $formResult = ['valid' => false, 'errors' => []];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Form was submitted, validate form
      $formResult = validateContactForm();
    }
    include 'contact.php';
  } elseif ($page === 'register') {
    $registerResult = ['valid' => false, 'errors' => []];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // RegisterForm was submitted, validate form
      $registerResult = validateRegisterForm();
    }
    include 'register.php';
  } else {
    switch ($page) {
      case 'home':
        include 'home.php';
        break;
      case 'about':
        include 'about.php';
        break;
      default:
        include '404.php';
        break;
    }
  }
}



$page = getRequestedPage();
showResponsePage($page);
