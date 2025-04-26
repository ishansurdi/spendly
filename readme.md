# Spendly Project Documentation

| Project Name | Spendly - Personal Finance Tracker |
|--------------|------------------------------------|
|Project Type  | Academic                           |
|Academic Affiliation| Dr. Vishwanath Karad MIT - World Peace University, Pune (as on April 2025)|
| Difficulty   | Medium                             |
| Duration     | January 2025 - April 2025          |
| Developers   | [Ishan Surdi](https://github.com/ishansurdi)  |      
|              |[Vrushali Deshpande](https://github.com/709vrushali) |
|              |[Himanshu Pal](https://github.com/gabbar-singhh)|
|              |[Soham Borate](https://github.com/sam5808)|
|License       |[Apache License 2.0](https://github.com/ishansurdi/spendly/blob/main/LICENSE)
## Table of Contents
- [Spendly Project Documentation](#spendly-project-documentation)
  - [Table of Contents](#table-of-contents)
  - [Introduction](#introduction)
    - [Features](#features)
  - [Directory Structure](#directory-structure)
  - [Key Directories and Files](#key-directories-and-files)
    - [Backend Process](#backend-process)
    - [Public Pages](#public-pages)
    - [Styles](#styles)
  - [Database Tables](#database-tables)
    - [Table: `sign_up`](#table-sign_up)
    - [Table: `login_details`](#table-login_details)
    - [Table: `transactions_dash`](#table-transactions_dash)
    - [Table: `user_balance`](#table-user_balance)
    - [Table: `financial_profiles`](#table-financial_profiles)
    - [Table: `transactions`](#table-transactions)
  - [How to Set Up the Project](#how-to-set-up-the-project)
    - [Prerequisites](#prerequisites)
    - [Steps to Set Up](#steps-to-set-up)
  - [How to Use `email_with_python`](#how-to-use-email_with_python)
    - [Prerequisites:](#prerequisites-1)
      - [Steps to Install:](#steps-to-install)
      - [How to Get Email Credentials:](#how-to-get-email-credentials)
      - [How to Run:](#how-to-run)
      - [Expected Output:](#expected-output)
  - [How to Use `gemini-ai`](#how-to-use-gemini-ai)
    - [Prerequisites:](#prerequisites-2)
      - [Steps to Install:](#steps-to-install-1)
      - [How to Get API Key for Gemini AI:](#how-to-get-api-key-for-gemini-ai)
      - [How to Run:](#how-to-run-1)
      - [Expected Output:](#expected-output-1)
  - [File Logic and Descriptions](#file-logic-and-descriptions)
    - [Backend Process](#backend-process-1)
    - [Public Pages](#public-pages-1)
    - [Styles](#styles-1)
  - [FAQ and Troubleshooting](#faq-and-troubleshooting)
    - [Common Issues](#common-issues)
    - [Where to Get Help](#where-to-get-help)
  - [Acknowledgments](#acknowledgments)
  - [Contributing](#contributing)
  - [Need Help?](#need-help)

## Introduction
Spendly is a comprehensive financial management platform designed to help users:
- Track their expenses and income.
- Set and monitor financial goals.
- Gain insights into their spending habits.
- Generate detailed financial reports.

### Features
- **Expense and Income Tracking**: Log and categorize transactions.
- **Budget Management**: Set budgets and monitor progress.
- **AI-Powered Insights**: Use AI to analyze financial goals and provide recommendations.
- **Email Notifications**: Send automated email alerts for important updates.
- **User-Friendly Interface**: Intuitive design for seamless navigation.

## Directory Structure

The project is organized as follows:

```
spendly/
├── composer.json          # Composer dependencies
├── composer.lock          # Composer lock file
├── db-and-tables-file.sql # SQL file to set up the database
├── index.html             # Landing page
├── payment.html           # Payment page
├── readme.md              # Project documentation
├── assets/                # Static assets (images, icons, etc.)
│   ├── favicon.ico
│   ├── form-right.png
│   ├── hero-demo.png
│   ├── logo-circle-white.png
│   ├── logo-nav.png
│   ├── logo-signup.png
│   ├── logo-white.png
│   ├── spendly-plus.png
│   ├── spendly-pro.png
│   └── icons/             # Icons used in the application
│       ├── arrow-right-stretched.svg
│       ├── arrow-right.svg
│       ├── arrow-up-right.svg
│       ├── budget-icon.svg
│       ├── budget-tracking-icon.png
│       ├── chevron-left.svg
│       ├── chevron-right.svg
│       ├── circle-check.svg
│       ├── emoji-wave.png
│       ├── expense-management-icon.svg
│       ├── expense.svg
│       ├── feedback.svg
│       ├── goals.svg
│       ├── headset.svg
│       ├── help-icon.svg
│       ├── history-icon.svg
│       ├── home-icon.svg
│       ├── income.svg
│       ├── info.svg
│       ├── log-out-white.svg
│       ├── log-out.svg
│       ├── logout-icon.svg
│       ├── mail.svg
│       ├── map-pin.svg
│       ├── mastercard.png
│       ├── message.svg
│       ├── plus.svg
│       ├── question-icon.png
│       ├── report-icon.png
│       ├── report-info.svg
│       ├── reports.svg
│       ├── rocket.svg
│       ├── rupay.png
│       ├── savings-tracker-icon.png
│       ├── smart-insights-icon.svg
│       └── sparkles.svg
├── backend_process/       # Backend PHP scripts for processing data
│   ├── add_expense.php
│   ├── add_income_expense.php
│   ├── add_income.php
│   ├── email_error.log
│   ├── get_budget_data.php
│   ├── get_budget_history.php
│   ├── get_chart_data.php
│   ├── get_expense_summary.php
│   ├── get_income_summary.php
│   ├── history_db_process.php
│   ├── login_db_process.php
│   ├── logo-no-background.png
│   ├── logout_process.php
│   ├── process_payment.php
│   ├── questions_db_process.php
│   ├── save_budget.php
│   └── sign_up_db_process.php
├── db_connection/         # Database connection scripts
│   └── db_connection.php
├── email_with_python/     # Python scripts for email functionality
│   ├── credentials.json
│   ├── email_error.log
│   ├── email_sender.py
│   ├── logo-no-background.png
│   ├── requirement.txt
│   ├── send_email.py
│   └── token.json
├── gemini-ai/             # AI-based financial analysis tools
│   ├── analyze_financial_goals.py
│   ├── analyze_goals.php
│   ├── api-cred.json
│   ├── command.log
│   ├── data_for_python.json
│   ├── fetch_user_data.php
│   ├── input.json
│   └── python_output.log
├── generated_reports/     # Folder for storing generated reports
├── public_pages/          # Public-facing PHP pages
│   ├── Budget.php
│   ├── dashboard.php
│   ├── history.php
│   ├── login.php
│   ├── payment.php
│   ├── questions.php
│   ├── reports.php
│   ├── sign-up.php
│   └── Transaction.php
├── styles/                # CSS stylesheets
│   ├── Budget.css
│   ├── dashboard.css
│   ├── history.css
│   ├── index.css
│   ├── payment.css
│   ├── questions.css
│   ├── report.css
│   ├── sign-up.css
│   └── Transaction.css
├── testing/               # Testing scripts
│   └── get_income_expense_summary.php
└── vendor/                # Third-party dependencies (via Composer)
    ├── guzzlehttp/
    ├── league/
    ├── phpmailer/
    ├── psr/
    ├── ralouphie/
    └── symfony/
```

## Key Directories and Files

### Backend Process
- `add_expense.php`: Handles adding expense data to the database.
- `add_income.php`: Handles adding income data to the database.
- `get_budget_data.php`: Fetches budget-related data for the user.
- `process_payment.php`: Processes payment transactions.

### Public Pages
- `dashboard.php`: Displays the user dashboard with financial summaries.
- `login.php`: Handles user login functionality.
- `reports.php`: Displays financial reports for the user.

### Styles
- `index.css`: Styles for the landing page.
- `dashboard.css`: Styles for the user dashboard.

---

## Database Tables

You can directly execute the file: `db-and-tables-file.sql` to set up all the tables in the database.

### Table: `sign_up`
| Column Name          | Data Type         | Constraints                                      | Description                          |
|----------------------|-------------------|-------------------------------------------------|--------------------------------------|
| `user_name`          | VARCHAR(100)      | NOT NULL                                        | User's full name                     |
| `user_email`         | VARCHAR(100)      | NOT NULL                                        | User's email address                 |
| `user_id`            | VARCHAR(50)       | PRIMARY KEY                                     | Unique user identifier               |
| `userpassword`       | TEXT              | NOT NULL                                        | Stores hashed passwords              |
| `enkey`              | TEXT              | NOT NULL                                        | Encryption key for secure storage    |
| `creation_timestamp` | TIMESTAMP         | DEFAULT CURRENT_TIMESTAMP                       | Auto-fills with current time         |
| `creation_day`       | VARCHAR(50)       | NOT NULL                                        | Stores the day name separately       |

---

### Table: `login_details`
| Column Name          | Data Type         | Constraints                                      | Description                          |
|----------------------|-------------------|-------------------------------------------------|--------------------------------------|
| `user_id`            | VARCHAR(50)       | PRIMARY KEY, FOREIGN KEY REFERENCES `sign_up`   | Unique user identifier               |
| `login_count`        | INT               |                                                 | Number of logins                     |
| `intial_data_entry`  | VARCHAR(50)       | DEFAULT "No"                                    | Indicates if initial data is entered |
| `last_login_details` | TIMESTAMP         | DEFAULT CURRENT_TIMESTAMP                       | Timestamp of the last login          |
| `last_login_day`     | VARCHAR(20)       |                                                 | Stores the day like 'Monday', etc.   |

---

### Table: `transactions_dash`
| Column Name          | Data Type         | Constraints                                      | Description                          |
|----------------------|-------------------|-------------------------------------------------|--------------------------------------|
| `transaction_id`     | VARCHAR(50)       | PRIMARY KEY                                     | Unique transaction identifier        |
| `user_id`            | VARCHAR(50)       | FOREIGN KEY REFERENCES `sign_up` ON DELETE CASCADE | User associated with the transaction |
| `type`               | ENUM('income', 'expense') | NOT NULL                                    | Type of transaction                  |
| `amount`             | DECIMAL(10, 2)    | NOT NULL                                        | Transaction amount                   |
| `reason`             | TEXT              |                                                 | Reason for the transaction           |
| `category`           | VARCHAR(100)      |                                                 | Category of the transaction          |
| `timestamp`          | DATETIME          | DEFAULT CURRENT_TIMESTAMP                       | Timestamp of the transaction         |
| `day`                | VARCHAR(20)       | NOT NULL                                        | Day of the transaction               |
| `previous_balance`   | DECIMAL(10, 2)    | DEFAULT 0                                       | Balance before the transaction       |
| `after_balance`      | DECIMAL(10, 2)    | DEFAULT 0                                       | Balance after the transaction        |

---

### Table: `user_balance`
| Column Name          | Data Type         | Constraints                                      | Description                          |
|----------------------|-------------------|-------------------------------------------------|--------------------------------------|
| `user_id`            | VARCHAR(50)       | PRIMARY KEY                                     | Unique user identifier               |
| `total_income`       | DECIMAL(10, 2)    | DEFAULT 0                                       | Total income of the user             |
| `total_expense`      | DECIMAL(10, 2)    | DEFAULT 0                                       | Total expense of the user            |

---

### Table: `financial_profiles`
| Column Name          | Data Type         | Constraints                                      | Description                          |
|----------------------|-------------------|-------------------------------------------------|--------------------------------------|
| `id`                 | VARCHAR(50)       | PRIMARY KEY                                     | Unique profile identifier            |
| `user_id`            | VARCHAR(50)       | FOREIGN KEY REFERENCES `sign_up`               | User associated with the profile     |
| `weekly_goals`       | DECIMAL(10, 2)    |                                                 | Weekly financial goals               |
| `monthly_goals`      | DECIMAL(10, 2)    |                                                 | Monthly financial goals              |
| `yearly_goals`       | DECIMAL(10, 2)    |                                                 | Yearly financial goals               |
| `short_term_goals`   | TEXT              |                                                 | Short-term financial goals           |
| `long_term_goals`    | TEXT              |                                                 | Long-term financial goals            |
| `investment_interest`| VARCHAR(255)      |                                                 | Investment interests                 |
| `risk_tolerance`     | VARCHAR(50)       |                                                 | Risk tolerance level                 |
| `primary_income_source` | TEXT           |                                                 | Primary source of income             |
| `monthly_income`     | TEXT              |                                                 | Monthly income details               |
| `passive_income`     | DECIMAL(12, 2)    |                                                 | Passive income                       |
| `expected_annual_growth` | DECIMAL(5, 2) |                                                 | Expected annual growth percentage    |
| `tax_saving_investments` | TEXT          |                                                 | Tax-saving investments               |
| `fixed_expenses`     | DECIMAL(12, 2)    |                                                 | Fixed expenses                       |
| `variable_expenses`  | DECIMAL(12, 2)    |                                                 | Variable expenses                    |
| `loans_emi`          | TEXT              |                                                 | Loan EMIs                            |
| `credit_card_usage`  | TEXT              |                                                 | Credit card usage details            |
| `insurance_premiums` | TEXT              |                                                 | Insurance premium details            |
| `utilities`          | DECIMAL(12, 2)    |                                                 | Utility expenses                     |
| `groceries`          | DECIMAL(12, 2)    |                                                 | Grocery expenses                     |
| `transport`          | DECIMAL(12, 2)    |                                                 | Transport expenses                   |
| `entertainment`      | DECIMAL(12, 2)    |                                                 | Entertainment expenses               |
| `healthcare`         | DECIMAL(12, 2)    |                                                 | Healthcare expenses                  |
| `gold`               | TEXT              |                                                 | Gold assets                          |
| `fixed_deposits`     | TEXT              |                                                 | Fixed deposits                       |
| `mutual_funds`       | TEXT              |                                                 | Mutual funds                         |
| `real_estate`        | TEXT              |                                                 | Real estate assets                   |
| `vehicles`           | TEXT              |                                                 | Vehicle assets                       |
| `pan_number`         | VARCHAR(20)       |                                                 | PAN number                           |
| `insurance_type`     | VARCHAR(50)       |                                                 | Type of insurance                    |
| `annual_premium`     | DECIMAL(12, 2)    |                                                 | Annual insurance premium             |
| `coverage_amount`    | DECIMAL(12, 2)    |                                                 | Insurance coverage amount            |
| `tags`               | TEXT              |                                                 | Additional tags                      |
| `notes`              | TEXT              |                                                 | Additional notes                     |
| `created_at`         | VARCHAR(255)      |                                                 | Creation timestamp                   |
| `updated_at`         | VARCHAR(255)      |                                                 | Last updated timestamp               |

---

### Table: `transactions`
| Column Name          | Data Type         | Constraints                                      | Description                          |
|----------------------|-------------------|-------------------------------------------------|--------------------------------------|
| `transaction_id`     | VARCHAR(50)       | PRIMARY KEY                                     | Unique transaction identifier        |
| `user_id`            | VARCHAR(50)       | FOREIGN KEY REFERENCES `sign_up`               | User associated with the transaction |
| `purchase_amount`    | DECIMAL(10, 2)    |                                                 | Amount of the purchase               |
| `purchase_plan`      | VARCHAR(100)      |                                                 | Plan associated with the purchase    |
| `transaction_type`   | ENUM('Purchase', 'Refund', 'Subscription') | DEFAULT 'Purchase' | Type of transaction                  |
| `payment_method`     | VARCHAR(50)       |                                                 | Payment method used                  |
| `upi_id`             | VARCHAR(100)      |                                                 | UPI ID used for the transaction      |
| `masked_card_number` | VARCHAR(20)       |                                                 | Masked card number                   |
| `status`             | ENUM('Success', 'Failed') |                                         | Status of the transaction            |
| `payment_ref_number` | VARCHAR(100)      |                                                 | Payment reference number             |
| `start_of_plan`      | DATE              |                                                 | Start date of the plan               |
| `end_of_plan`        | DATE              |                                                 | End date of the plan                 |
| `account_status`     | ENUM('Active', 'Invalid') |                                         | Account status                       |
| `is_recurring`       | BOOLEAN           | DEFAULT FALSE                                   | Indicates if the transaction is recurring |
| `ip_address`         | VARCHAR(45)       |                                                 | IP address of the user               |
| `device_info`        | TEXT              |                                                 | Device information                   |
| `created_at`         | DATETIME          | DEFAULT CURRENT_TIMESTAMP                       | Creation timestamp                   |
| `updated_at`         | DATETIME          | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last updated timestamp |

---

## How to Set Up the Project

### Prerequisites

1. **Install XAMPP**:
   - Download XAMPP from [Apache Friends](https://www.apachefriends.org/).
   - Follow the installation instructions for your operating system.
   - During installation, select the components you need (ensure Apache and MySQL are selected).
   - After installation, open the XAMPP Control Panel and start the Apache and MySQL modules.
   - Access phpMyAdmin by navigating to `http://localhost/phpmyadmin` in your browser.

2. **Install Composer**:
   - Download Composer from [getcomposer.org](https://getcomposer.org/).
   - Run the installer and follow the instructions:
     - Ensure PHP is added to your system's PATH (Composer requires PHP to run).
     - During installation, the installer will detect your PHP installation.
   - Verify installation by running the following command in your terminal:
     ```bash
     composer --version
     ```

3. **Install Python**:
   - Download Python from [python.org](https://www.python.org/).
   - Ensure Python 3.7 or later is installed.
   - During installation, check the option to add Python to your system's PATH.
   - Verify installation by running:
     ```bash
     python --version
     ```

4. **Install Pip**:
   - Pip is included with Python installations. Verify by running:
     ```bash
     pip --version
     ```

5. **Set Up MySQL**:
   - Open phpMyAdmin from the XAMPP Control Panel.
   - Create a new database named `spendly`.
   - Import the `db-and-tables-file.sql` file to set up the required tables.

---

### Steps to Set Up

1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   cd spendly
   ```

2. **Install PHP Dependencies**:
   - Run the following command in the project root:
     ```bash
     composer install
     ```

3. **Set Up the Database**:
   - Import the SQL file into your MySQL database using phpMyAdmin or the MySQL CLI.
   - Update the database credentials in `db_connection/db_connection.php`.

4. **Set Up Email Functionality**:
   - Navigate to the `email_with_python` directory:
     ```bash
     cd email_with_python
     ```
   - Install Python dependencies:
     ```bash
     pip install -r requirement.txt
     ```
   - Obtain Gmail API credentials and place the `credentials.json` file in this directory.

5. **Set Up AI Functionality**:
   - Navigate to the `gemini-ai` directory:
     ```bash
     cd gemini-ai
     ```
   - Install Python dependencies:
     ```bash
     pip install -r requirement.txt
     ```
   - Obtain an API key from Google AI Studio and update `api-cred.json`.

6. **Run the Application**:
   - Place the project folder in the `htdocs` directory of XAMPP.
   - Start the Apache and MySQL modules in the XAMPP control panel.
   - Access the application in your browser at `http://localhost/spendly`.

---

## How to Use `email_with_python`

### Prerequisites:
1. **Python Installation**:
   - Ensure Python 3.7 or later is installed on your system.
   - Verify installation by running:
     ```bash
     python --version
     ```
2. **Pip Installation**:
   - Ensure `pip` (Python package manager) is installed.
   - Verify by running:
     ```bash
     pip --version
     ```

#### Steps to Install:
1. **Navigate to the Directory**:
   ```bash
   cd email_with_python
   ```
2. **Install Dependencies**:
   - Install the required Python libraries listed in `requirement.txt`:
     ```bash
     pip install -r requirement.txt
     ```

#### How to Get Email Credentials:
1. **Sign Up for Gmail API**:
   - Go to the [Google Cloud Console](https://console.cloud.google.com/).
   - Create a new project or select an existing one.
   - Navigate to `APIs & Services` > `Library` and enable the Gmail API.
   - Go to `Credentials` > `Create Credentials` > `OAuth 2.0 Client IDs`.
   - Download the `credentials.json` file.
2. **Update `credentials.json`**:
   - Place the downloaded `credentials.json` file in the `email_with_python` directory.

**Disclaimer**: Always refer to the [official Google Cloud documentation](https://cloud.google.com/docs) for the latest and most accurate instructions.

#### How to Run:
1. **Run the Script**:
   ```bash
   python send_email.py
   ```
2. **Error Logs**:
   - Check `email_error.log` for any issues during email sending.

#### Expected Output:
- Emails will be sent to the specified recipients.
- Logs will be generated in `email_error.log` for debugging.

---

## How to Use `gemini-ai`

### Prerequisites:
1. **Python Installation**:
   - Ensure Python 3.7 or later is installed on your system.
   - Verify installation by running:
     ```bash
     python --version
     ```
2. **Pip Installation**:
   - Ensure `pip` (Python package manager) is installed.
   - Verify by running:
     ```bash
     pip --version
     ```

#### Steps to Install:
1. **Navigate to the Directory**:
   ```bash
   cd gemini-ai
   ```
2. **Install Dependencies**:
   - Install the required Python libraries (e.g., `pandas`, `numpy`):
     ```bash
     pip install -r requirement.txt
     ```

#### How to Get API Key for Gemini AI:
1. **Sign Up for Google AI Services**:
   - Go to the [Google AI Studio](https://ai.google/studio/).
   - Create a new project or select an existing one.
   - Navigate to `APIs & Services` > `Library` and enable the relevant AI APIs (e.g., Natural Language API, Vision API).
   - Go to `Credentials` > `Create Credentials` > `API Key`.
   - Copy the generated API key.
2. **Update `api-cred.json`**:
   - Replace the placeholder values in `api-cred.json` with your actual API key.

**Disclaimer**: Always refer to the [official Google AI documentation](https://cloud.google.com/docs) for the latest and most accurate instructions.

#### How to Run:
1. **Prepare Input Data**:
   - Update `data_for_python.json` with the necessary input data.
2. **Run the Script**:
   ```bash
   python analyze_financial_goals.py
   ```
3. **Check Output**:
   - Review `python_output.log` for results.

#### Expected Output:
- Financial analysis results will be logged in `python_output.log`.
- The analysis can be integrated with the web application using `analyze_goals.php`.

---

## File Logic and Descriptions

### Backend Process
- `add_expense.php`: Handles adding expense data to the database.
- `add_income.php`: Handles adding income data to the database.
- `get_budget_data.php`: Fetches budget-related data for the user.
- `process_payment.php`: Processes payment transactions.

### Public Pages
- `dashboard.php`: Displays the user dashboard with financial summaries.
- `login.php`: Handles user login functionality.
- `reports.php`: Displays financial reports for the user.

### Styles
- `index.css`: Styles for the landing page.
- `dashboard.css`: Styles for the user dashboard.

---

## FAQ and Troubleshooting

### Common Issues
1. **Apache or MySQL Not Starting in XAMPP**:
   - Ensure no other application is using port 80 or 3306 (e.g., Skype).
   - Change the default ports in the XAMPP Control Panel settings if needed.

2. **Composer Not Recognized**:
   - Ensure PHP is added to your system's PATH.
   - Restart your terminal after installation.

3. **Python Script Errors**:
   - Verify that all dependencies are installed using `pip install -r requirement.txt`.
   - Check the logs (`email_error.log` or `python_output.log`) for specific error messages.

### Where to Get Help
- Refer to the [official documentation](https://www.apachefriends.org/) for XAMPP.
- Visit the [Composer documentation](https://getcomposer.org/doc/).
- Check the [Python documentation](https://docs.python.org/3/).

---

## Acknowledgments

We would like to thank:
- The open-source community for providing tools and libraries.
- [Apache Friends](https://www.apachefriends.org/) for XAMPP.
- [Composer](https://getcomposer.org/) for dependency management.
- [Google Cloud](https://cloud.google.com/) for APIs and services.

---

## Contributing
Refer to the original contribution guidelines in this document for steps to contribute to the project.

## Need Help?
If you encounter any issues or have questions, feel free to open an issue or contact the maintainers.
