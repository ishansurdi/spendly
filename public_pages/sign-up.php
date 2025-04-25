<?php session_start(); ?>
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

    <title>Sign Up | Spendly</title>
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
            <h1>Sign Up Now</h1>
            <p>
              Welcome to Spendly - Let's create <br />
              your account!
            </p>
          </div>

          <form action="../backend_process/sign_up_db_process.php" method="post" class="form">
            <div class="form-container">
              <label for="name" class="input-text">Name*</label>
              <input
                type="text"
                class="input-field"
                id="name"
                name="name"
                required
                placeholder="Enter your name"/>
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
                placeholder="create a password"
                required
              />

              <!-- Display Error and Success Messages -->
              <?php
                if (isset($_SESSION['success'])) {
                  echo "<p id='success-msg' style='color: green;'>" . $_SESSION['success'] . "</p>";
                  unset($_SESSION['success']);
                  
                  // If redirection is requested
                  if (isset($_SESSION['redirect_to_payment']) && $_SESSION['redirect_to_payment']) {
                      echo "<script>
                          setTimeout(function() {
                              window.location.href = 'payment.php';
                          }, 10000);
                      </script>";
                      unset($_SESSION['redirect_to_payment']);
                  }
              }
              
                ?>
            </div>

            <button type="submit" class="submit-btn">
              Create My Account
              <img src="../assests/icons/arrow-right.svg" alt="" />
            </button>
            <div class="login-para">
              <p>Already have an account?</p>
              <a href="login.php">Log In</a>
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
</html>
