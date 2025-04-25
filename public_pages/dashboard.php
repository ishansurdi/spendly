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
    <link rel="stylesheet" href="../styles/Transaction.css" />
    <link rel="stylesheet" href="/styles/questions.css" />
    <link rel="stylesheet" href="../styles/dashboard.css" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />

    <title>Home | Spendly</title>
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

    <section class="dashboard-body">
      <h2>
        <span>Welcome back,</span>
        <?= htmlspecialchars($full_name) ?>!
        <img
          src="../assests/icons/emoji-wave.png"
          alt="emoji wave"
          height="36px"
        />
      </h2>

      <div class="section-head">
        <h3>Quick Shortcuts</h3>
        <p>
          Essential shortcuts for seamless navigation throughout the Spendly app
          and dashboard, providing quick access to all key functionality.
        </p>
      </div>

      <div class="row-1">
        <a class="transaction-box" href="./Transaction.php">
          <div class="header">
            <h3>Transactions</h3>
            <img src="../assests/icons/transaction-icon.svg" alt="info icon" />
          </div>
          <div class="content">
            <p>
              Add income & recording expenses, or exploring visual analytics.
            </p>
          </div>
        </a>
        <a class="history-box" href="./history.php">
          <div class="header">
            <h3>History</h3>
            <img src="../assests/icons/history-icon.svg" alt="history icon" />
          </div>
          <div class="content">
            <p>View your complete transaction history of income/expense</p>
          </div>
        </a>
      </div>

      <div class="row-2">
        <div class="question-box" onclick="openDialog('modalOverlay')">
          <div>
            <h3>Update Financial Data</h3>
            <p>Review & update the financial data you first submitted</p>
          </div>
          <div class="question-img">
            <img
              src="../assests/icons/question-icon.png"
              alt="question icon"
              height="44px"
              width="44px"
            />
          </div>
        </div>
        <a class="report-box" href="./reports.php">
          <div class="header">
            <h3>Reports</h3>
            <img src="../assests/icons/reports.svg" alt="info icon" />
          </div>
          <div class="content">
            <p>
              Get AI-powered financial insights from Gemini that analyzes your
              transactions and data.
            </p>
          </div>
        </a>
        <a class="budget-box" href="./budget.php">
          <div class="header">
            <h3>Budget & Goals</h3>
            <img src="../assests/icons/goals.svg" alt="info icon" />
          </div>
          <div class="content">
            <p>
              Monitor your progress toward daily, weekly, and monthly financial
              goals.
            </p>
          </div>
        </a>
      </div>

      <div class="section-head">
        <h3>Other Settings</h3>
        <p>
          Need to update your plan, get help, or sign out? Manage it all from
          here.
        </p>
      </div>
      <div class="row-3">
        <div class="subscription-box" onclick="changeSubscription()">
          <div>
            <h3>Subscription Plan</h3>
            <p>Update your plan to match your usage</p>
          </div>
          <div class="subscription-img">
            <img
              src="../assests/icons/subscription.svg"
              alt="question icon"
              height="42px"
              width="42px"
            />
          </div>
        </div>
        <a class="help-box" href="/index.html#contact">
          <div>
            <h3>Need Help?</h3>
            <p>Questions or issues, Reach out to Spendly support</p>
          </div>
          <div class="help-img">
            <img
              src="../assests/icons/help-icon.svg"
              alt="feedback icon"
              height="42px"
              width="42px"
            />
          </div>
        </a>
        <a class="feedback-box" href="/index.html#contact">
          <div>
            <h3>Drop Feedback</h3>
            <p>Give feedback & help us get better</p>
          </div>
          <div class="feedback-img">
            <img
              src="../assests/icons/feedback.svg"
              alt="feedback icon"
              height="42px"
              width="42px"
            />
          </div>
        </a>
        <a class="logout-box" href="../backend_process/logout_process.php">
          <div>
            <h3>Logout</h3>
            <p>Logging out will end your current session securely.</p>
          </div>
          <div class="logout-img">
            <img
              src="../assests/icons/log-out-white.svg"
              alt="feedback icon"
              height="42px"
              width="42px"
            />
          </div>
        </a>
      </div>
    </section>

    <div class="modal" id="modalOverlay">
      <div class="modal-container">
        <section class="ques-main">
          <h2 class="ques-main-heading">Update Your Financial Data</h2>
          <div>
            <div id="multi-step-form-container">
              <!-- Form Steps / Progress Bar -->
              <ul class="form-stepper form-stepper-horizontal">
                <!-- Step 1 -->
                <li class="form-stepper-active form-stepper-list" step="1">
                  <a>
                    <span class="form-stepper-circle">
                      <span>1</span>
                    </span>
                    <div class="label">Goals</div>
                  </a>
                </li>
                <!-- Step 2 -->
                <li class="form-stepper-unfinished form-stepper-list" step="2">
                  <a>
                    <span class="form-stepper-circle text-muted">
                      <span>2</span>
                    </span>
                    <div class="label text-muted">Income</div>
                  </a>
                </li>
                <!-- Step 3 -->
                <li class="form-stepper-unfinished form-stepper-list" step="3">
                  <a>
                    <span class="form-stepper-circle text-muted">
                      <span>3</span>
                    </span>
                    <div class="label text-muted">
                      Dues <br />
                      & Cost
                    </div>
                  </a>
                </li>
                <!-- Step 4 -->
                <li class="form-stepper-unfinished form-stepper-list" step="4">
                  <a>
                    <span class="form-stepper-circle text-muted">
                      <span>4</span>
                    </span>
                    <div class="label text-muted">Budget</div>
                  </a>
                </li>
                <!-- Step 5 -->
                <li class="form-stepper-unfinished form-stepper-list" step="5">
                  <a>
                    <span class="form-stepper-circle text-muted">
                      <span>5</span>
                    </span>
                    <div class="label text-muted">Assets</div>
                  </a>
                </li>
                <!-- Step 6 -->
                <li class="form-stepper-unfinished form-stepper-list" step="6">
                  <a>
                    <span class="form-stepper-circle text-muted">
                      <span>6</span>
                    </span>
                    <div class="label text-muted">Taxes</div>
                  </a>
                </li>
                <!-- Step 7 -->
                <li class="form-stepper-unfinished form-stepper-list" step="7">
                  <a>
                    <span class="form-stepper-circle text-muted">
                      <span>7</span>
                    </span>
                    <div class="label text-muted">Final</div>
                  </a>
                </li>
              </ul>
              <!-- Step Wise Form Content -->
              <form
                id=""
                name=""
                action="../backend_process/questions_db_process.php"
                method="POST"
              >
                <!-- Step 1 Content -->
                <section id="step-1" class="form-step">
                  <h2 class="form-heading">Financial Goals</h2>
                  <div class="form-content">
                    <label>Weekly Financial Goals</label>
                    <input
                      type="number"
                      name="weekly_goals"
                      placeholder="e.g., Save ₹500 on groceries, skip ordering food"
                    />

                    <label>Monthly Financial Goals</label>
                    <input
                      type="number"
                      name="monthly_goals"
                      placeholder="e.g., Invest ₹5,000 in SIP, save ₹2,000 on outings"
                    />

                    <label>Yearly Financial Goals</label>
                    <input
                      type="number"
                      name="yearly_goals"
                      placeholder="e.g., Save ₹1.2L overall, build ₹50K emergency fund"
                    />

                    <label>Short-Term Goals (1-3 years)</label>
                    <input
                      type="text"
                      name="short_term_goals"
                      placeholder="e.g., Buy a two-wheeler, ₹80K for solo trip"
                    />

                    <label>Long-Term Goals (5+ years)</label>
                    <input
                      type="text"
                      name="long_term_goals"
                      placeholder="e.g., Buy a flat in Pune, ₹15L for higher studies"
                    />

                    <label>Investment Interests</label>
                    <select name="investment_interest">
                      <option>Stocks (NSE/BSE)</option>
                      <option>Mutual Funds</option>
                      <option>PPF/FD/LIC</option>
                      <option>Gold</option>
                    </select>

                    <label>Risk Tolerance</label>
                    <select name="risk_tolerance">
                      <option>Low (PPF, FD, LIC)</option>
                      <option>Medium (Mutual Funds)</option>
                      <option>High (Stocks, Crypto)</option>
                    </select>
                  </div>
                  <div class="form-buttons">
                    <button class="hide-btn">back</button>
                    <button
                      class="button btn-navigate-form-step"
                      type="button"
                      step_number="2"
                    >
                      <span>Continue</span>
                      <img
                        src="/assests/icons/arrow-right-stretched.svg"
                        height="11px"
                        width="auto"
                        alt=""
                      />
                    </button>
                  </div>
                </section>

                <!-- Step 2 -->
                <section id="step-2" class="form-step d-none">
                  <h2 class="form-heading">Income Details</h2>
                  <div class="form-content">
                    <label for="source">Primary Income Source</label>
                    <input
                      id="source"
                      name="primary_income_source"
                      type="text"
                      placeholder="e.g., Software job at TCS, freelance projects"
                    />

                    <label for="monthlyIncome">Monthly Income (in ₹)</label>
                    <input
                      id="monthlyIncome"
                      name="monthly_income"
                      type="text"
                      placeholder="e.g., ₹60,000"
                    />

                    <label for="passiveIncome"
                      >Monthly Passive Income (in ₹)</label
                    >
                    <input
                      id="passiveIncome"
                      name="passive_income"
                      type="number"
                      placeholder="e.g., ₹5,000 from FD interest or rent"
                    />

                    <label for="growth"
                      >Expected Annual Income Growth (in %)</label
                    >
                    <input
                      id="growth"
                      name="expected_annual_growth"
                      type="number"
                      placeholder="e.g., 8"
                    />

                    <label for="taxSaving"
                      >Tax-Saving Investments (80C/80D etc.)</label
                    >
                    <input
                      id="taxSaving"
                      name="tax_saving_investments"
                      type="text"
                      placeholder="e.g., ₹1.5L in PPF, ELSS, health insurance"
                    />
                  </div>
                  <div class="form-buttons">
                    <button
                      class="back-button button btn-navigate-form-step"
                      type="button"
                      step_number="1"
                    >
                      Go Back
                    </button>
                    <button
                      class="button btn-navigate-form-step"
                      type="button"
                      step_number="3"
                    >
                      <span>Continue</span>
                      <img
                        src="/assests/icons/arrow-right-stretched.svg"
                        height="11px"
                        width="auto"
                        alt=""
                      />
                    </button>
                  </div>
                </section>

                <!-- Step 3 -->
                <section id="step-3" class="form-step d-none">
                  <h2 class="form-heading">Expenses and Liabilities</h2>
                  <div class="form-content">
                    <label for="fixed">Fixed Monthly Expenses (in ₹)</label>
                    <input
                      type="number"
                      id="fixed"
                      name="fixed_expenses"
                      placeholder="e.g., ₹25,000 - rent, EMIs"
                    />

                    <label for="variable"
                      >Variable Monthly Expenses (in ₹)</label
                    >
                    <input
                      type="number"
                      id="variable"
                      name="variable_expenses"
                      placeholder="e.g., ₹10,000 - groceries, transport, shopping"
                    />

                    <label for="loan">Total Loans & EMI (in ₹)</label>
                    <input
                      type="text"
                      id="loan"
                      name="loans_emi"
                      placeholder="e.g., ₹5L home loan, ₹2L education loan"
                    />

                    <label for="credit"
                      >Credit Card Usage per Month (in ₹)</label
                    >
                    <input
                      type="text"
                      id="credit"
                      name="credit_card_usage"
                      placeholder="e.g., ₹12,000 on HDFC credit card"
                    />

                    <label for="insurance"
                      >Monthly Insurance Premiums (in ₹)</label
                    >
                    <input
                      type="text"
                      id="insurance"
                      name="insurance_premiums"
                      placeholder="e.g., ₹2,000 - term plan, health policy"
                    />
                  </div>
                  <div class="form-buttons">
                    <button
                      class="back-button button btn-navigate-form-step"
                      type="button"
                      step_number="2"
                    >
                      Go Back
                    </button>
                    <button
                      class="button btn-navigate-form-step"
                      type="button"
                      step_number="4"
                    >
                      <span>Continue</span>
                      <img
                        src="/assests/icons/arrow-right-stretched.svg"
                        height="11px"
                        width="auto"
                        alt=""
                      />
                    </button>
                  </div>
                </section>

                <!-- Step 4 -->
                <section id="step-4" class="form-step d-none">
                  <h2 class="form-heading">Budget Allocation</h2>
                  <div class="form-content">
                    <label for="utilities"
                      >Utilities (Electricity, Water, Gas) (in ₹)</label
                    >
                    <input
                      type="number"
                      id="utilities"
                      name="utilities"
                      placeholder="e.g., ₹2,000 – MSEB bill, cylinder, water"
                    />

                    <label for="groceries">Groceries (in ₹)</label>
                    <input
                      type="number"
                      id="groceries"
                      name="groceries"
                      placeholder="e.g., ₹5,000 – fruits, vegetables, staples"
                    />

                    <label for="transport">Transport & Fuel (in ₹)</label>
                    <input
                      type="number"
                      id="transport"
                      name="transport"
                      placeholder="e.g., ₹3,000 – petrol, cab rides"
                    />

                    <label for="entertainment"
                      >Entertainment & Subscriptions (in ₹)</label
                    >
                    <input
                      type="number"
                      id="entertainment"
                      name="entertainment"
                      placeholder="e.g., ₹1,000 – Netflix, Spotify, weekend outings"
                    />

                    <label for="healthcare"
                      >Healthcare & Medicines (in ₹)</label
                    >
                    <input
                      type="number"
                      id="healthcare"
                      name="healthcare"
                      placeholder="e.g., ₹800 – regular checkups, monthly meds"
                    />
                  </div>
                  <div class="form-buttons">
                    <button
                      class="back-button button btn-navigate-form-step"
                      type="button"
                      step_number="3"
                    >
                      Go Back
                    </button>
                    <button
                      class="button btn-navigate-form-step"
                      type="button"
                      step_number="5"
                    >
                      <span>Continue</span>
                      <img
                        src="/assests/icons/arrow-right-stretched.svg"
                        height="11px"
                        width="auto"
                        alt=""
                      />
                    </button>
                  </div>
                </section>

                <!-- Step 5 -->
                <section id="step-5" class="form-step d-none">
                  <h2 class="form-heading">Assets and Net Worth</h2>
                  <div class="form-content">
                    <label for="gold">Gold (in ₹)</label>
                    <input
                      type="text"
                      id="gold"
                      name="gold"
                      placeholder="e.g., ₹1.5L – Gold ornaments & coins"
                    />

                    <label for="fd">Fixed Deposits (in ₹)</label>
                    <input
                      type="text"
                      id="fd"
                      name="fixed_deposits"
                      placeholder="e.g., ₹2L – Fixed deposit"
                    />

                    <label for="mutual">Mutual Funds (in ₹)</label>
                    <input
                      type="text"
                      id="mutual"
                      name="mutual_funds"
                      placeholder="e.g., ₹75,000 – Axis Bluechip SIP"
                    />

                    <label for="realestate">Real Estate (in ₹)</label>
                    <input
                      type="text"
                      id="realestate"
                      name="real_estate"
                      placeholder="e.g., ₹40L – Flat in Pune"
                    />

                    <label for="vehicles">Vehicles (in ₹)</label>
                    <input
                      type="text"
                      id="vehicles"
                      name="vehicles"
                      placeholder="e.g., ₹1.2L – bike, ₹6L – car"
                    />
                  </div>
                  <div class="form-buttons">
                    <button
                      class="back-button button btn-navigate-form-step"
                      type="button"
                      step_number="4"
                    >
                      Go Back
                    </button>
                    <button
                      class="button btn-navigate-form-step"
                      type="button"
                      step_number="6"
                    >
                      <span>Continue</span>
                      <img
                        src="/assests/icons/arrow-right-stretched.svg"
                        height="11px"
                        width="auto"
                        alt=""
                      />
                    </button>
                  </div>
                </section>

                <!-- Step 6 -->
                <section id="step-6" class="form-step d-none">
                  <h2 class="form-heading">Tax and Insurance Information</h2>
                  <div class="form-content">
                    <label for="pan">PAN Number</label>
                    <input
                      type="text"
                      id="pan"
                      name="pan_number"
                      placeholder="ABCDE1234F"
                    />

                    <label for="insurance-type">Insurance Type</label>
                    <select id="insurance-type" name="insurance_type">
                      <option value="">Select insurance type</option>
                      <option value="term">Term Life Insurance</option>
                      <option value="health">Health Insurance</option>
                      <option value="ulip">
                        ULIP (Unit Linked Insurance Plan)
                      </option>
                      <option value="vehicle">Vehicle Insurance</option>
                    </select>

                    <label for="premium">Annual Premium (in ₹)</label>
                    <input
                      type="number"
                      id="premium"
                      name="annual_premium"
                      placeholder="e.g., ₹10,000 per year"
                    />

                    <label for="coverage">Coverage Amount (in ₹)</label>
                    <input
                      type="number"
                      id="coverage"
                      name="coverage_amount"
                      placeholder="e.g., ₹10L coverage for term plan"
                    />
                  </div>
                  <div class="form-buttons">
                    <button
                      class="back-button button btn-navigate-form-step"
                      type="button"
                      step_number="5"
                    >
                      Go Back
                    </button>
                    <button
                      class="button btn-navigate-form-step"
                      type="button"
                      step_number="7"
                    >
                      <span>Continue</span>
                      <img
                        src="/assests/icons/arrow-right-stretched.svg"
                        height="11px"
                        width="auto"
                        alt=""
                      />
                    </button>
                  </div>
                </section>

                <!-- Step 7 -->
                <section id="step-7" class="form-step d-none">
                  <h2 class="form-heading">Custom Tags and Additional Notes</h2>
                  <div class="form-content">
                    <label for="tags">Tags (separate by commas)</label>
                    <input
                      type="text"
                      id="tags"
                      name="tags"
                      placeholder="e.g., NRI, Freelancer, Family Support"
                    />

                    <label for="notes">Additional Notes</label>
                    <textarea
                      id="notes"
                      name="notes"
                      placeholder="e.g., Supporting sibling’s education, planning to study abroad"
                    ></textarea>
                  </div>
                  <div class="form-buttons">
                    <button
                      class="back-button button btn-navigate-form-step"
                      type="button"
                      step_number="6"
                    >
                      Go Back
                    </button>
                    <button class="button submit-btn" type="submit">
                      UPDATE
                    </button>
                  </div>
                </section>
              </form>
            </div>
          </div>
        </section>
      </div>
    </div>
  </body>
  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById("dashboard-dropdown");
      dropdown.classList.toggle("hidden");
      console.log("first");
    }
    function changeSubscription() {
      window.location.href = "../public_pages/payment.php";
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
    // Open any dialog by ID
    function openDialog(id) {
      document.getElementById(id).style.display = "flex";
    }

    // Close any dialog by ID
    function closeDialog(id) {
      document.getElementById(id).style.display = "none";
    }

    // Hide all modals on page load
    window.onload = function () {
      const modals = document.querySelectorAll(".modal");
      modals.forEach((modal) => (modal.style.display = "none"));

      const msg = document.getElementById("statusMessage");
      if (msg) {
        setTimeout(() => {
          msg.style.display = "none";
        }, 3000); // Hide message after 3 seconds
      }
    };
  </script>

  <!-- FUNCTION OF MODAL (UPDATE FINANCIAL DATA) -->
  <script>
    // form
    /**
     * Define a function to navigate betweens form steps.
     * It accepts one parameter. That is - step number.
     */
    const navigateToFormStep = (stepNumber) => {
      /**
       * Hide all form steps.
       */
      document.querySelectorAll(".form-step").forEach((formStepElement) => {
        formStepElement.classList.add("d-none");
      });
      /**
       * Mark all form steps as unfinished.
       */
      document
        .querySelectorAll(".form-stepper-list")
        .forEach((formStepHeader) => {
          formStepHeader.classList.add("form-stepper-unfinished");
          formStepHeader.classList.remove(
            "form-stepper-active",
            "form-stepper-completed"
          );
        });
      /**
       * Show the current form step (as passed to the function).
       */
      document.querySelector("#step-" + stepNumber).classList.remove("d-none");
      /**
       * Select the form step circle (progress bar).
       */
      const formStepCircle = document.querySelector(
        'li[step="' + stepNumber + '"]'
      );
      /**
       * Mark the current form step as active.
       */
      formStepCircle.classList.remove(
        "form-stepper-unfinished",
        "form-stepper-completed"
      );
      formStepCircle.classList.add("form-stepper-active");
      /**
       * Loop through each form step circles.
       * This loop will continue up to the current step number.
       * Example: If the current step is 3,
       * then the loop will perform operations for step 1 and 2.
       */
      for (let index = 0; index < stepNumber; index++) {
        /**
         * Select the form step circle (progress bar).
         */
        const formStepCircle = document.querySelector(
          'li[step="' + index + '"]'
        );
        /**
         * Check if the element exist. If yes, then proceed.
         */
        if (formStepCircle) {
          /**
           * Mark the form step as completed.
           */
          formStepCircle.classList.remove(
            "form-stepper-unfinished",
            "form-stepper-active"
          );
          formStepCircle.classList.add("form-stepper-completed");
        }
      }
    };
    /**
     * Select all form navigation buttons, and loop through them.
     */
    document
      .querySelectorAll(".btn-navigate-form-step")
      .forEach((formNavigationBtn) => {
        /**
         * Add a click event listener to the button.
         */
        formNavigationBtn.addEventListener("click", () => {
          /**
           * Get the value of the step.
           */
          const stepNumber = parseInt(
            formNavigationBtn.getAttribute("step_number")
          );
          /**
           * Call the function to navigate to the target form step.
           */
          navigateToFormStep(stepNumber);
        });
      });
  </script>

  <script>
    // UPDATE THESE VALUES TO SEE UPDATION OF VALUES IN FORM
    const savedData = {
      weekly_goals: 500,
      monthly_goals: 5000,
      yearly_goals: 120000,
      short_term_goals: "Buy a two-wheeler",
      long_term_goals: "Buy a flat in Pune",
      investment_interest: "Mutual Funds",
      risk_tolerance: "Medium (Mutual Funds)",

      primary_income_source: "Software engineer at netflix",
      monthly_income: 100000,
      passive_income: 10000,
      expected_annual_growth: 8,
      tax_saving_investments: "₹5L in PPF",

      fixed_expenses: 25000,
      variable_expenses: 11000,
      loans_emi: "₹2L home loan",
      credit_card_usage: "₹5000 in hdfc credit card",
      insurance_premiums: "₹4000 - LIC",

      utilities: 3000,
      groceries: 3500,
      transport: 2000,
      entertainment: 1500,
      healthcare: 2000,

      gold: "₹1.5L – Gold ornaments",
      fixed_deposits: "₹1.2L – Fixed deposit",
      mutual_funds: "₹15,000 – Axis Bluechip SIP",
      real_estate: "₹60L – Flat in mumbai",
      vehicles: "₹8L car",

      pan_number: "QWERT9876X",
      insurance_type: "health",
      annual_premium: 12000,
      coverage_amount: 7000,

      tags: "FAMILY, MONEY, HAPPY, FREEDOM, BYE",
      notes: "THIS IS A NOTE HAHHAHH",
    };

    for (const key in savedData) {
      const field = document.querySelector(`[name="${key}"]`);
      if (!field) continue;

      let value = savedData[key];

      if (typeof value === "boolean") {
        value = value ? "Yes" : "No";
      }

      if (Array.isArray(value)) {
        value = value.join(", ");
      }

      field.value = value;
    }
  </script>
</html>
