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

    <title>Dashboard | Spendly</title>
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
          <a href="/dashboard.html">
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
          <a href="/dashboard/transaction.html">
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
          <a href="#">
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
          <a href="#">
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

          <div class="visual-container">
            <div class="box box-1">graph 1</div>
            <div class="box box-2">graph 2</div>
            <div class="box box-3">graph 3</div>
            <div class="box box-4">graph 4</div>
          </div>

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

          <label for="source" class="add-form-label">Source</label>
          <select name="source" required class="add-form-field">
            <option value="" disabled selected hidden>Select</option>
            <option value="salary">Salary</option>
            <option value="freelance">Freelance</option>
            <option value="business">Business</option>
            <option value="investments">Investments</option>
            <option value="gift">Gift</option>
            <option value="food">Food</option>
            <option value="transport">Transport</option>
            <option value="shopping">Shopping</option>
            <option value="rent">Rent</option>
            <option value="utilities">Utilities</option>
            <option value="healthcare">Healthcare</option>
            <option value="entertainment">Entertainment</option>
            <option value="travel">Travel</option>
            <option value="education">Education</option>
            <option value="insurance">Insurance</option>
            <option value="savings">Savings</option>
            <option value="other">Other</option>
            
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

</html>