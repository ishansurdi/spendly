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
    <link rel="stylesheet" href="../styles/Transaction.css" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />

    <title>Transaction | Spendly</title>
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
          <a href="Budget.php">
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

    <!-- Transaction Body -->
    <?php
if (isset($_GET['status']) && $_GET['status'] === 'success') {
  $message = '<p id="statusMessage" style="color: green; text-align: center;">Money added successfully!</p>';
} elseif (isset($_GET['status'])) {
  $msg = isset($_GET['msg']) ? urldecode($_GET['msg']) : "Error adding money. Please try again.";
  $message = '<p id="statusMessage" style="color: red; text-align: center;">' . htmlspecialchars($msg) . '</p>';
}
?>
<?php if (isset($message)) echo $message; ?>



    <section class="transaction-body">
      <!--From database-->
      <div class="transaction-heading">
        <h3><?= htmlspecialchars($full_name) ?>'s Income & Expenses</h3>
      </div>

      <h2>Hello <?= htmlspecialchars($full_name) ?> 👋</h2>
      <div class="row-1">
        <div class="income-box">
          <div class="income-head">
            <div class="income-img">
              <img
                src="../assests/icons/income.svg"
                alt="note symbol"
                height="28px"
                width="auto"
              />
            </div>
            <h3 class="income-text">Total Monthly Income</h3>
          </div>
          <!--From database-->
          <p class="money">
          <?php include '../backend_process/get_income_summary.php'; ?></p>
        </div>

        <div class="expense-box">
          <div class="expense-head">
            <div class="expense-img">
              <img
                src="../assests/icons/expense.svg"
                alt="note symbol"
                height="28px"
                width="auto"
              />
            </div>
            <h3 class="expense-text">Total Monthly Expense</h3>
          </div>
          <!--From database-->
          <p class="money">
          <?php include '../backend_process/get_expense_summary.php'; ?></p>
        </div>
      </div>

      <div class="row-2">

      <div class="visual-analytics">
     <h2>Visual Analytics</h2>
     <p>Track, compare, and analyze your income and expenses over time  through easy-to-read <br> graphs and breakdowns.</p>
     <div class="charts-wrapper">
  <div class="chart-box">
    <canvas id="incomeExpenseChart"></canvas>
    <p>Income vs Expense Over Time</p>
  </div>
  
  <div class="chart-box">
    <canvas id="expensePieChart"></canvas>
    <p>Expense Categories</p>
  </div>

  <div class="chart-box">
    <canvas id="incomePieChart"></canvas>
    <p>Income Categories</p>
  </div>

  <div class="chart-box">
    <canvas id="breakdownChart"></canvas>
    <p>Breakdown of Income and Expense</p>
  </div>
</div>
</section>

    <!-- FLOATING ACTION BUTTON (ADD MONEY) -->
    <div class="fab" title="Add" onclick="openDialog()">
      <img src="../assests/icons/plus.svg" height="28px" alt="plus symbol" />
      <p>Add Money</p>
    </div>

    <!-- DIALOG BOX WHEN FAB IS CLICKLED -->
    <div class="overlay" id="dialogOverlay">
      <div class="form-container">
        <h3>Adding money to spendly</h3>
        <form class="add-form" method="POST" action="../backend_process/add_income_expense.php">
          <label for="moneyType" class="add-form-label">Money Type</label>
          <select name="moneyType" required class="add-form-field">
            <option value="" disabled selected hidden>Select</option>
            <option value="income">Income</option>
            <option value="expense">Expense</option>
          </select>

          <label for="amount" class="add-form-label">Total Amount</label>
          <input
            type="number"
            class="add-form-field"
            placeholder="1234"
            name="amount"
            required
          />

          <label for="category" class="add-form-label">Category</label>
<select
  name="category"
  required class="add-form-field"
>
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


          <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="closeDialog()">
              Cancel
            </button>
            <button type="submit" class="save-btn">Save</button>
          </div>
        </form>
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
    function openDialog() {
      document.getElementById("dialogOverlay").style.display = "flex";
    }

    function closeDialog() {
      document.getElementById("dialogOverlay").style.display = "none";
    }
  </script>
  <script>
  window.onload = function () {
    const msg = document.getElementById("statusMessage");
    if (msg) {
      setTimeout(() => {
        msg.style.display = "none";
      }, 3000); // 3000 milliseconds = 3 seconds
    }
  };
</script>
<script>
   function changeSubscription() {
      window.location.href = "../public_pages/payment.php";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  fetch('../backend_process/get_chart_data.php')
  .then(response => response.json())
  .then(data => {
    // 1. Line Chart – Income vs Expense Over Time (grouped by day)
    const linePeriods = data.line_chart.map(row => row.period);
    const lineIncome = data.line_chart.map(row => parseFloat(row.income));  // Convert to number
    const lineExpense = data.line_chart.map(row => parseFloat(row.expense)); // Convert to number

    const incomeExpenseChart = new Chart(document.getElementById('incomeExpenseChart'), {
        type: 'line',
        data: {
            labels: linePeriods,
            datasets: [
                {
                    label: 'Income',
                    data: lineIncome,
                    borderColor: 'green',
                    fill: false
                },
                {
                    label: 'Expense',
                    data: lineExpense,
                    borderColor: 'red',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // 2. Pie Chart – Income Category Breakdown
    const incomeCategories = data.income_categories.map(row => row.category);
    const incomeTotals = data.income_categories.map(row => parseFloat(row.total));  // Convert to number

    const incomePieChart = new Chart(document.getElementById('incomePieChart'), {
        type: 'pie',
        data: {
            labels: incomeCategories,
            datasets: [{
                data: incomeTotals,
                backgroundColor: [
                    "#fd7f6f", "#7eb0d5", "#b2e061", "#bd7ebe", 
                    "#ffb55a", "#ffee65", "#beb9db", "#fdcce5", "#8bd3c7"
                ],  
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // 3. Pie Chart – Expense Category Breakdown
    const expenseCategories = data.expense_categories.map(row => row.category);
    const expenseTotals = data.expense_categories.map(row => parseFloat(row.total));  // Convert to number

    const expensePieChart = new Chart(document.getElementById('expensePieChart'), {
        type: 'pie',
        data: {
            labels: expenseCategories,
            datasets: [{
                data: expenseTotals,
                backgroundColor: [
                    "#ea5545", "#f46a9b", "#ef9b20", "#edbf33", 
                    "#ede15b", "#bdcf32", "#87bc45", "#27aeef", "#b33dc6"
                ],
            }] 
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                        }
                    }
                }
            }
        }
    });

    // 4. Bar Chart – Monthly Summary (Income vs Expense by month)
    const monthlyPeriods = data.monthly_summary.map(row => row.period);
    const monthlyIncome = data.monthly_summary.map(row => parseFloat(row.income));  // Convert to number
    const monthlyExpense = data.monthly_summary.map(row => parseFloat(row.expense)); // Convert to number

    const breakdownChart = new Chart(document.getElementById('breakdownChart'), {
        type: 'bar',
        data: {
            labels: monthlyPeriods,
            datasets: [
                {
                    label: 'Income',
                    data: monthlyIncome,
                    backgroundColor: 'green',
                },
                {
                    label: 'Expense',
                    data: monthlyExpense,
                    backgroundColor: 'red',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw.toFixed(2);
                        }
                    }
                }
            }
        }
    });

  })
  .catch(error => {
    console.error('Error fetching data:', error);
  });
</script>
</html>