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
    <link rel="stylesheet" href="../styles/history.css" />

    <title>History | Dashboard</title>
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
          <a href="#">
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
            <a href="#">
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

    <!--  -->
    <section class="history-body">
      <h2>Transaction History</h2>

      <div class="history-container">
        <table class="table-main">
          <thead class="table-header">
            <tr>
              <th class="table-col">Transaction ID</th>
              <th class="table-col">Type</th>
              <th class="table-col">Amount</th>
              <th class="table-col">Category</th>
              <th class="table-col">Time</th>
              <th class="table-col">Balance Before</th>
              <th class="table-col">Balance After</th>
            </tr>
          </thead>
          <tbody id="transaction-body">
            <!-- code will populate here -->

            <!-- SAMEPLE INCOME AND EXPENSE ROW -->
            <!-- <tr class="table-row data-expense-bg">
                <td class="table-data">TXN501753</td>
                <td class="table-data data-expense-chip">expense</td>
                <td class="table-data">₹856</td>
                <td class="table-data">—</td>
                <td class="table-data">33 mins ago</td>
                <td class="table-data">₹2000</td>
                <td class="table-data">₹1900</td>
              </tr> -->

            <!-- <tr class="table-row data-income-bg">
                <td class="table-data">TXN620134</td>
                <td class="table-data data-income-chip">income</td>
                <td class="table-data">₹20000</td>
                <td class="table-data">—</td>
                <td class="table-data">3 days ago</td>
                <td class="table-data">₹1900</td>
                <td class="table-data">₹21900</td>
              </tr> -->
          </tbody>
        </table>
      </div>
    </section>
  </body>

  <!-- DROPDOWN TOGGLE -->
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

  <!-- DYNAMICALLY POPULATING INCOME & EXPENSE TRANSACTION -->
  <script>
    function getRelativeTime(timestamp) {
      const inputDate = new Date(timestamp.replace(" ", "T"));
      const now = new Date();
      const diff = now - inputDate;

      const seconds = Math.floor(diff / 1000);
      const minutes = Math.floor(seconds / 60);
      const hours = Math.floor(minutes / 60);
      const days = Math.floor(hours / 24);

      if (seconds < 60) return "just now";
      if (minutes < 60) return `${minutes} min${minutes > 1 ? "s" : ""} ago`;
      if (hours < 24) return `${hours} hour${hours > 1 ? "s" : ""} ago`;
      if (days === 1) return `yesterday`;
      if (days < 7) return `${days} day${days > 1 ? "s" : ""} ago`;

      // For older than 7 days → Custom format: 23 April, 25
      const day = inputDate.getDate();
      const month = inputDate.toLocaleString("en-US", { month: "long" });
      const shortYear = inputDate.getFullYear().toString().slice(-2);

      return `${day} ${month}, ${shortYear}`;
    }

    <!-- DYNAMICALLY FETCHING TRANSACTIONS FROM BACKEND -->
  function getRelativeTime(timestamp) {
    const inputDate = new Date(timestamp.replace(" ", "T"));
    const now = new Date();
    const diff = now - inputDate;

    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (seconds < 60) return "just now";
    if (minutes < 60) return `${minutes} min${minutes > 1 ? "s" : ""} ago`;
    if (hours < 24) return `${hours} hour${hours > 1 ? "s" : ""} ago`;
    if (days === 1) return `yesterday`;
    if (days < 7) return `${days} day${days > 1 ? "s" : ""} ago`;

    const day = inputDate.getDate();
    const month = inputDate.toLocaleString("en-US", { month: "long" });
    const shortYear = inputDate.getFullYear().toString().slice(-2);

    return `${day} ${month}, ${shortYear}`;
  }

  async function fetchTransactions() {
    try {
      const response = await fetch('../backend_process/history_db_process.php'); // ✅ Backend endpoint
      const transactions = await response.json();

      if (transactions.error) {
        console.error(transactions.error);
        return;
      }

      transactions.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

      const tbody = document.getElementById("transaction-body");
      tbody.innerHTML = ""; // clear existing rows

      transactions.forEach((txn) => {
        const tr = document.createElement("tr");

        const bgClass = txn.type === "income" ? "data-income-bg" : "data-expense-bg";
        const typeClass = txn.type === "income" ? "data-income-chip" : "data-expense-chip";

        tr.className = `table-row ${bgClass}`;

        tr.innerHTML = `
          <td class="table-data">${txn.transaction_id}</td>
          <td class="table-data ${typeClass}">${txn.type}</td>
          <td class="table-data">₹${txn.amount}</td>
          <td class="table-data">${txn.category || "—"}</td>
          <td class="table-data">${getRelativeTime(txn.timestamp)}</td>
          <td class="table-data">₹${txn.previous_balance}</td>
          <td class="table-data">₹${txn.after_balance}</td>
        `;

        tbody.appendChild(tr);
      });

    } catch (error) {
      console.error("Failed to fetch transactions:", error);
    }
  }

  // 🚀 Call it on page load
  window.onload = fetchTransactions;
</script>
</html>
