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
   <link rel="icon" href="./assests/favicon.ico" type="image/x-icon" />

  <link rel="stylesheet" href="../styles/index.css" />
  <link rel="stylesheet" href="../styles/dashboard.css" />
  <link rel="stylesheet" href="../styles/report.css" />

   <!-- GOOGLE FONTS -->
   <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />

  <title>Reports | Spendly</title>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="../assests/logo-circle-white.png" alt="logo" />
      <h2>Spendly.</h2>
    </div>
    <ul class="sidebar-links">
      <h4><span>Main Menu</span><div class="menu-separator"></div></h4>
      <li><a href="dashboard.php"><img src="../assests/icons/home-icon.svg" height="28px" /> Home</a></li>
      <li><a href="Transaction.php"><img src="../assests/icons/transaction-icon.svg" height="28px" /> Transactions</a></li>
      <li><a href="Budget.php"><img src="../assests/icons/budget-icon.svg" height="26px" /> Budget</a></li>
      <li><a href="reports.php"><img src="../assests/icons/report-icon.png" height="26px" /> Reports</a></li>
      <li><a href="./history.php"><img src="../assests/icons/history-icon.svg" height="26px" /> History</a></li>
    </ul>
    <div class="other-menu">
      <ul class="sidebar-links">
        <h4><span>Others</span><div class="menu-separator"></div></h4>
        <li><a href="/index.html#contact"><img src="../assests/icons/help-icon.svg" height="26px" /> Help</a></li>
        
        <li><a href="../backend_process/logout_process.php"><img src="../assests/icons/logout-icon.svg" height="26px" /> Log Out</a></li>
      </ul>
    </div>
  </aside>

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
                <a href="../backend_process/logout_process.php">Log Out</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  
    <!-- Main Content -->
  <!-- <main class="main-content">
    <div class="dashboard-nav-main">
      <div class="dashboard-items">
        <div class="user-dropdown-wrapper">
          <div class="dashboard-items-user" onclick="toggleDropdown()">
            <p class="username"><?= htmlspecialchars($full_name) ?></p>
            <img src="../assests/icons/triangle.png" height="11px" alt="dropdown icon" />
          </div>
          <div class="dashboard-dropdown hidden" id="dashboard-dropdown">
            <ul>
              <li>You are signed in as <br /><span><?= htmlspecialchars($email) ?></span></li>
              <li><img src="../assests/icons/log-out.svg" alt="log out icon" height="20px" />
                <a href="../backend_process/logout_process.php">Log Out</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div style="margin: 40px auto 10px auto; max-width: 800px; width: 90%; display: flex; align-items: center; gap: 8px; position: relative;">
      <h3 style="margin: 0;">Financial Goals Analysis</h3>
      <div class="info-icon-wrapper">
        <img id="info-icon" src="../assests/icons/info-icon-svgrepo-com.svg" alt="info" height="15" style="cursor: pointer;" />
        <div class="tooltip-text hidden">
          <strong>Disclaimer:</strong> The analysis and recommendations provided in this section are generated using Google Gemini AI. These insights are purely suggestive and should not be treated as definitive financial advice. For any investment or financial decisions, users are strongly advised to consult with certified financial advisors or relevant professionals. Spendly and its developers shall not be held liable for any financial losses, damages, or decisions made based on the AI-generated suggestions.
        </div>
      </div>
    </div>

    <div id="loader" class="loader"></div>
    <div id="goals-analysis" class="analysis-output"></div>
  </main> -->

  <div class="report-body">
      <div class="section-head">
        <h3>Financial Goal Analysis</h3>
        <div class="info-icon-wrapper">
          <img
            class="info-icon"
            height="20px"
            width="auto"
            src="../assests/icons/report-info.svg"
            alt="info icon"
          />
          <div class="tooltip">
            <strong>Disclaimer:</strong> The analysis and recommendations
            provided in this section are generated using Google Gemini AI. These
            insights are purely suggestive and should not be treated as
            definitive financial advice. For any investment or financial
            decisions, users are strongly advised to consult with certified
            financial advisors or relevant professionals. Spendly and its
            developers shall not be held liable for any financial losses,
            damages, or decisions made based on the AI-generated suggestions.
          </div>
        </div>
      </div>

      <div id="loader" class="loader"></div>
      <div id="goals-analysis" class="analysis-output"></div>
    </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const loader = document.getElementById('loader');
      const analysisDiv = document.getElementById('goals-analysis');

      fetch('../gemini-ai/fetch_user_data.php')
        .then(res => {
          if (!res.ok) throw new Error("Failed to fetch user data");
          return res.json();
        })
        .then(data => {
          if (!data.eligible) {
            loader.classList.add('hidden');
            analysisDiv.innerHTML = `
              <div class="upgrade-message">
                <strong>Analysis unavailable.</strong><br>
                Please upgrade your plan to access AI-powered financial reports.<br>
                <a href="payment.php">Click here to upgrade your plan</a>.
              </div>`;
            return;
          }

          if (!data.financial_profile || Object.keys(data.financial_profile).length === 0) {
            loader.classList.add('hidden');
            analysisDiv.textContent = "No financial profile found.";
            return;
          }

          return fetch('../gemini-ai/analyze_goals.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
          });
        })
        .then(res => res?.json())
        .then(result => {
          loader.classList.add('hidden');
          if (result && result.message) {
            analysisDiv.innerHTML = result.message;
          } else if (!analysisDiv.innerHTML.trim()) {
            analysisDiv.innerText = "No analysis returned.";
          }
        })
        .catch(error => {
          loader.classList.add('hidden');
          analysisDiv.innerText = "Error: " + error.message;
        });
    });

    function toggleDropdown() {
      const dropdown = document.getElementById("dashboard-dropdown");
      dropdown.classList.toggle("hidden");
    }

    document.addEventListener("click", function (event) {
      const trigger = document.querySelector(".dashboard-items-user");
      const dropdown = document.getElementById("dashboard-dropdown");
      if (!trigger.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add("hidden");
      }
    });

    document.getElementById('info-icon').addEventListener('click', () => {
      document.querySelector('.tooltip-text').classList.toggle('hidden');
    });
  </script>
</body>
<script>
   function changeSubscription() {
      window.location.href = "../public_pages/payment.php";
    }
</script>
</html>
