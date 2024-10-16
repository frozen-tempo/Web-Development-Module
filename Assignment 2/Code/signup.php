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

    <script>

      function passwordValidator() {

        var passwordField=document.getElementById("userPassword");
        var lowercase=document.getElementById("lowercaseLetter");
        var captial=document.getElementById("capitalLetter");
        var number=document.getElementById("number");
        var specialChar=document.getElementById("specialChar");
        var length =document.getElementById("length")
        var [lowercaseCheck,capitalCheck,numberCheck, specialCharCheck, lengthCheck] = [false,false,false,false,false];
        var overallCheck = lowercaseCheck && capitalCheck && numberCheck && specialCharCheck;
        
        // Show password validator message when user clicks onto the input field to input password
        passwordField.onfocus = function () {
          document.getElementById("pwValidatorMessage").style.display = "block";
        }

        // Hide password validator message when user clicks away
        passwordField.onblur = function () {
          document.getElementById("pwValidatorMessage").style.display = "none";
        }

        // Function to check and update the DOM whenever user inputs a character into password field
        passwordField.onkeyup = function() {

          // Lowercase password check
          var lowercaseRegEx = "/[a-z]/g";
          if (passwordField.value.match(lowercaseRegEx)) {
            lowercase.classList.remove("invalid");
            lowercase.classList.add("valid");
          }

          // Captial password check
          var capitalRegEx = "/[A-Z]/g";
          if (passwordField.value.match(captialRegEx)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
          }

          // Number password check
          var numberRegEx = "/[0-9]/g";
          if (passwordField.value.match(numberRegEx)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
          }

          // Special Character password check
          var speciallRegEx = "/[^A-Za-z0-9]/g";
          if (passwordField.value.match(specilalcaseRegEx)) {
            specialChar.classList.remove("invalid");
            specialChar.classList.add("valid");
          }

          // Length of password check
          if (passwordField.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
          }

        }

      }

    </script>
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
            <img src = "./Assets/accept.png"/>
            <div id = "pwValidatorMessage">
              <h3>Minimum password security requirements:</h3>
              <p id="lowercaseLetter">At least 1 <b>lowercase</b> letter</p>
              <p id="captialLetter">At least 1 <b>captial</b> letter</p>
              <p id="number">At least 1 <b>number (0-9)</b></p>
              <p id="specialChar">At least 1 <b>special character (e.g. !@#$£%&)</b></p>
              <p id="length">Must be at least <b>8 characters long</b></p>
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
  </body>
</html>
