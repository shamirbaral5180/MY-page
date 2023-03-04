<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // handle form submission
  if (!empty($_POST["register"])) {
    // handle user registration
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
      $error = "Passwords do not match.";
    } else {
      // set up ODBC connection
      $conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=C:\\path\\to\\database.mdb", "", "");

      // check if username already exists in database
      $sql = "SELECT COUNT(*) AS count FROM users WHERE username='$username'";
      $result = odbc_exec($conn, $sql);
      $row = odbc_fetch_array($result);
      if ($row["count"] > 0) {
        $error = "Username already taken.";
      } else {
        // insert user data into database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (odbc_exec($conn, $sql)) {
          $success = "User registered successfully.";
        } else {
          $error = "Error registering user: " . odbc_errormsg();
        }
      }

      // close ODBC connection
      odbc_close($conn);
    }
  } else if (!empty($_POST["login"])) {
    // handle user login
    $username = $_POST["username"];
    $password = $_POST["password"];

    // set up ODBC connection
    $conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=C:\\path\\to\\database.mdb", "", "");

    // check if username and password match database
    $sql = "SELECT COUNT(*) AS count FROM users WHERE username='$username' AND password='$password'";
    $result = odbc_exec($conn, $sql);
    $row = odbc_fetch_array($result);
    if ($row["count"] == 1) {
      $success = "Login successful.";
    } else {
      $error = "Invalid username or password.";
    }

    // close ODBC connection
    odbc_close($conn);
  }
}
?>