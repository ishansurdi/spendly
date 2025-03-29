<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assests/favicon.ico" type="image/x-icon" />
    <!-- CSS -->
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/sign-up.css" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />

    <title>Login | Spendly</title>
  </head>
  <body>
    <nav class="nav-main">
      <a href="/" class="nav-logo">
        <img
          src="../assests/logo-nav.png"
          height="36px"
          width="auto"
          alt="spendly logo"
        />
      </a>

      <div class="nav-item">
        <img src="../assests/icons/chevron-left.svg" alt="chevron left icon" />
        <a href="../index.html"> Go Back To Home</a>
      </div>
    </nav>

    <section class="signup-main">
      <div class="form-box">
        <div class="form-box-left">
          <div class="form-box-head">
            <img
              src="../assests/logo-signup.png"
              alt="spendly logo"
              width="auto"
              height="48px"
            />
            <h1>Login</h1>
            <p>
              Welcome to Spendly - Let's make <br />
              your finance better!
            </p>
          </div>

          <form action="../backend_process/login_db_process.php" method="post" class="form">
            <div class="form-container">
              <!-- <label for="name" class="input-text">Name*</label>
              <input
                type="text"
                class="input-field"
                id="name"
                name="name"
                required
                placeholder="Enter your name"/> -->
              <label for="email" class="input-text">Email*</label>
              <input
                type="email"
                class="input-field"
                id="email"
                name="email"
                required
                placeholder="Enter your email address"
              />

              <label for="password" class="input-text">Password*</label>
              <input
                type="password"
                class="input-field"
                id="password"
                name="password"
                placeholder="Enter your  password"
                required
              />

              <div class="error" id="error-message"></div>
            </div>

            <button type="submit" class="submit-btn">
              Login To Account
              <img src="../assests/icons/arrow-right.svg" alt="" />
            </button>
            <div class="login-para">
              <p>Don't have an account?</p>
              <a href="sign-up.php">Create Account</a>
            </div>
          </form>
        </div>
        <div class="form-box-right">
          <img
            src="../assests/form-right.png"
            width="auto"
            height="640px"
            alt="img bg"
          />
        </div>
      </div>
    </section>
  </body>

  <!-- JS Script for Login Error Message: -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".form"); 
    const errorMessage = document.getElementById("error-message");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); 

        const formData = new FormData(form);

        fetch("../backend_process/login_db_process.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            errorMessage.classList.remove("success"); // Ensure old success styles are removed
            errorMessage.classList.add("error"); // Add error class

            if (data.status === "success") {
                errorMessage.classList.remove("error");
                errorMessage.classList.add("success");
                errorMessage.textContent = data.message;
                setTimeout(() => {
                    window.location.href = "dashboard.php";
                }, 1500);
            } else {
                errorMessage.classList.add("error"); // Apply the class again
                errorMessage.textContent = data.message;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            errorMessage.classList.add("error");
            errorMessage.textContent = "An error occurred. Please try again later.";
        });
    });
});


</script>

  

</html>
