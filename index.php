<?php
session_start();

// Database configuration
$servername = '127.0.0.1';
$username = 'amr_web_shop_user';
$password = 'Amr-ma,236037';
$dbname = 'amr_webshop';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

function getRequestedPage()
{
  // A list of allowed pages
  $allowedPages = ['home', 'about', 'contact', 'register', 'login', 'logout', 'change_password'];

  // Check if it's a POST request
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the form_type field to determine which form was submitted
    if (isset($_POST['form_type'])) {
      if ($_POST['form_type'] === 'register') {
        return 'register';
      } else if ($_POST['form_type'] === 'contact') {
        return 'contact';
      } else if ($_POST['form_type'] === 'login') {
        return 'login';
      } elseif ($_POST['form_type'] === 'change_password') {
        return 'change_password';
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
  global $conn; // Use the global connection variable

  $regname = $regemail = $regpassword1 = $regpassword2 = '';
  $regnameErr = $regemailErr = $regpassword1Err = $regpassword2Err = '';
  $regvalid = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regname = $_POST['regname'] ?? '';
    $regemail = $_POST['regemail'] ?? '';
    $regpassword1 = $_POST['regpassword1'] ?? '';
    $regpassword2 = $_POST['regpassword2'] ?? '';

    // Validation checks
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

    if (empty($regnameErr) && empty($regemailErr) && empty($regpassword1Err) && empty($regpassword2Err)) {
      // Check if email already exists
      $sql = "SELECT email FROM users WHERE email = '" . mysqli_real_escape_string($conn, $regemail) . "'";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        $regemailErr = "Email already exists!";
      } else {
        // Email does not exist, insert new user
        $hashedPassword = password_hash($regpassword1, PASSWORD_DEFAULT); // Hash the password
        $insertSql = "INSERT INTO users (name, email, password) VALUES ('" . mysqli_real_escape_string($conn, $regname) . "', '" . mysqli_real_escape_string($conn, $regemail) . "', '$hashedPassword')";
        if (mysqli_query($conn, $insertSql)) {
          $regvalid = true; // Registration successful
        } else {
          // Handle error, e.g. database insertion failed
          echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
      }

      mysqli_free_result($result);
    }
  }

  return [
    'regvalid' => $regvalid,
    'errors' => [
      'regnameErr' => $regnameErr,
      'regemailErr' => $regemailErr,
      'regpassword1Err' => $regpassword1Err,
      'regpassword2Err' => $regpassword2Err
    ],
    'registerData' => [
      'regname' => $regname,
      'regemail' => $regemail,
      'regpassword1' => $regpassword1,
      'regpassword2' => $regpassword2
    ]
  ];
}


function getUsernameByEmail($email)
{
  $filename = "users/users.txt";

  // Check if the file exists
  if (!file_exists($filename)) {
    die("File not found");
  }

  $file = fopen($filename, "r");

  while (($line = fgets($file)) !== false) {
    // Split the line into parts
    $parts = explode('|', trim($line));

    // Check if the email matches and return the username
    if (count($parts) === 3 && $parts[0] === $email) {
      fclose($file);
      return $parts[1]; // Return the username
    }
  }

  fclose($file);
  return null; // Return null if no match found
}

function validateLoginForm()
{
  global $conn; // Use the global connection variable

  $logemail = $logpassword = '';
  $logemailErr = $logpasswordErr = '';
  $logvalid = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logemail = $_POST['logemail'] ?? '';
    $logpassword = $_POST['logpassword'] ?? '';

    // Check if email and password are not empty
    if (empty($logemail)) {
      $logemailErr = 'Please enter your email.';
      return [
        'logvalid' => $logvalid,
        'errors' => ['logemailErr' => $logemailErr, 'logpasswordErr' => $logpasswordErr],
        'loginData' => ['logemail' => $logemail, 'logpassword' => $logpassword]
      ];
    }

    if (empty($logpassword)) {
      $logpasswordErr = 'Please enter your password.';
      return [
        'logvalid' => $logvalid,
        'errors' => ['logemailErr' => $logemailErr, 'logpasswordErr' => $logpasswordErr],
        'loginData' => ['logemail' => $logemail, 'logpassword' => $logpassword]
      ];
    }

    // Prepare and execute the SQL statement
    $sql = "SELECT name, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $logemail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($logpassword, $row['password'])) {
        $_SESSION['user'] = ['logemail' => $logemail, 'logname' => $row['name']];
        $logvalid = true;
      } else {
        $logpasswordErr = 'Incorrect password. Please try again.';
      }
    } else {
      $logemailErr = 'Email address not found. Please try again or register.';
    }

    mysqli_free_result($result);
  }

  return [
    'logvalid' => $logvalid,
    'errors' => ['logemailErr' => $logemailErr, 'logpasswordErr' => $logpasswordErr],
    'loginData' => ['logemail' => $logemail, 'logpassword' => $logpassword]
  ];
}


