<?php
// analyze_goals.php
header("Content-Type: application/json");

// Read the input JSON from the request body
$input = file_get_contents("php://input");

// Optionally, log the input to a file for debugging
file_put_contents("input.json", $input);

// Ensure the input is valid JSON
$data = json_decode($input, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Invalid JSON data received"]);
    exit;
}

// Write the JSON data to a file for the Python script (optional, for debugging purposes)
file_put_contents('data_for_python.json', json_encode($data));

// Prepare the shell command to run the Python script (use 'python' instead of 'python3')
$command = escapeshellcmd("python analyze_financial_goals.py data_for_python.json");

// Execute the command and capture the output
$output = shell_exec($command);

// Check if the output is null or not, indicating failure
if ($output === null) {
    echo json_encode(["error" => "Failed to run analysis"]);
} else {
    echo $output; // Return the analysis result from the Python script
}
?>
