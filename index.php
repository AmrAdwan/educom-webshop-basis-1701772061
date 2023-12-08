<?php
function getRequestedPage() {
  // A list of allowed pages
  $allowedPages = ['home', 'about', 'contact'];

  // Set a default page for POST requests
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return 'contact';
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

function showResponsePage($page)
{
  if ($page === 'contact') {
    $formResult = ['valid' => false, 'errors' => []];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Form was submitted, validate form
      $formResult = validateContactForm();
    }

    include 'contact.php';
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
