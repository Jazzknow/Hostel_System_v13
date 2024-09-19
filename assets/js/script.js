const form = document.getElementById("form");

const fullname = document.getElementById("fullname");
const username = document.getElementById("username");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const password = document.getElementById("password");
const confirmpass = document.getElementById("confirmpass");

// Function to show error messages
function showError(input, message) {
  const userinputbox = input.parentElement;
  userinputbox.className = "user-input-box error";
  const small = userinputbox.querySelector("small");
  small.innerText = message;
}

function showSuccess(input) {
  const userinputbox = input.parentElement;
  userinputbox.className = "user-input-box success";
}

// Function to check the length of username
function checkUsernameLength(username, min, max) {
  if (username.value.length < min) {
    showError(username, `Must be at least ${min} characters`);
  } else if (username.value.length > max) {
    showError(username, `Must be less than ${max} characters`);
  } else {
    showSuccess(username);
  }
}

function checkPasswordLength(password, min, max) {
  if (password.value.length < min) {
    showError(password, `Must be at least ${min} characters`);
  } else if (password.value.length > max) {
    showError(password, `Must be less than ${max} characters`);
  } else {
    showSuccess(password);
  }
}

// Function to validate email format
function isValidEmail(email) {
  const re =
    /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  return re.test(email);
}

// Form submit event listener
form.addEventListener("submit", function (e) {
  e.preventDefault();

  // Fullname validation
  if (fullname.value.trim() === "") {
    showError(fullname, "Fullname is required");
  } else {
    showSuccess(fullname);
  }

  if (username.value.trim() === "") {
    showError(username, "Username is required");
  } else {
    checkUsernameLength(username, 5, 15); // Username Function call from above length validation
  }

  // Email validation
  if (email.value.trim() === "") {
    showError(email, "Email is required");
  } else if (!isValidEmail(email.value.trim())) {
    showError(email, "Email is not valid");
  } else {
    showSuccess(email);
  }

  if (phone.value.trim() === "") {
    showError(phone, "Phone Number is required");
  } else {
    showSuccess(phone);
  }

  // Password validation
  if (password.value.trim() === "") {
    showError(password, "Password is required");
  } else {
    checkPasswordLength(password, 6, 25);
  }

  // Confirm Password validation
  if (confirmpass.value.trim() === "") {
    showError(confirmpass, "Confirm Password is required");
  } else if (password.value.trim() !== confirmpass.value.trim()) {
    showError(confirmpass, "Not Match for the Passsword");
  } else {
    showSuccess(confirmpass);
  }
});
