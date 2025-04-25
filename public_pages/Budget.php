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
          <a href="reports.php">
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
<!-- FAB BUTTON -->
<div class="fab" onclick="openDialog('budgetFormModal')">
  <img src="../assests/icons/plus.svg" height="28px" alt="Add Budget" />
  Add Budget
</div>
<!-- BUDGET FORM MODAL -->
<div id="budgetMessage" class="success-message" style="display:none;"></div>
<div class="overlay" id="budgetFormModal">
  <div class="Budget-container">
    <h3>Set Your Budget</h3>

    <form class="budget-form" method ="POST" action="../backend_process/save_budget.php">

      <label for="budgetAmount">Amount</label>
      <input type="number" id="budgetAmount" name="budgetAmount" placeholder="Enter amount" required />

      <label for="budgetCategory">Category</label>
      <select id="budgetCategory" name="budgetCategory" required>
      <option value="" disabled selected>Select a category</option>
  <option value="Salary">Salary</option>
  <option value="Freelance">Freelance</option>
  <option value="Investments">Investments</option>
  <option value="Business">Business</option>
  <option value="Gift">Gift</option>
  <option value="Food">Food</option>
  <option value="Transport">Transport</option>
  <option value="Shopping">Shopping</option>
  <option value="Rent">Rent</option>
  <option value="Utilities">Utilities</option>
  <option value="Healthcare">Healthcare</option>
  <option value="Entertainment">Entertainment</option>
  <option value="Travel">Travel</option>
  <option value="Education">Education</option>
  <option value="Insurance">Insurance</option>
  <option value="Savings">Savings</option>
  <option value="Other">Other</option>
</select>
      </select>

      <div class="form-actions">
        <button type="button" class="cancel-btn" onclick="closeDialog('budgetFormModal')">Cancel</button>
        <button type="submit" class="save-btn">Save</button>
      </div>
    </form>
  </div>
</div>
    <div class="dashboard">
    <h1>Budget Dashboard</h1>

    <div class="overview-section">
      <div class="overview-card">
        <h2>Budget Overview</h2>
        <div class="budget-details">
  <div>
    <p>Total Budget</p>
    <h3 id="totalBudget">₹0.00</h3>
  </div>
  <div>
    <p>Spent</p>
    <h3 id="totalSpent" class="spent">₹0.00</h3>
  </div>
  <div>
    <p>Remaining</p>
    <h3 id="remainingBudget" class="remaining">₹0.00</h3>
  </div>
</div>

      </div>
      <div class="chart-placeholder">
        <canvas id="budgetChart" width="150" height="150"></canvas>
      </div>
    </div>

    <div class="history-table-container">
    <table class="history-table">
  <thead>
    <tr>
      <th>Budget ID</th>
      <th>Category</th>
      <th>Amount</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody id="budget-history">
    <!-- Data will populate here -->
  </tbody>
</table>

</div>

    </div>
    <script>
      function openDialog(id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = "flex";
}

function closeDialog(id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = "none";
}
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
  function getFormattedDate(timestamp) {
    const inputDate = new Date(timestamp.replace(" ", "T"));
    const day = inputDate.getDate();
    const month = inputDate.toLocaleString("en-US", { month: "long" });
    const year = inputDate.getFullYear();

    return `${day} ${month} ${year}`;
  }

  async function fetchBudgetHistory() {
    try {
      const response = await fetch("../backend_process/get_budget_history.php"); // ✅ Backend endpoint
      const budgetHistory = await response.json();

      if (!Array.isArray(budgetHistory)) {
        console.error("Invalid data format");
        return;
      }

      // Sort budgets by created_at date
      budgetHistory.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

      const tbody = document.getElementById("budget-history");
      if (!tbody) {
        console.error("Could not find the tbody element.");
        return;
      }
      tbody.innerHTML = ""; // Clear existing rows

      budgetHistory.forEach((budget) => {
        const tr = document.createElement("tr");

        tr.innerHTML = `
          <td class="table-data">${budget.budget_id}</td>
          <td class="table-data">${budget.category}</td>
          <td class="table-data">₹${parseFloat(budget.amount).toFixed(2)}</td>
          <td class="table-data">${getFormattedDate(budget.created_at)}</td>
        `;

        tbody.appendChild(tr);
      });
    } catch (error) {
      console.error("Failed to fetch budget history:", error);
    }
  }

  // 🚀 Call it on page load
  fetchBudgetHistory();
});

</script>



<script>
fetch("../backend_process/save_budget.php", {
    method: "POST",
    body: formData
})
    .then(res => {
        console.log(res); // Check the raw response
        return res.json(); // Parse the JSON response
    })
    .then(data => {
        const msgDiv = document.getElementById("budgetMessage");

        // Display success or error message
        if (data.status === "success") {
            msgDiv.textContent = data.message;
            msgDiv.style.color = "green";
        } else {
            msgDiv.textContent = data.message;
            msgDiv.style.color = "red";
        }

        msgDiv.style.display = "block"; // Show the message

        form.reset();
        closeDialog("budgetFormModal");

        setTimeout(() => {
            msgDiv.style.display = "none";
        }, 5000);
    })
    .catch(error => {
        console.error("Error:", error);
    });

</script>


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  fetch('../backend_process/get_budget_data.php')
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        // Update Overview UI
        document.getElementById('totalBudget').textContent = `₹${data.total_budget.toFixed(2)}`;
        document.getElementById('totalSpent').textContent = `₹${data.spent.toFixed(2)}`;
        document.getElementById('remainingBudget').textContent = `₹${data.remaining.toFixed(2)}`;

        // Draw Chart
        const ctx = document.getElementById('budgetChart').getContext('2d');
        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['Spent', 'Remaining'],
            datasets: [{
              data: [data.spent, data.remaining],
              backgroundColor: ['#ff4d4d', '#4caf50'],
              borderWidth: 1
            }]
          },
          options: {
            plugins: {
              legend: {
                position: 'bottom'
              }
            },
            cutout: '70%'
          }
        });
      } else {
        console.error('Failed to load budget data:', data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching budget data:', error);
    });
});
</script>


  </script>
</html>
