<?php
session_start();
include '../db_connection/db_connection.php';

function generateUniqueId($prefix = 'fp_') {
    return $prefix . uniqid(bin2hex(random_bytes(3)));
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = $_POST;

// Prepare data for insertion with proper null checks
$weekly_goals = isset($data['weekly_goals']) ? $data['weekly_goals'] : null;
$monthly_goals = isset($data['monthly_goals']) ? $data['monthly_goals'] : null;
$yearly_goals = isset($data['yearly_goals']) ? $data['yearly_goals'] : null;
$short_term_goals = isset($data['short_term_goals']) ? $data['short_term_goals'] : null;
$long_term_goals = isset($data['long_term_goals']) ? $data['long_term_goals'] : null;
$investment_interest = isset($data['investment_interest']) ? $data['investment_interest'] : null;
$risk_tolerance = isset($data['risk_tolerance']) ? $data['risk_tolerance'] : null;
$primary_income_source = isset($data['primary_income_source']) ? $data['primary_income_source'] : null;
$monthly_income = isset($data['monthly_income']) ? $data['monthly_income'] : null;
$passive_income = isset($data['passive_income']) ? $data['passive_income'] : null;
$expected_annual_growth = isset($data['expected_annual_growth']) ? $data['expected_annual_growth'] : null;
$tax_saving_investments = isset($data['tax_saving_investments']) ? $data['tax_saving_investments'] : null;
$fixed_expenses = isset($data['fixed_expenses']) ? $data['fixed_expenses'] : null;
$variable_expenses = isset($data['variable_expenses']) ? $data['variable_expenses'] : null;
$loans_emi = isset($data['loans_emi']) ? $data['loans_emi'] : null;
$credit_card_usage = isset($data['credit_card_usage']) ? $data['credit_card_usage'] : null;
$insurance_premiums = isset($data['insurance_premiums']) ? $data['insurance_premiums'] : null;
$utilities = isset($data['utilities']) ? $data['utilities'] : null;
$groceries = isset($data['groceries']) ? $data['groceries'] : null;
$transport = isset($data['transport']) ? $data['transport'] : null;
$entertainment = isset($data['entertainment']) ? $data['entertainment'] : null;
$healthcare = isset($data['healthcare']) ? $data['healthcare'] : null;
$gold = isset($data['gold']) ? $data['gold'] : null;
$fixed_deposits = isset($data['fixed_deposits']) ? $data['fixed_deposits'] : null;
$mutual_funds = isset($data['mutual_funds']) ? $data['mutual_funds'] : null;
$real_estate = isset($data['real_estate']) ? $data['real_estate'] : null;
$vehicles = isset($data['vehicles']) ? $data['vehicles'] : null;
$pan_number = isset($data['pan_number']) ? $data['pan_number'] : null;
$insurance_type = isset($data['insurance_type']) ? $data['insurance_type'] : null;
$annual_premium = isset($data['annual_premium']) ? $data['annual_premium'] : null;
$coverage_amount = isset($data['coverage_amount']) ? $data['coverage_amount'] : null;
$tags = isset($data['tags']) ? $data['tags'] : null;
$notes = isset($data['notes']) ? $data['notes'] : null;
$created_at = date("Y-m-d H:i:s");
$updated_at = date("Y-m-d H:i:s");

try {
    $conn->begin_transaction();

    // Check if profile exists
    $check_stmt = $conn->prepare("SELECT id FROM financial_profiles WHERE user_id = ?");
    $check_stmt->bind_param("s", $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();
    $profile_exists = $check_stmt->num_rows > 0;
    $check_stmt->close();

    if ($profile_exists) {
        // UPDATE existing profile
        $stmt = $conn->prepare("
    UPDATE financial_profiles SET
        weekly_goals = ?, monthly_goals = ?, yearly_goals = ?,
        short_term_goals = ?, long_term_goals = ?, investment_interest = ?, risk_tolerance = ?,
        primary_income_source = ?, monthly_income = ?, passive_income = ?, expected_annual_growth = ?, tax_saving_investments = ?,
        fixed_expenses = ?, variable_expenses = ?, loans_emi = ?, credit_card_usage = ?, insurance_premiums = ?,
        utilities = ?, groceries = ?, transport = ?, entertainment = ?, healthcare = ?,
        gold = ?, fixed_deposits = ?, mutual_funds = ?, real_estate = ?, vehicles = ?,
        pan_number = ?, insurance_type = ?, annual_premium = ?, coverage_amount = ?,
        tags = ?, notes = ?, updated_at = ?
    WHERE user_id = ?
");

$stmt->bind_param(
    "dddsssssddddddsssddddddssssssddssss",
    $weekly_goals, $monthly_goals, $yearly_goals,
    $short_term_goals, $long_term_goals, $investment_interest, $risk_tolerance, $primary_income_source,
    $monthly_income, $passive_income, $expected_annual_growth, $tax_saving_investments,
    $fixed_expenses, $variable_expenses, $loans_emi, $credit_card_usage, $insurance_premiums,
    $utilities, $groceries, $transport, $entertainment, $healthcare,
    $gold, $fixed_deposits, $mutual_funds, $real_estate, $vehicles,
    $pan_number, $insurance_type, $annual_premium, $coverage_amount,
    $tags, $notes, $updated_at, $user_id
);
        
    } else {
        // INSERT new profile
        $id = generateUniqueId();
        $stmt = $conn->prepare("
            INSERT INTO financial_profiles (
                id, user_id,
                weekly_goals, monthly_goals, yearly_goals,
                short_term_goals, long_term_goals, investment_interest, risk_tolerance,
                primary_income_source, monthly_income, passive_income, expected_annual_growth, tax_saving_investments,
                fixed_expenses, variable_expenses, loans_emi, credit_card_usage, insurance_premiums,
                utilities, groceries, transport, entertainment, healthcare,
                gold, fixed_deposits, mutual_funds, real_estate, vehicles,
                pan_number, insurance_type, annual_premium, coverage_amount,
                tags, notes, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssssssddssddssssddddddsssssssdsss",
            $id, $user_id,
            $weekly_goals, $monthly_goals, $yearly_goals,
            $short_term_goals, $long_term_goals, $investment_interest, $risk_tolerance,
            $primary_income_source, $monthly_income, $passive_income, $expected_annual_growth,
            $tax_saving_investments, $fixed_expenses, $variable_expenses, $loans_emi,
            $credit_card_usage, $insurance_premiums, $utilities, $groceries, $transport,
            $entertainment, $healthcare, $gold, $fixed_deposits, $mutual_funds,
            $real_estate, $vehicles, $pan_number, $insurance_type, $annual_premium,
            $coverage_amount, $tags, $notes, $created_at, $updated_at
        );
    }

    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error);
    }
    $stmt->close();

    // Update login details
    $update_stmt = $conn->prepare("UPDATE login_details SET intial_data_entry = 'YES' WHERE user_id = ?");
    $update_stmt->bind_param("s", $user_id);
    if (!$update_stmt->execute()) {
        throw new Exception("Failed to update login details: " . $update_stmt->error);
    }
    $update_stmt->close();

    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Financial profile saved successfully."]);
    header("Location: ../public_pages/dashboard.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    error_log("Financial Profile Error: " . $e->getMessage());
}
?>