<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$uid = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- FAVICON -->
    <link rel="icon" href="../assests/favicon.ico" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/dashboard.css" />
    <link rel="stylesheet" href="../styles/Budget.css" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />

    <title>Budget | Dashboard</title>
  </head>
  <body>
    <!-- Navigation Menu Bar -->
    <nav class="dashboard-nav-main">
      <div class="dashboard-items">
        <div class="user-dropdown-wrapper">
          <div class="dashboard-items-user" onclick="toggleDropdown()">
            <!-- UPDATE -->
            <!--From database-->
            <p class="username"><?= htmlspecialchars($full_name) ?></p>
            <img
              src="../assests/icons/triangle.png"
              height="11px"
              alt="dropdown icon"
            />
          </div>
          <div class="dashboard-dropdown hidden" id="dashboard-dropdown">
            <ul>
              <li>
                You are signed in as <br />
                <!-- UPDATE -->
                <!--From database-->
                <span><?= htmlspecialchars($email) ?></span>
              </li>
              <li class="subscription-btn" onclick="changeSubscription()">
                <img
                  src="../assests/icons/subscription-5e.svg"
                  alt="credit card icon"
                  height="22px"
                />
                Change Your Subscription Plan
              </li>
              <li>
                <img
                  src="../assests/icons/log-out.svg"
                  alt="log out icon"
                  height="20px"
                />
                Log Out
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Side Menu Bar -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <img src="../assests/logo-circle-white.png" alt="logo" />
        <h2>Spendly.</h2>
      </div>
      <ul class="sidebar-links">
        <h4>
          <span>Main Menu</span>
          <div class="menu-separator"></div>
        </h4>
        <li>
          <a href="dashboard.php">
            <img
              src="../assests/icons/home-icon.svg"
              height="28px"
              width="auto"
              alt="house icon"
            />
            Home</a
          >
        </li>
        <li>
          <a href="Transaction.php">
            <img
              src="../assests/icons/transaction-icon.svg"
              height="28px"
              width="auto"
              alt="transaction icon"
            />
            Transactions</a
          >
        </li>
        <li>
          <a href="/budget.html">
            <img
              src="../assests/icons/budget-icon.svg"
              height="26px"
              width="auto"
              alt="budget icon"
            />
            Budget</a
          >
        </li>
        <li>
          <a href="report.php">
            <img
              src="../assests/icons/report-icon.png"
              height="26px"
              width="auto"
              alt="report icon"
            />
            Reports</a
          >
        </li>
        <li>
          <a href="history.php">
            <img
              src="../assests/icons/history-icon.svg"
              height="26px"
              width="auto"
              alt="history icon"
            />
            History</a
          >
        </li>
      </ul>
      <div class="other-menu">
        <ul class="sidebar-links">
          <h4>
            <span>Others</span>
            <div class="menu-separator"></div>
          </h4>
          <li>
            <a href="/index.html#contact">
              <img
                src="../assests/icons/help-icon.svg"
                height="26px"
                width="auto"
                alt="help icon"
              />
              Help</a
            >
          </li>
          <li>
            <a href="../backend_process/logout_process.php">
              <img
                src="../assests/icons/logout-icon.svg"
                height="26px"
                width="auto"
                alt="log out icon"
              />
              Log Out</a
            >
          </li>
        </ul>
      </div>
    </aside>

    <section class="budget-body">
      <h2>find out your goal progress</h2>

      <div class="budget-container">
        <div class="box" onclick="openDialog('dailyModal')">
          <h3 class="box-heading">Daily Goals</h3>
          <p class="box-desc">
            Track today's spending and stick to your budget.
          </p>

          <div class="button-group">
            <div class="chevron-right-btn" onclick="openDialog('dailyModal')">
              <img src="/assests/icons/chevron-right.svg" alt="" />
            </div>
          </div>
        </div>
        <div class="box" onclick="openDialog('weeklyModal')">
          <h3 class="box-heading">Weekly Goals</h3>
          <p class="box-desc">
            Review expenses and adjust habits for better saving.
          </p>

          <div class="button-group">
            <div class="chevron-right-btn" onclick="openDialog('weeklyModal')">
              <img src="/assests/icons/chevron-right.svg" alt="" />
            </div>
          </div>
        </div>
        <div class="box" onclick="openDialog('monthlyModal')">
          <h3 class="box-heading">Monthly Goals</h3>
          <p class="box-desc">
            Measure progress toward savings and financial milestones.
          </p>

          <div class="button-group">
            <div class="chevron-right-btn" onclick="openDialog('monthlyModal')">
              <img src="/assests/icons/chevron-right.svg" alt="" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- DIALOG BOX FOR DAILY GOALS -->
    <div class="overlay" id="dailyModal">
      <div class="form-container">
        <h3>Your Daily Goals Progress</h3>

        <div class="data-container">
        <div class="">1</div>

        <div class="">2</div>

        <div class="">3</div>

          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 4</p>
          </div>
        </div>

        <div class="form-actions">
          <button
            type="button"
            class="cancel-btn"
            onclick="closeDialog('dailyModal')"
          >
            Cancel
          </button>
          <button type="submit" class="save-btn">Save</button>
        </div>
      </div>
    </div>

    <!-- DIALOG BOX FOR WEEKLY GOALS -->
    <div class="overlay" id="weeklyModal">
      <div class="form-container">
        <h3>Your Weekly Goals Progress</h3>

        <div class="data-container">
          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 1</p>
          </div>

          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 2</p>
          </div>

          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 3</p>
          </div>

          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 4</p>
          </div>
        </div>

        <div class="form-actions">
          <button
            type="button"
            class="cancel-btn"
            onclick="closeDialog('weeklyModal')"
          >
            Cancel
          </button>
          <button type="submit" class="save-btn">Save</button>
        </div>
      </div>
    </div>

    <!-- DIALOG BOX FOR MONTHLY GOALS -->
    <div class="overlay" id="monthlyModal">
      <div class="form-container">
        <h3>Your Monthly Goals Progress</h3>

        <div class="data-container">
          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 1</p>
          </div>

          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 2</p>
          </div>

          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 3</p>
          </div>

          <div class="chart-box">
            <canvas id=""></canvas>
            <p>graph 4</p>
          </div>
        </div>

        <div class="form-actions">
          <button
            type="button"
            class="cancel-btn"
            onclick="closeDialog('monthlyModal')"
          >
            Cancel
          </button>
          <button type="submit" class="save-btn">Save</button>
        </div>
      </div>
    </div>
  </body>
  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById("dashboard-dropdown");
      dropdown.classList.toggle("hidden");
      console.log("first");
    }

    document.addEventListener("click", function (event) {
      const trigger = document.querySelector(".dashboard-items-user");
      const dropdown = document.getElementById("dashboard-dropdown");
      if (!trigger.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add("hidden");
      }
    });
  </script>

  <script>
    function openDialog(modalId) {
      document.getElementById(modalId).style.display = "flex";
    }

    function closeDialog(modalId) {
      document.getElementById(modalId).style.display = "none";
    }
  </script>
  <script>
   function changeSubscription() {
      window.location.href = "../public_pages/payment.php";
    }
</script>
</html>