function validateChangePasswordForm()
{
  global $conn; // Use the global connection variable

  $old_password = $new_password = $confirm_new_password = '';
  $old_passwordErr = $new_passwordErr = $confirm_new_passwordErr = '';
  $changevalid = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    // Validation checks
    if (empty($old_password)) {
      $old_passwordErr = 'Please enter your old password.';
    }
    if (empty($new_password)) {
      $new_passwordErr = 'Please enter a new password.';
    }
    if ($new_password !== $confirm_new_password) {
      $confirm_new_passwordErr = 'Passwords do not match.';
    }

    // Check old password and update new password
    if (empty($old_passwordErr) && empty($new_passwordErr) && empty($confirm_new_passwordErr)) {
      $email = $_SESSION['user']['logemail'];
      // Query to fetch the user's current password
      $sql = "SELECT password FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($old_password, $row['password'])) {
          // Update password
          $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
          $updateSql = "UPDATE users SET password = ? WHERE email = ?";
          $updateStmt = mysqli_prepare($conn, $updateSql);
          mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $email);
          if (mysqli_stmt_execute($updateStmt)) {
            $changevalid = true;
          }
          mysqli_stmt_close($updateStmt);
        } else {
          $old_passwordErr = 'Incorrect old password.';
        }
      }
      mysqli_stmt_close($stmt);
    }
  }
  return [
    'changevalid' => $changevalid,
    'old_passwordErr' => $old_passwordErr,
    'new_passwordErr' => $new_passwordErr,
    'confirm_new_passwordErr' => $confirm_new_passwordErr
  ];
}



// function showResponsePage($page)
// {
//   if ($page === 'contact') {
//     $formResult = ['valid' => false, 'errors' => []];

//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//       // Form was submitted, validate form
//       $formResult = validateContactForm();
//     }
//     // include 'contact.php';
//   } elseif ($page === 'register') {
//     $registerResult = ['regvalid' => false, 'errors' => []];
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//       // RegisterForm was submitted, validate form
//       $registerResult = validateRegisterForm();
//     }
//     if ($registerResult['regvalid']) {
//       $_SESSION['registration_success'] = true;
//       // Set $page to 'login' to include login page
//       $page = 'login';
//     }
//   }

//   if ($page === 'login') {
//     $loginResult = ['logvalid' => false, 'errors' => []];
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//       // LoginForm was submitted, validate form
//       $loginResult = validateLoginForm();
//     }
//     if ($loginResult['logvalid']) {
//       // Login is valid, redirect to home page
//       include 'home.php';
//     } else {
//       // Login is not valid, include the login page for user to try again
//       include 'login.php';
//       return; // Stop further execution to prevent loading other pages
//     }
//   } else {
//     switch ($page) {
//       case 'home':
//         include 'home.php';
//         break;
//       case 'about':
//         include 'about.php';
//         break;
//       case 'contact':
//         include 'contact.php';
//         break;
//       case 'register':
//         include 'register.php';
//         break;
//       case 'login':
//         include 'login';
//         break;
//       case 'logout':
//         session_destroy(); // Destroy the session
//         session_start();   // Restart the session to avoid session-related errors
//         include 'home.php';     // Set the page to home
//         break;
//       case 'change_password':
//         include 'change_password.php';
//         break;
//       default:
//         include '404.php';
//         break;
//     }
//   }
// }

function showResponsePage($page)
{
  if ($page === 'contact') {
    $formResult = validateContactForm();
    include 'contact.php';
  } elseif ($page === 'register') {
    $registerResult = validateRegisterForm();
    if ($registerResult['regvalid']) {
      $_SESSION['registration_success'] = true;
      $page = 'login';
    } else {
      include 'register.php';
    }
  } elseif ($page === 'login') {
    $loginResult = validateLoginForm();
    if ($loginResult['logvalid']) {
      include 'home.php';
    } else {
      include 'login.php';
    }
  } elseif ($page === 'logout') {
    session_destroy();
    session_start();
    include 'home.php';
  } elseif ($page === 'change_password') {
    $changeResult = validateChangePasswordForm();
    if ($changeResult['changevalid']) {
      echo "<p>Password changed successfully.</p>";
      include 'home.php';  // Redirect to home after successful change
    } else {
      include 'change_password.php';  // Show change password form with errors
    }
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
// Close the database connection at the end of the script
$conn->close();
