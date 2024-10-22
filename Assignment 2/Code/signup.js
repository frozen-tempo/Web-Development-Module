function passwordValidator() {
  var passwordField = document.getElementById("userPassword");
  var lowercase = document.getElementById("lowercaseLetter");
  var capital = document.getElementById("capitalLetter");
  var number = document.getElementById("number");
  var specialChar = document.getElementById("specialChar");
  var length = document.getElementById("length");

  // Show password validator message when user clicks onto the input field to input password
  passwordField.onfocus = function () {
    document.getElementById("pwValidatorMessage").style.display = "block";
  };

  // Hide password validator message when user clicks away
  passwordField.onblur = function () {
    document.getElementById("pwValidatorMessage").style.display = "none";
  };

  // Function to check and update the DOM whenever user inputs a character into password field
  passwordField.onkeyup = function () {
    // Lowercase password check checks if password contains lowercase letter
    var lowercaseRegEx = /[a-z]/g;
    if (passwordField.value.match(lowercaseRegEx)) {
      lowercase.classList.remove("invalid");
      lowercase.classList.add("valid");
    } else {
      lowercase.classList.remove("valid");
      lowercase.classList.add("invalid");
    }

    // Captial password check checks if password contains captial letter
    var capitalRegEx = /[A-Z]/g;
    if (passwordField.value.match(capitalRegEx)) {
      capital.classList.remove("invalid");
      capital.classList.add("valid");
    } else {
      capital.classList.remove("valid");
      capital.classList.add("invalid");
    }

    // Number password check - checks if password contains number
    var numberRegEx = /[0-9]/g;
    if (passwordField.value.match(numberRegEx)) {
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }

    // Special Character password check - checks if password contains special character
    var specialRegEx = /[^A-Za-z0-9]/g;
    if (passwordField.value.match(specialRegEx)) {
      specialChar.classList.remove("invalid");
      specialChar.classList.add("valid");
    } else {
      specialChar.classList.remove("valid");
      specialChar.classList.add("invalid");
    }

    // Length of password check checks if password is at least 8 characters long
    if (passwordField.value.length >= 8) {
      length.classList.remove("invalid");
      length.classList.add("valid");
    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
    }
  };
}

function handleSignup(signupError) {
  if (signupError !== "") {
    document.getElementById("signup-error").classList.remove("hidden");
  } else {
    document.getElementById("signup-error").classList.add("hidden");
  }
}

passwordValidator();
