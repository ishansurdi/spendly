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
  <link rel="stylesheet" href="../styles/index.css" />
  <link rel="stylesheet" href="../styles/dashboard.css" />
  <title>Reports | Dashboard</title>
  <style>
    body {
      font-family: 'Times New Roman', serif;
      margin: 0;
      padding: 0;
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      flex-shrink: 0;
      z-index: 1;
    }

    .main-content {
      flex-grow: 1;
      padding: 30px;
      background-color: #f5f5f5;
      min-height: 100vh;
      position: relative;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
    }

    .analysis-output {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      margin: 40px auto;
      max-width: 800px;
      width: 90%;
    }

    .loader {
      border: 6px solid #f3f3f3;
      border-top: 6px solid #333;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 20px auto;
      display: block;
    }

    .dashboard-nav-main {
      position: absolute;
      top: 20px;
      right: 30px;
      z-index: 1000;
    }

    .dashboard-items-user {
      cursor: pointer;
      display: flex;
      align-items: center;
    }

    .dashboard-dropdown {
      position: absolute;
      top: 40px;
      right: 0;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      z-index: 1001;
    }

    .dashboard-dropdown.hidden {
      display: none;
    }

    .loader.hidden {
      display: none;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .info-icon-wrapper {
      position: relative;
      display: inline-block;
    }

    .tooltip-text {
      position: absolute;
      top: -10px;
      left: 28px;
      background-color: #333;
      color: #fff;
      padding: 14px 20px;
      border-radius: 6px;
      font-size: 14px;
      max-width: 600px;
      width: max-content;
      white-space: normal;
      line-height: 1.6;
      z-index: 1000;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }

    .tooltip-text::after {
      content: "";
      position: absolute;
      top: 14px;
      left: -8px;
      border-width: 8px;
      border-style: solid;
      border-color: transparent #333 transparent transparent;
    }

    .info-icon-wrapper:hover .tooltip-text {
      opacity: 1;
      pointer-events: auto;
    }

    .upgrade-message {
      text-align: center;
      font-size: 18px;
      color: #444;
      background: #fff8f0;
      border: 1px solid #f0c674;
      padding: 20px;
      border-radius: 8px;
      margin: 40px auto;
      max-width: 800px;
      width: 90%;
    }

    .upgrade-message a {
      color: #0056b3;
      text-decoration: underline;
    }
  </style>
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
        <li><a href="#"><img src="../assests/icons/help-icon.svg" height="26px" /> Help</a></li>
        <li><a href="../backend_process/logout_process.php"><img src="../assests/icons/logout-icon.svg" height="26px" /> Log Out</a></li>
      </ul>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <!-- User Dropdown -->
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
  </main>

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
</html>
