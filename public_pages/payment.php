<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>⚠️ No user session found. Please sign up or log in first.</p>";
    exit();
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Spendly — Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .logo-img { height: 24px; margin-right: 8px; display: inline-block; vertical-align: middle; }
  </style>
</head>
<body class="bg-gradient-to-tr from-indigo-50 to-white min-h-screen flex items-center justify-center p-6">

  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl border border-gray-200 p-6">
    <div class="grid md:grid-cols-2 gap-6">

      <!-- LEFT SECTION: User + Plan -->
      <div class="space-y-6 border-r border-gray-200 pr-6">
        <div class="text-left space-y-1">
          <h1 class="text-3xl font-extrabold text-indigo-700">Spendly — Payment</h1>
          <p class="text-sm text-gray-500">Complete your plan upgrade with a dummy payment.</p>
        </div>

        <div class="text-sm text-gray-700">
          <strong>User ID:</strong> <span class="text-gray-800"><?php echo htmlspecialchars($user_id); ?></span>
        </div>

        <!-- Plan Selection -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Select Your Plan</label>
          <select name="purchase_plan" id="purchase_plan" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400" required onchange="updateAmount()">
            <option value="" disabled selected>-- Choose your plan --</option>
            <option value="Free">Free</option>
            <option value="Plus">Plus</option>
            <option value="Premium">Premium</option>
          </select>
          <div id="price_info" class="text-sm text-gray-600 mt-2"></div>
        </div>

        <input type="hidden" name="purchase_amount" id="purchase_amount" value="0">
      </div>

      <!-- RIGHT SECTION: Payment -->
      <form action="../backend_process/process_payment.php" method="POST" class="space-y-6">
        <!-- Payment Method Selection -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
          <select id="payment_method" name="payment_method" onchange="togglePaymentFields()" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400" required>
            <option value="" disabled selected>-- Choose payment mode --</option>
            <option value="UPI">UPI</option>
            <option value="Card">Debit Card</option>
          </select>
        </div>

        <!-- UPI Input -->
        <div id="upi_section" class="hidden">
          <label class="block text-sm font-medium text-gray-700 mb-1">Enter UPI ID</label>
          <div class="flex items-center space-x-2">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/UPI-Logo-vector.svg/1024px-UPI-Logo-vector.svg.png" alt="UPI" class="logo-img">
            <input type="text" name="upi_id" placeholder="e.g., user@upi" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400">
          </div>
        </div>

        <!-- Card Input -->
        <div id="card_section" class="hidden space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
            <div class="flex items-center space-x-2">
              <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" class="logo-img" alt="Mastercard">
              <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_2021.svg" class="logo-img" alt="Visa">
              <input type="text" name="debit_card" maxlength="16" placeholder="Enter 16-digit card number" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400" />
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
            <input type="password" name="cvv" maxlength="3" placeholder="e.g., 123" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400" />
          </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
          Confirm & Pay
        </button>

        <!-- Disclaimer -->
        <div class="text-xs text-gray-500 border-t pt-4 leading-relaxed">
          <p><strong>⚠️ Disclaimer:</strong></p>
          <ul class="list-disc list-inside mt-2 space-y-1">
            <li>This portal is intended solely for <strong>demonstration, testing, and educational purposes</strong> and is not a legitimate financial transaction service.</li>
            <li>No <strong>real payments</strong> are processed or recorded. All transactions are simulated and for testing purposes only.</li>
            <li>Visual representations of payment methods, including but not limited to <strong>UPI, Mastercard, and Visa logos</strong>, are used exclusively for illustrative purposes and do not represent actual payment options.</li>
            <li>Any data entered during this process, including but not limited to <strong>payment method details, user information, or transaction data</strong>, will not be stored or processed beyond the scope of this demonstration.</li>
            <li>By continuing to use this service, you acknowledge that you understand this is a <strong>simulated environment</strong> and that no real financial transactions or commitments will be made.</li>
            <li>Under no circumstances shall <strong>Spendly</strong>, its developers, or associated parties be held liable for any direct, indirect, incidental, or consequential damages, losses, or harm arising from the use of this portal, including but not limited to any errors, omissions, or disruptions in service.</li>
          </ul>
        </div>
      </form>
    </div>
  </div>

  <script>
    function updateAmount() {
    const plan = document.getElementById("purchase_plan").value;
    const amountInput = document.getElementById("purchase_amount");
    const priceInfo = document.getElementById("price_info");

    let basePrice = 0;
    let gst = 0;
    let totalPrice = 0;

    if (plan === "Free") {
      basePrice = 0;
      gst = 0;
      totalPrice = 0;
    } else if (plan === "Plus") {
      basePrice = (299 / 1.18).toFixed(2);  // Calculate base price for ₹299 total
      gst = (basePrice * 0.18).toFixed(2);  // Calculate GST
      totalPrice = (parseFloat(basePrice) + parseFloat(gst)).toFixed(2);  // Final price after adding GST
    } else if (plan === "Premium") {
      basePrice = (599 / 1.18).toFixed(2);  // Calculate base price for ₹599 total
      gst = (basePrice * 0.18).toFixed(2);  // Calculate GST
      totalPrice = (parseFloat(basePrice) + parseFloat(gst)).toFixed(2);  // Final price after adding GST
    }

    amountInput.value = totalPrice;
    priceInfo.innerHTML = `
      <p>Base Price: ₹${basePrice}</p>
      <p>GST (18%): ₹${gst}</p>
      <p>Total: ₹${totalPrice}</p>
      <p class="font-semibold mt-2">Total Amount to be paid: ₹${totalPrice}</p>
    `;
  }

    function togglePaymentFields() {
      const method = document.getElementById("payment_method").value;
      document.getElementById("upi_section").classList.toggle("hidden", method !== "UPI");
      document.getElementById("card_section").classList.toggle("hidden", method !== "Card");
    }
  </script>

</body>
</html>
