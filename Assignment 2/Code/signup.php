<?php

session_start();

  include("connection.php");
  include("functions.php");

  $error_msg = "";
  $userFirstName = $_POST["userFirstName"];
  $userLastName = $_POST["userLastName"];
  $userEmail = $_POST["userEmail"];
  $userPassword = $_POST["userFirstName"];
  $userRepeatPassword = $_POST["userRepeatPassword"];
  $userAdminKey = $_POST["userAdminKey"];
  $id = uniqid(rand(), false);

  

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="CSS/signup.css" />
    
  </head>
  <body>
    <div class="container align-items-center" style="height: 100vh">
      <div class="row h-100">
        <div class="col-lg-3 col-md-2 my-auto"></div>
        <div class="col-lg-6 col-md-8 my-auto text-center">
          <img class="mb-4 logo-main" src="./Assets/logo.svg" />
          <form method="post" class="text-center mx-5">
            <h4>Create a new account</h4>
            <label class="sr-only" for="userFirstNameInput">First Name</label>
            <input
              class="form-control my-3 rounded-pill pl-3"
              id="userFirstNameInput"
              type="text"
              name="userFirstName"
              placeholder="First name"
              required
            />

            <label class="sr-only" for="userLastNameInput">Last Name</label>
            <input
              class="form-control my-3 rounded-pill pl-3"
              id="userLastNameInput"
              type="text"
              name="userLastName"
              placeholder="Last name"
              required
            />

            <label class="sr-only" for="userEmail">Email</label>
            <input
              class="form-control my-3 rounded-pill pl-3"
              id="userEmail"
              type="email"
              name="userEmail"
              placeholder="Email Address"
              required
            />
            <label class="sr-only" for="userPassword">Password</label>
              <input
                class="form-control my-3 rounded-pill pl-3"
                id="userPassword"
                type="password"
                name="userPassword"
                placeholder="Password"
                required
              />
            <div id = "pwValidatorMessage" >
              <h5>Minimum password security requirements:</h5>
              <p id="lowercaseLetter" class="invalid">At least 1 <b>lowercase</b> letter</p>
              <p id="capitalLetter" class="invalid">At least 1 <b>capital</b> letter</p>
              <p id="number" class="invalid">At least 1 <b>number (0-9)</b></p>
              <p id="specialChar" class="invalid">At least 1 <b>special character (e.g. !@#$£%&)</b></p>
              <p id="length" class="invalid">Must be at least <b>8 characters long</b></p>
            </div>

            <label class="sr-only" for="userRepeatPassword"
              >Repeat Password</label
            >
            <input
              class="form-control my-3 rounded-pill pl-3"
              id="userRepeatPassword"
              type="password"
              name="userRepeatPassword"
              placeholder="Repeat Password"
              required
            />

            <label class="sr-only" for="userAdminKey">Admin Key</label>
            <input
              class="form-control my-3 rounded-pill pl-3"
              id="userAdminKey"
              type="text"
              name="userAdminKey"
              placeholder="Admin Key (if applicable)"
              required
            />

            <input
              class="primary-button btn-block mt-4 mb-3 py-3"
              id="button"
              type="submit"
              value="Signup"
            />
          </form>
          <a class="link-primary mb-2" href="login.php">Back to Login</a>
        </div>
        <div class="col-lg-3 col-md-2 my-auto"></div>
      </div>
    </div>
    <script src="signup.js";></script>
  </body>
</html>
