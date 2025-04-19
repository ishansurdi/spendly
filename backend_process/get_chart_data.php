<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public_pages/login.php");
    exit();
}

include '../db_connection/db_connection.php';

$user_id = $_SESSION['user_id']; // <-- This line is essential

$data = [
    "line_chart" => [],
    "income_categories" => [],
    "expense_categories" => [],
    "monthly_summary" => []
];

// 1. Line Chart – Income vs Expense Over Time (grouped by day)
$query1 = "
    SELECT 
        DATE_FORMAT(timestamp, '%Y-%m-%d') AS period,
        SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS income,
        SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS expense
    FROM transactions
    WHERE user_id = ?
    GROUP BY period
    ORDER BY period
";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("s", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
while ($row = $result1->fetch_assoc()) {
    $data["line_chart"][] = $row;
}
$stmt1->close();

// 2. Pie Chart – Income Category Breakdown
$query2 = "
    SELECT category, SUM(amount) AS total
    FROM transactions
    WHERE user_id = ? AND type = 'income'
    GROUP BY category
";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("s", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
while ($row = $result2->fetch_assoc()) {
    $data["income_categories"][] = $row;
}
$stmt2->close();

// 3. Pie Chart – Expense Category Breakdown
$query3 = "
    SELECT category, SUM(amount) AS total
    FROM transactions
    WHERE user_id = ? AND type = 'expense'
    GROUP BY category
";
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("s", $user_id);
$stmt3->execute();
$result3 = $stmt3->get_result();
while ($row = $result3->fetch_assoc()) {
    $data["expense_categories"][] = $row;
}
$stmt3->close();

// ✅ 4. Bar Chart – Monthly Summary (use monthly grouping here!)
$query4 = "
    SELECT 
        DATE_FORMAT(timestamp, '%Y-%m') AS period,
        SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS income,
        SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS expense
    FROM transactions
    WHERE user_id = ?
    GROUP BY period
    ORDER BY period
";
$stmt4 = $conn->prepare($query4);
$stmt4->bind_param("s", $user_id);
$stmt4->execute();
$result4 = $stmt4->get_result();
while ($row = $result4->fetch_assoc()) {
    $data["monthly_summary"][] = $row;
}
$stmt4->close();

// Output as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
