create database spendly
use spendly

-- tables

TABLE sign_up (
    user_name VARCHAR(100) NOT NULL,
    user_email varchar(100) NOT NULL,
    user_id VARCHAR(50) NOT NULL primary key, -- Unique user identifier
    userpassword TEXT NOT NULL,  -- Store hashed passwords
    enkey TEXT NOT NULL,
    creation_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Auto-fills with current time
    creation_day VARCHAR(50) NOT NULL  -- Store day name separately
);



 TABLE login_details (

    user_id VARCHAR(50) NOT NULL PRIMARY KEY,  -- Unique user identifier
    login_count INT,
    intial_data_entry varchar(50) default "No",
    last_login_details TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login_day VARCHAR(20),  -- Stores the day like 'Monday', 'Tuesday', etc.
    FOREIGN KEY (user_id) REFERENCES sign_up(user_id)
);




TABLE transactions_dash (
    transaction_id varchar(50)  PRIMARY KEY,
    user_id varchar(50) NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    reason TEXT,
    category VARCHAR(100),
    timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    day VARCHAR(20) NOT NULL,
    previous_balance DECIMAL(10,2) DEFAULT 0,
    after_balance DECIMAL(10,2) DEFAULT 0,

    FOREIGN KEY (user_id) REFERENCES sign_up(user_id)
        ON DELETE CASCADE
);




TABLE user_balance (
    user_id VARCHAR(50) PRIMARY KEY,
    total_income DECIMAL(10,2) DEFAULT 0,
    total_expense DECIMAL(10,2) DEFAULT 0
);




 TABLE financial_profiles (
    id VARCHAR(50) PRIMARY KEY,
    user_id VARCHAR(50),
    
    -- Goals
    weekly_goals DECIMAL(10,2),
    monthly_goals DECIMAL(10,2),
    yearly_goals DECIMAL(10,2),
    short_term_goals TEXT,  -- Longer text
    long_term_goals TEXT,   -- Longer text
    investment_interest VARCHAR(255),  -- Short, fixed text
    risk_tolerance VARCHAR(50),  -- Short, fixed text

    -- Income
    primary_income_source TEXT,  -- Longer text
    monthly_income TEXT,         -- Text for potential large input
    passive_income DECIMAL(12,2),
    expected_annual_growth DECIMAL(5,2),
    tax_saving_investments TEXT,  -- Longer text

    -- Expenses
    fixed_expenses DECIMAL(12,2),
    variable_expenses DECIMAL(12,2),
    loans_emi TEXT,              -- Longer text
    credit_card_usage TEXT,      -- Longer text
    insurance_premiums TEXT,     -- Longer text

    -- Expense breakdown
    utilities DECIMAL(12,2),
    groceries DECIMAL(12,2),
    transport DECIMAL(12,2),
    entertainment DECIMAL(12,2),
    healthcare DECIMAL(12,2),

    -- Assets
    gold TEXT,                   -- Longer text
    fixed_deposits TEXT,         -- Longer text
    mutual_funds TEXT,           -- Longer text
    real_estate TEXT,            -- Longer text
    vehicles TEXT,               -- Longer text

    -- Insurance
    pan_number VARCHAR(20),
    insurance_type VARCHAR(50),
    annual_premium DECIMAL(12,2),
    coverage_amount DECIMAL(12,2),

    -- Extra
    tags TEXT,                   -- Longer text
    notes TEXT,                  -- Longer text

    created_at VARCHAR(255),     -- Store as VARCHAR since it's now textual
    updated_at VARCHAR(255),     -- Store as VARCHAR since it's now textual

    FOREIGN KEY (user_id) REFERENCES sign_up(user_id)
);






TABLE transactions (
    transaction_id VARCHAR(50) PRIMARY KEY,
    user_id varchar(50),
    purchase_amount DECIMAL(10, 2),
    purchase_plan VARCHAR(100),
    transaction_type ENUM('Purchase', 'Refund', 'Subscription') DEFAULT 'Purchase',
    payment_method VARCHAR(50),
    upi_id VARCHAR(100),
    masked_card_number VARCHAR(20),
    status ENUM('Success', 'Failed'),
    payment_ref_number VARCHAR(100),
    start_of_plan DATE,
    end_of_plan DATE,
    account_status ENUM('Active', 'Invalid'),
    is_recurring BOOLEAN DEFAULT FALSE,
    ip_address VARCHAR(45),
    device_info TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES sign_up(user_id)
);