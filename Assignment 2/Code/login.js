function handleLogin(loginError) {
  if (loginError !== "") {
    document.getElementById("login-error").classList.remove("hidden");
  } else {
    document.getElementById("login-error").classList.add("hidden");
  }
}

handleLogin(loginError);
