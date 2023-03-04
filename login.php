<?php
// login.php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  // Connect to the database
  $conn = mysqli_connect('localhost', 'username', 'password', 'dbname');
  
  // Query the database for the user account with the specified username
  $query = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $query);
  
  // Check if the query returned a result
  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    // Verify the password
    if (password_verify($password, $user['password'])) {
      $_SESSION['username'] = $username;
      header('Location: dashboard.php');
      exit();
    } else {
      $error = 'Invalid password.';
    }
  } else {
    $error = 'Invalid username.';
  }
  
  mysqli_close($conn);
}
?>

<?php
// signup.php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  // Connect to the database
  $conn = mysqli_connect('localhost', 'username', 'password', 'dbname');
  
  // TODO: Validate input data
  
  // TODO: Check if username already exists
  
  // Hash the password
  $hash = password_hash($password, PASSWORD_DEFAULT);
  
  // Insert a new user record into the database
  $query = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";
  mysqli_query($conn, $query);
  
  $_SESSION['username'] = $username;
  header('Location: dashboard.php');
  exit();
  
  mysqli_close($conn);
}
?>
