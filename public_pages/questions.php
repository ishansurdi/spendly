<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- FAVICON -->
    <link rel="icon" href="./assests/favicon.ico" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/dashboard.css" />
    <link rel="stylesheet" href="../styles/questions.css" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&display=swap"
      rel="stylesheet"
    />

    <title>Set Up Your Money Profile | Spendly</title>
  </head>
  <body>
    <!-- Navigation Menu Bar -->
    <nav class="dashboard-nav-main">
      <div class="dashboard-items">
        <div class="user-dropdown-wrapper">
          <div class="dashboard-items-user" onclick="toggleDropdown()">
            <p class="username">Himanshu Pal</p>
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
                <span>himanshu@gmail.com</span>
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

    <!--  -->
    <section class="ques-main">
      <h2 class="ques-main-heading">Let's Talk About Your Money!</h2>
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
          <form id="" name="" enctype="" method="POST">
            <!-- Step 1 Content -->
            <section id="step-1" class="form-step">
              <h2 class="form-heading">Financial Goals</h2>
              <!-- Step 1 input fields -->

              <div class="form-content">
                <label>Weekly Financial Goals</label>
                <input
                  type="text"
                  placeholder="e.g., Save ₹500 on groceries, skip ordering food"
                />

                <label>Monthly Financial Goals</label>
                <input
                  type="text"
                  placeholder="e.g., Invest ₹5,000 in SIP, save ₹2,000 on outings"
                />

                <label>Yearly Financial Goals</label>
                <input
                  type="text"
                  placeholder="e.g., Save ₹1.2L overall, build ₹50K emergency fund"
                />

                <label>Short-Term Goals (1-3 years)</label>
                <input
                  type="text"
                  placeholder="e.g., Buy a two-wheeler, ₹80K for solo trip"
                />

                <label>Long-Term Goals (5+ years)</label>
                <input
                  type="text"
                  placeholder="e.g., Buy a flat in Pune, ₹15L for higher studies"
                />

                <label>Investment Interests</label>
                <select>
                  <option>Stocks (NSE/BSE)</option>
                  <option>Mutual Funds</option>
                  <option>PPF/FD/LIC</option>
                  <option>Gold</option>
                </select>

                <label>Risk Tolerance</label>
                <select>
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
            <!-- Step 2 Content, default hidden on page load. -->
            <section id="step-2" class="form-step d-none">
              <h2 class="form-heading">Income Details</h2>
              <!-- Step 2 input fields -->
              <div class="form-content">
                <label for="source">Primary Income Source</label>
                <input
                  id="source"
                  type="text"
                  placeholder="e.g., Software job at TCS, freelance projects"
                />

                <label for="monthlyIncome">Monthly Income (in ₹)</label>
                <input
                  id="monthlyIncome"
                  type="number"
                  placeholder="e.g., ₹60,000"
                />

                <label for="passiveIncome">Monthly Passive Income (in ₹)</label>
                <input
                  id="passiveIncome"
                  type="text"
                  placeholder="e.g., ₹5,000 from FD interest or rent"
                />

                <label for="growth">Expected Annual Income Growth (in %)</label>
                <input id="growth" type="number" placeholder="e.g., 8" />

                <label for="taxSaving"
                  >Tax-Saving Investments (80C/80D etc.)</label
                >
                <input
                  id="taxSaving"
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
            <!-- Step 3 Content, default hidden on page load. -->
            <section id="step-3" class="form-step d-none">
              <h2 class="form-heading">Expenses and Liabilities</h2>
              <!-- Step 3 input fields -->
              <div class="form-content">
                <label for="fixed">Fixed Monthly Expenses (in ₹)</label>
                <input
                  type="number"
                  id="fixed"
                  placeholder="e.g., ₹25,000 - rent, EMIs"
                />

                <label for="variable">Variable Monthly Expenses (in ₹)</label>
                <input
                  type="number"
                  id="variable"
                  placeholder="e.g., ₹10,000 - groceries, transport, shopping"
                />

                <label for="loan">Total Loans & EMI (in ₹)</label>
                <input
                  type="number"
                  id="loan"
                  placeholder="e.g., ₹5L home loan, ₹2L education loan"
                />

                <label for="credit">Credit Card Usage per Month (in ₹)</label>
                <input
                  type="number"
                  id="credit"
                  placeholder="e.g., ₹12,000 on HDFC credit card"
                />

                <label for="insurance">Monthly Insurance Premiums (in ₹)</label>
                <input
                  type="number"
                  id="insurance"
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
            <!-- Step 4 Content, default hidden on page load. -->
            <section id="step-4" class="form-step d-none">
              <h2 class="form-heading">Budget Allocation</h2>
              <!-- Step 4 input fields -->
              <div class="form-content">
                <label for="utilities"
                  >Utilities (Electricity, Water, Gas) (in ₹)</label
                >
                <input
                  type="number"
                  id="utilities"
                  placeholder="e.g., ₹2,000 – MSEB bill, cylinder, water"
                />

                <label for="groceries">Groceries (in ₹)</label>
                <input
                  type="number"
                  id="groceries"
                  placeholder="e.g., ₹5,000 – fruits, vegetables, staples"
                />

                <label for="transport">Transport & Fuel (in ₹)</label>
                <input
                  type="number"
                  id="transport"
                  placeholder="e.g., ₹3,000 – petrol, cab rides"
                />

                <label for="entertainment"
                  >Entertainment & Subscriptions (in ₹)</label
                >
                <input
                  type="number"
                  id="entertainment"
                  placeholder="e.g., ₹1,000 – Netflix, Spotify, weekend outings"
                />

                <label for="healthcare">Healthcare & Medicines (in ₹)</label>
                <input
                  type="number"
                  id="healthcare"
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
            <!-- Step 5 Content, default hidden on page load. -->
            <section id="step-5" class="form-step d-none">
              <h2 class="form-heading">Assets and Net Worth</h2>
              <!-- Step 5 input fields -->
              <div class="form-content">
                <label for="gold">Gold (in ₹)</label>
                <input
                  type="number"
                  id="gold"
                  placeholder="e.g., ₹1.5L – Gold ornaments & coins"
                />

                <label for="fd">Fixed Deposits (in ₹)</label>
                <input
                  type="number"
                  id="fd"
                  placeholder="e.g., ₹2L – Fixed deposit"
                />

                <label for="mutual">Mutual Funds (in ₹)</label>
                <input
                  type="number"
                  id="mutual"
                  placeholder="e.g., ₹75,000 – Axis Bluechip SIP"
                />

                <label for="realestate">Real Estate (in ₹)</label>
                <input
                  type="number"
                  id="realestate"
                  placeholder="e.g., ₹40L – Flat in Pune"
                />

                <label for="vehicles">Vehicles (in ₹)</label>
                <input
                  type="number"
                  id="vehicles"
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
            <!-- Step 6 Content, default hidden on page load. -->
            <section id="step-6" class="form-step d-none">
              <h2 class="form-heading">Tax and Insurance Information</h2>
              <!-- Step 6 input fields -->
              <div class="form-content">
                <label for="pan">PAN Number</label>
                <input type="text" id="pan" placeholder="ABCDE1234F" />

                <label for="insurance-type">Insurance Type</label>
                <select id="insurance-type">
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
                  placeholder="e.g., ₹10,000 per year"
                />

                <label for="coverage">Coverage Amount (in ₹)</label>
                <input
                  type="number"
                  id="coverage"
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
            <!-- Step 7 Content, default hidden on page load. -->
            <section id="step-7" class="form-step d-none">
              <h2 class="form-heading">Custom Tags and Additional Notes</h2>
              <!-- Step 7 input fields -->
              <div class="form-content">
                <label for="tags">Tags (separate by commas)</label>
                <input
                  type="text"
                  id="tags"
                  placeholder="e.g., NRI, Freelancer, Family Support"
                />

                <label for="notes">Additional Notes</label>
                <textarea
                  id="notes"
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
                <button class="button submit-btn" type="submit">Submit</button>
              </div>
            </section>
          </form>
        </div>
      </div>
    </section>
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
</html>
