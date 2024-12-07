<?php
require_once __DIR__ . '/../../../../config/database.php';
$db = new Database();
$conn = $db->getConnection();
session_start();

// Fetch application details, school name, school city, country name, and application cost
$application_id = $_SESSION['application_id'];

$query = "
    SELECT 
        s.school_name,
        s.school_city,
        s.application_cost,
        c.country_name
    FROM 
        application_details a
    INNER JOIN 
        school s ON a.major_school = s.school_id
    INNER JOIN 
        country c ON a.major_country = c.country_id
    WHERE 
        a.application_id = :application_id
";

$stmt = $conn->prepare($query);
$stmt->execute(['application_id' => $application_id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    $school_name = $data['school_name'];
    $school_city = $data['school_city'];
    $country_name = $data['country_name'];
    $application_cost = $data['application_cost'];
} else {
    // Handle case where no data is found
    $school_name = 'No school chosen yet';
    $school_city = 'N/A';
    $country_name = 'N/A';
    $application_cost = '0.00';
}
?>

<div class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container mx-auto p-6 max-w-lg bg-white rounded-lg shadow-lg">
        <!-- School Name -->
        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($school_name); ?></h2>
        </div>

        <!-- Location of School -->
        <div class="text-center mb-4">
            <p class="text-lg"><?php echo htmlspecialchars($school_city); ?>, <?php echo htmlspecialchars($country_name); ?></p>
        </div>

        <!-- Application ID -->
        <div class="text-center mb-4">
            <p class="text-lg">Application ID:
            <div id="application_id">
                <?php echo htmlspecialchars($application_id); ?>
            </div>
            </p>
        </div>

        <!-- Payment Amount Circle -->
        <div class="w-36 h-36 mx-auto mb-6 bg-blue-500 rounded-full flex items-center justify-center">
            <span class="text-white text-2xl font-bold">$<span id="applicationCost"> <?php echo htmlspecialchars(number_format($application_cost, 2)); ?>
                </span>
            </span>
        </div>

        <!-- Cost of Application -->
        <div class="text-center mb-4">
            <p class="text-lg font-bold">Cost of Application: $<?php echo htmlspecialchars(number_format($application_cost, 2)); ?></p>
        </div>

        <!-- Paystack Payment Button -->
        <button onclick="processPaystackPayment()" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600">
            Pay Now
        </button>
    </div>
</div>