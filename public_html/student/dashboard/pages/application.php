<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: ../../login/');
    exit();
}

require_once __DIR__ . '/../../../../config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare("SELECT * FROM application_details WHERE application_id = ?");
$stmt->execute([$_SESSION['application_id']]);
if ($stmt->rowCount() > 0) {
    $application = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $conn->prepare("SELECT * FROM `study_experience` WHERE application_id = ?");
$stmt->execute([$_SESSION['application_id']]);
$study_experience = $stmt->fetchAll(PDO::FETCH_ASSOC);

$workStmt = $conn->prepare("SELECT * FROM `work_history` WHERE application_id = ?");
$workStmt->execute([$_SESSION['application_id']]);
$work_history = $workStmt->fetchAll(PDO::FETCH_ASSOC);

$majorCountryStmt = $conn->prepare("SELECT country_id, country_name FROM `country`");
$majorCountryStmt->execute();
$major_countries = $majorCountryStmt->fetchAll(PDO::FETCH_ASSOC);

$majorSchoolStmt = $conn->prepare("SELECT school_id, school_name FROM `school`");
$majorSchoolStmt->execute();
$major_schools = $majorSchoolStmt->fetchAll(PDO::FETCH_ASSOC);

$majorDegreeStmt = $conn->prepare("SELECT degree_id, degree_name FROM `degree`");
$majorDegreeStmt->execute();
$major_degrees = $majorDegreeStmt->fetchAll(PDO::FETCH_ASSOC);

$majorProgramStmt = $conn->prepare("SELECT program_id, program_name, program_duration FROM `program`");
$majorProgramStmt->execute();
$major_programs = $majorProgramStmt->fetchAll(PDO::FETCH_ASSOC);

$stdtFileStmt = $conn->prepare("SELECT * FROM student_files WHERE application_id= ?");
$stdtFileStmt->execute([$_SESSION['application_id']]);
$student_files = $stdtFileStmt->fetchAll(PDO::FETCH_ASSOC);

// Get the file URL for a specific type
function getFileUrl($files, $fileType)
{
    foreach ($files as $file) {
        if ($file['file_type'] === $fileType) {
            return $file['file_path'];
        }
    }
    return null;
}

$countries = [
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cabo Verde",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombia",
    "Comoros",
    "Congo (Congo-Brazzaville)",
    "Congo (DRC)",
    "Costa Rica",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czechia (Czech Republic)",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Eswatini",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Morocco",
    "Mozambique",
    "Myanmar (Burma)",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "North Korea",
    "North Macedonia",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent and the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Korea",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Timor-Leste",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States of America",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
];

?>

<style>
    /* Additional styling */
    .form-section {
        margin-top: 20px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 10px;
    }
</style>

<!-- Save and Submit Buttons -->
<div class="sticky top-0 bg-white z-10 flex justify-end space-x-2 py-2 w-full">
    <button id="save-btn" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" onclick="saveApplication(event)">
        Save
    </button>
    <button id="submit-btn" class="bg-gray-300 text-white py-2 px-4 rounded cursor-not-allowed" disabled>
        Submit
    </button>
</div>
<!-- Form Heading -->
<div class="container mx-auto">
    <!-- Application Form -->
    <form id="application-form" class="bg-white py-4 rounded" method="POST">
        <h2 class="text-2xl font-bold text-center">Application Form</h2>
        <!-- Personal Information -->

        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Family Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="lastname">Family Name *</label>
                    <input type="text" id="family-name" name="lastname"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value='<?php echo $application['lastname'] ?>' />
                </div>
                <!-- Given Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="firstname">Given Name *</label>
                    <input type="text" id="given-name" name="firstname"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"

                        value="<?php echo $application['firstname'] ?>" />
                </div>
                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-bold text-gray-700 mb-1">Gender:</label>
                    <select id="gender" name="gender"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="">Select</option>
                        <option value="Male" <?php echo $application['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?php echo $application['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?php echo $application['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <!-- Passport Size Photo -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="passport">Upload Passport Size Photo *</label>

                    <!-- Check if a file exists for 'passport' -->
                    <?php $passportFileUrl = getFileUrl($student_files, 'passport'); ?>

                    <!-- File input -->
                    <input
                        type="file"
                        onchange="handleFileUpload(event)"
                        id="passport-photo"
                        name="passport"
                        accept="image/*"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />

                    <?php if ($passportFileUrl): ?>
                        <!-- Show the file URL -->
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($passportFileUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Passport Photo
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
                <!-- Nationality -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="nationality">Nationality *</label>
                    <input type="text" name="nationality" id="nationality" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo $application['nationality'] ?>" />
                </div>
                <!-- Marital Status -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="marital_status">Marital Status *</label>
                    <select id="mmarital_status" name="marital_status"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="">Select</option>
                        <option value="Single" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                        <option value="Married" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                        <option value="Divorced" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                        <option value="Widowed" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                    </select>
                </div>
                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="dob">Date of Birth *</label>
                    <input type="date" id="dob" name="dob"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value='<?php echo $application['dob'] ?>' />
                </div>
                <!-- Religion -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="religion">Religion *</label>
                    <select id="religion" name="religion" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="">Select</option>
                        <option value="Christianity" <?php echo isset($application['religion']) && $application['religion'] == 'Christianity' ? 'selected' : '' ?>>Christianity</option>
                        <option value="Islam" <?php echo isset($application['religion']) && $application['religion'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                        <option value="Hinduism" <?php echo isset($application['religion']) && $application['religion'] == 'Hinduism' ? 'selected' : '' ?>>Hinduism</option>
                        <option value="Buddhism" <?php echo isset($application['religion']) && $application['religion'] == 'Buddhism' ? 'selected' : '' ?>>Buddhism</option>
                        <option value="Sikhism" <?php echo isset($application['religion']) && $application['religion'] == 'Sikhism' ? 'selected' : '' ?>>Sikhism</option>
                        <option value="Judaism" <?php echo isset($application['religion']) && $application['religion'] == 'Judaism' ? 'selected' : '' ?>>Judaism</option>
                        <option value="Shinto" <?php echo isset($application['religion']) && $application['religion'] == 'Shinto' ? 'selected' : '' ?>>Shinto</option>
                        <option value="Taoism" <?php echo isset($application['religion']) && $application['religion'] == 'Taoism' ? 'selected' : '' ?>>Taoism</option>
                        <option value="Bahá'í" <?php echo isset($application['religion']) && $application['religion'] == 'Bahá\'í' ? 'selected' : '' ?>>Bahá'í</option>
                        <option value="Jainism" <?php echo isset($application['religion']) && $application['religion'] == 'Jainism' ? 'selected' : '' ?>>Jainism</option>
                    </select>
                </div>

                <!-- Country of Birth -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="country_of_birth">Country of Birth *</label>
                    <select id="country-birth" name="country_of_birth"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="">Select</option>
                        <?php
                        $selectedCountry = $application['country_of_birth'] ?? '';
                        foreach ($countries as $country) {
                            // Check if the current country matches the selected country
                            $isSelected = $country === $selectedCountry ? 'selected' : '';
                            echo "<option value=\"$country\" $isSelected>$country</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Occupation -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="occupation">Occupation *</label>
                    <input type="text" id="occupation" name="occupation" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" value="<?php echo htmlspecialchars($application['occupation'] ?? ''); ?>" />
                </div>
                <!-- Place of Birth -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="place_of_birth">Place of Birth *</label>
                    <input type="text" id="place-birth" name="place_of_birth"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['place_of_birth'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Employer or Institution Affiliated -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="affiliated_institution">Employer or Institution Affiliated to *</label>
                    <input type="text" id="affiliated_institution" name="affiliated_institution"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['affiliated_institution'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Whether in China -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Whether in China now? *</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center" for="in_china_now">
                            <input type="radio" name="in_china_now" value="yes"
                                class="form-radio text-blue-400 focus:border-blue-400"
                                <?php echo (isset($application['in_china_now']) && $application['in_china_now'] === 'Yes') ? 'checked' : ''; ?> />
                            <span class="ml-2">Yes</span>
                        </label>
                        <label class="inline-flex items-center" for="in_china_now">
                            <input type="radio" name="in_china_now" value="no"
                                class="form-radio text-blue-400 focus:border-blue-400"
                                <?php echo (isset($application['in_china_now']) && $application['in_china_now'] === 'No') ? 'checked' : ''; ?> />
                            <span class="ml-2">No</span>
                        </label>
                    </div>
                </div>

                <!-- Native Language -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1" for="native_language">Native Language *</label>
                    <input type="text" id="native-language" name="native_language"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['native_language'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

            </div>
        </div>

        <!-- Correspondence Address -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">
                Correspondence Address
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Detailed Address -->
                <div>
                    <label for="correspondence_detailed_address" class="block text-sm font-bold text-gray-700 mb-1">Detailed Address *</label>
                    <input type="text" id="correspondence_detailed_address" name="correspondence_detailed_address"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_detailed_address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- City/Province -->
                <div>
                    <label for="correspondence_city" class="block text-sm font-bold text-gray-700 mb-1">City/Province *</label>
                    <input type="text" id="correspondence_city" name="correspondence_city"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_city'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Zipcode -->
                <div>
                    <label for="correspondence_zipcode" class="block text-sm font-bold text-gray-700 mb-1">Zipcode *</label>
                    <input type="text" id="correspondence_zipcode" name="correspondence_zipcode"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_zipcode'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Country of Correspondence -->
                <div>
                    <label for="correspondence_country" class="block text-sm font-bold text-gray-700 mb-1">Country *</label>
                    <select id="correspondence_country" name="correspondence_country"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="">Select</option>
                        <?php
                        foreach ($countries as $country) {
                            $selected = (isset($application['correspondence_country']) && $application['correspondence_country'] === $country) ? 'selected' : '';
                            echo "<option value=\"$country\" $selected>$country</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Phone or Mobile -->
                <div>
                    <label for="correspondence_phone" class="block text-sm font-bold text-gray-700 mb-1">Phone or Mobile *</label>
                    <input type="tel" id="correspondence_phone" name="correspondence_phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Email Address -->
                <div>
                    <label for="correspondence_email" class="block text-sm font-bold text-gray-700 mb-1">Email Address *</label>
                    <input type="email" id="correspondence_email" name="correspondence_email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Current Address -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Current Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Detailed Address -->
                <div>
                    <label for="applicant_detailed_address" class="block text-sm font-bold text-gray-700 mb-1">Detailed Address *</label>
                    <input type="text" id="applicant_detailed_address" name="applicant_detailed_address"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_detailed_address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- City/Province -->
                <div>
                    <label for="applicant_city" class="block text-sm font-bold text-gray-700 mb-1">City/Province *</label>
                    <input type="text" id="applicant_city" name="applicant_city"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_city'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Zipcode -->
                <div>
                    <label for="applicant_zipcode" class="block text-sm font-bold text-gray-700 mb-1">Zipcode *</label>
                    <input type="text" id="applicant_zipcode" name="applicant_zipcode"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_zipcode'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Country of Current Address -->
                <div>
                    <label for="applicant_country" class="block text-sm font-bold text-gray-700 mb-1">Country *</label>
                    <select id="applicant_country" name="applicant_country"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="">Select</option>
                        <?php
                        foreach ($countries as $country) {
                            $selected = (isset($application['applicant_country']) && $application['applicant_country'] === $country) ? 'selected' : '';
                            echo "<option value=\"$country\" $selected>$country</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Phone or Mobile -->
                <div>
                    <label for="applicant_phone" class="block text-sm font-bold text-gray-700 mb-1">Phone or Mobile *</label>
                    <input type="tel" id="applicant_phone" name="applicant_phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Email Address -->
                <div>
                    <label for="applicant_email" class="block text-sm font-bold text-gray-700 mb-1">Email Address *</label>
                    <input type="email" id="applicant_email" name="applicant_email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Passport and Visa Information -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">
                Passport and Visa Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Passport No. -->
                <div>
                    <label for="passport_number" class="block text-sm font-bold text-gray-700 mb-1">Passport No.</label>
                    <input type="text" id="passport_number" name="passport_number"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['passport_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Passport Start Date -->
                <div>
                    <label for="passport_start_date" class="block text-sm font-bold text-gray-700 mb-1">Passport Start Date</label>
                    <input type="date" id="passport_start_date" name="passport_start_date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['passport_start_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Passport Expiry Date -->
                <div>
                    <label for="passport_expiry_date" class="block text-sm font-bold text-gray-700 mb-1">Passport Expiry Date</label>
                    <input type="date" id="passport_expiry_date" name="passport_expiry_date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['passport_expiry_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Old Passport No. -->
                <div>
                    <label for="old_passport_number" class="block text-sm font-bold text-gray-700 mb-1">Old Passport No.</label>
                    <input type="text" id="old_passport_number" name="old_passport_number"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['old_passport_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Expiration of Old Passport -->
                <div>
                    <label for="old_expiry_date" class="block text-sm font-bold text-gray-700 mb-1">Expiration of Old Passport</label>
                    <input type="date" id="old_expiry_date" name="old_expiry_date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['old_expiry_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Learning Experience in China -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Learning Experience in China</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Studied in China -->
                <div>
                    <label for="studied_in_china" class="block text-sm font-bold text-gray-700 mb-1">Have you studied in China or not?</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" id="studied_in_china_yes" name="studied_in_china" value="Yes" class="form-radio text-blue-500"
                                <?php echo isset($application['studied_in_china']) && $application['studied_in_china'] === 'Yes' ? 'checked' : ''; ?> />
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" id="studied_in_china_no" name="studied_in_china" value="No" class="form-radio text-blue-500"
                                <?php echo isset($application['studied_in_china']) && $application['studied_in_china'] === 'No' ? 'checked' : ''; ?> />
                            <span>No</span>
                        </label>
                    </div>
                </div>
                <!-- Visa Type -->
                <div>
                    <label for="visa_type" class="block text-sm font-bold text-gray-700 mb-1">Visa Type *</label>
                    <input type="text" id="visa_type" name="visa_type"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['visa_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Visa Expiry Date -->
                <div>
                    <label for="visa_expiry_date" class="block text-sm font-bold text-gray-700 mb-1">Visa Expiry Date *</label>
                    <input type="date" id="visa_expiry_date" name="visa_expiry_date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['visa_expiry_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Institution in China -->
                <div>
                    <label for="institution_in_china_studying" class="block text-sm font-bold text-gray-700 mb-1">Institution in China that you are studying now</label>
                    <input type="text" id="institution_in_china_studying" name="institution_in_china_studying"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['institution_in_china_studying'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Financial Sponsor's Information -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">
                Financial Sponsor's Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Sponsor Name -->
                <div>
                    <label for="fin_sponsor_name" class="block text-sm font-bold text-gray-700 mb-1">Name *</label>
                    <input type="text" id="fin_sponsor_name" name="fin_sponsor_name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Sponsor Relationship -->
                <div>
                    <label for="fin_sponsor_relationship" class="block text-sm font-bold text-gray-700 mb-1">Relationship *</label>
                    <input type="text" id="fin_sponsor_relationship" name="fin_sponsor_relationship"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_relationship'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Sponsor Work Place -->
                <div>
                    <label for="fin_sponsor_work_place" class="block text-sm font-bold text-gray-700 mb-1">Work Place *</label>
                    <input type="text" id="fin_sponsor_work_place" name="fin_sponsor_work_place"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_work_place'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Sponsor Occupation -->
                <div>
                    <label for="fin_sponsor_occupation" class="block text-sm font-bold text-gray-700 mb-1">Occupation *</label>
                    <input type="text" id="fin_sponsor_occupation" name="fin_sponsor_occupation"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_occupation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Sponsor Email -->
                <div>
                    <label for="fin_sponsor_email" class="block text-sm font-bold text-gray-700 mb-1">Email *</label>
                    <input type="email" id="fin_sponsor_email" name="fin_sponsor_email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Sponsor Phone/Mobile -->
                <div>
                    <label for="fin_sponsor_phone" class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile *</label>
                    <input type="tel" id="fin_sponsor_phone" name="fin_sponsor_phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Guarantor's Information -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Guarantor's Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Guarantor Name -->
                <div>
                    <label for="guarantor_name" class="block text-sm font-bold text-gray-700 mb-1">Name *</label>
                    <input type="text" id="guarantor_name" name="guarantor_name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Guarantor Relationship -->
                <div>
                    <label for="guarantor_relationship" class="block text-sm font-bold text-gray-700 mb-1">Relationship *</label>
                    <input type="text" id="guarantor_relationship" name="guarantor_relationship"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_relationship'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Guarantor Work Place -->
                <div>
                    <label for="guarantor_work_place" class="block text-sm font-bold text-gray-700 mb-1">Work Place *</label>
                    <input type="text" id="guarantor_work_place" name="guarantor_work_place"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_work_place'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Guarantor Occupation -->
                <div>
                    <label for="guarantor_occupation" class="block text-sm font-bold text-gray-700 mb-1">Occupation *</label>
                    <input type="text" id="guarantor_occupation" name="guarantor_occupation"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_occupation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Guarantor Email -->
                <div>
                    <label for="guarantor_email" class="block text-sm font-bold text-gray-700 mb-1">Email *</label>
                    <input type="email" id="guarantor_email" name="guarantor_email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Guarantor Phone/Mobile -->
                <div>
                    <label for="guarantor_phone" class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile *</label>
                    <input type="tel" id="guarantor_phone" name="guarantor_phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Emergency Contact</h3>
            <p class="text-gray-600 mb-4">
                Please make sure the contact information is real and correct in case of emergency.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Emergency Contact Name -->
                <div>
                    <label for="emergency_contact_name" class="block text-sm font-bold text-gray-700 mb-1">Name *</label>
                    <input type="text" id="emergency_contact_name" name="emergency_contact_name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Emergency Contact Relationship -->
                <div>
                    <label for="emergency_contact_relationship" class="block text-sm font-bold text-gray-700 mb-1">Relationship *</label>
                    <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_relationship'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Emergency Contact Work Place -->
                <div>
                    <label for="emergency_contact_work_place" class="block text-sm font-bold text-gray-700 mb-1">Work Place *</label>
                    <input type="text" id="emergency_contact_work_place" name="emergency_contact_work_place"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_work_place'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Emergency Contact Occupation -->
                <div>
                    <label for="emergency_contact_occupation" class="block text-sm font-bold text-gray-700 mb-1">Occupation *</label>
                    <input type="text" id="emergency_contact_occupation" name="emergency_contact_occupation"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_occupation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Emergency Contact Email -->
                <div>
                    <label for="emergency_contact_email" class="block text-sm font-bold text-gray-700 mb-1">Email *</label>
                    <input type="email" id="emergency_contact_email" name="emergency_contact_email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Emergency Contact Phone/Mobile -->
                <div>
                    <label for="emergency_contact_phone" class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile *</label>
                    <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Major's Information Form -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Major's Information</h3>
            <p class="text-gray-600 mb-4">
                Please select your desired Country -> School -> Degree -> Program.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Country -->
                <div>
                    <label for="major_country" class="block text-sm font-bold text-gray-700 mb-1">Country *</label>
                    <select id="major_country" name="major_country" onchange="fetchSchools()" class="w-full p-3 border border-gray-300 rounded-md">
                        <option value="">Select a country</option>
                        <?php foreach ($major_countries as $country): ?>
                            <option value="<?php echo $country['country_id']; ?>"
                                <?php echo isset($application['major_country']) && $application['major_country'] == $country['country_id'] ? 'selected' : ''; ?>>
                                <?php echo $country['country_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- School -->
                <div>
                    <label for="major_school" class="block text-sm font-bold text-gray-700 mb-1">School *</label>
                    <select id="major_school" name="major_school" onchange="fetchDegrees()" class="w-full p-3 border border-gray-300 rounded-md"
                        <?php echo isset($application['major_school']) ? '' : 'disabled'; ?>>
                        <option value="">Select a school</option>
                        <?php if (isset($major_schools)): ?>
                            <?php foreach ($major_schools as $school): ?>
                                <option value="<?php echo $school['school_id']; ?>"
                                    <?php echo isset($application['major_school']) && $application['major_school'] == $school['school_id'] ? 'selected' : ''; ?>>
                                    <?php echo $school['school_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Degree -->
                <div>
                    <label for="major_degree" class="block text-sm font-bold text-gray-700 mb-1">Degree *</label>
                    <select id="major_degree" name="major_degree" onchange="fetchPrograms()" class="w-full p-3 border border-gray-300 rounded-md"
                        <?php echo isset($application['major_degree']) ? '' : 'disabled'; ?>>
                        <option value="">Select a degree</option>
                        <?php if (isset($major_degrees)): ?>
                            <?php foreach ($major_degrees as $degree): ?>
                                <option value="<?php echo $degree['degree_id']; ?>"
                                    <?php echo isset($application['major_degree']) && $application['major_degree'] == $degree['degree_id'] ? 'selected' : ''; ?>>
                                    <?php echo $degree['degree_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Program -->
                <div>
                    <label for="major_program" class="block text-sm font-bold text-gray-700 mb-1">Program *</label>
                    <select id="major_program" name="major_program" onchange="showDuration()" class="w-full p-3 border border-gray-300 rounded-md"
                        <?php echo isset($application['major_program']) ? '' : 'disabled'; ?>>
                        <option value="">Select a program</option>
                        <?php if (isset($major_programs)): ?>
                            <?php foreach ($major_programs as $program): ?>
                                <option value="<?php echo $program['program_id']; ?>"
                                    <?php echo isset($application['major_program']) && $application['major_program'] == $program['program_id'] ? 'selected' : ''; ?>>
                                    <?php echo $program['program_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Study Duration -->
                <div>
                    <label for="study_duration" class="block text-sm font-bold text-gray-700 mb-1">Study Duration *</label>
                    <input type="text" id="study_duration" name="study_duration" class="w-full p-3 border border-gray-300 rounded-md"
                        value="<?php echo isset($application['major_program']) ? $major_programs[array_search($application['major_program'], array_column($major_programs, 'program_id'))]['program_duration'] : ''; ?>" "" />
                </div>
            </div>
        </div>

        <!-- Language Proficiency -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Language Proficiency</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- English Proficiency -->
                <div>
                    <label for="english_proficiency" class="block text-sm font-bold text-gray-700 mb-1">English Proficiency *</label>
                    <input type="text" id="english_proficiency" name="english_proficiency"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['english_proficiency'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- English Proficiency Certificate -->
                <div>
                    <label for="english_proficiency_certificate" class="block text-sm font-bold text-gray-700 mb-1">
                        English Proficiency Certificate *
                    </label>

                    <?php
                    // Check if a file exists for 'english_proficiency_certificate'
                    $englishProficiencyFileUrl = getFileUrl($student_files, 'english_proficiency_certificate');
                    ?>

                    <!-- File input -->
                    <input
                        type="file" onchange="handleFileUpload(event)" id="english_proficiency_certificate"
                        name="english_proficiency_certificate"
                        accept="image/*,application/pdf"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />

                    <?php if ($englishProficiencyFileUrl): ?>
                        <!-- Show the file URL -->
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($englishProficiencyFileUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded English Proficiency Certificate
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Chinese Proficiency -->
                <div>
                    <label for="chinese_proficiency" class="block text-sm font-bold text-gray-700 mb-1">Chinese Proficiency *</label>
                    <input type="text" id="chinese_proficiency" name="chinese_proficiency"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['chinese_proficiency'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- HSK Level -->
                <div>
                    <label for="hsk_level" class="block text-sm font-bold text-gray-700 mb-1">HSK Level *</label>
                    <input type="text" id="hsk_level" name="hsk_level"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['hsk_level'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- HSK Scores -->
                <div>
                    <label for="hsk_scores" class="block text-sm font-bold text-gray-700 mb-1">HSK Scores</label>
                    <input type="text" id="hsk_scores" name="hsk_scores"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['hsk_scores'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- HSKK Scores -->
                <div>
                    <label for="hskk_scores" class="block text-sm font-bold text-gray-700 mb-1">HSKK Scores</label>
                    <input type="text" id="hskk_scores" name="hskk_scores"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['hskk_scores'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Time of Chinese language learning -->
                <div>
                    <label for="time_of_chinese_learning" class="block text-sm font-bold text-gray-700 mb-1">Time of Chinese language learning *</label>
                    <input type="text" id="time_of_chinese_learning" name="time_of_chinese_learning"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['time_of_chinese_learning'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Whether the Chinese teacher owns a Chinese Nationality -->
                <div>
                    <label for="teacher_nationality_chinese" class="block text-sm font-bold text-gray-700 mb-1">Chinese Teacher's Nationality *</label>
                    <select id="teacher_nationality_chinese" name="teacher_nationality_chinese"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="" <?php echo !isset($application['teacher_nationality_chinese']) ? 'selected' : ''; ?>>Select</option>
                        <option value="1" <?php echo ($application['teacher_nationality_chinese'] ?? '') === '1' ? 'selected' : ''; ?>>Yes</option>
                        <option value="0" <?php echo ($application['teacher_nationality_chinese'] ?? '') === '0' ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>

                <!-- Name of institution for Chinese learning -->
                <div>
                    <label for="chinese_learning_institution" class="block text-sm font-bold text-gray-700 mb-1">Name of institution for Chinese learning *</label>
                    <input type="text" id="chinese_learning_institution" name="chinese_learning_institution"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['chinese_learning_institution'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Education Background Section -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Education Background</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Highest Degree -->
                <div>
                    <label for="highest_degree" class="block text-sm font-bold text-gray-700 mb-1">Highest Degree *</label>
                    <input type="text" id="highest_degree" name="highest_degree"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['highest_degree'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Highest Degree Graduation School -->
                <div>
                    <label for="highest_degree_school" class="block text-sm font-bold text-gray-700 mb-1">Highest Degree Graduation School *</label>
                    <input type="text" id="highest_degree_school" name="highest_degree_school"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['highest_degree_school'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Certificate Type of Highest Degree Level -->
                <div>
                    <label for="highest_degree_certificate_type" class="block text-sm font-bold text-gray-700 mb-1">Certificate Type of Highest Degree Level *</label>
                    <input type="text" id="highest_degree_certificate_type" name="highest_degree_certificate_type"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['highest_degree_certificate_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Mark Range if Full Mark is 100 -->
                <div>
                    <label for="best_mark_if_100" class="block text-sm font-bold text-gray-700 mb-1">Mark Range if Full Mark is 100 *</label>
                    <input type="number" id="best_mark_if_100" name="best_mark_if_100"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['best_mark_if_100'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Any Failure in Highest Degree Marks if Full Mark is 100 -->
                <div>
                    <label for="worst_mark_if_100" class="block text-sm font-bold text-gray-700 mb-1">Any Failure in Highest Degree Marks if Full Mark is 100 *</label>
                    <input type="text" id="worst_mark_if_100" name="worst_mark_if_100"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['worst_mark_if_100'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
            </div>
        </div>

        <!-- Study Experience Section -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">
                Study Experience (Start from High School Till Now)
            </h3>
            <div id="study-experience-container" class="space-y-4">
                <?php if (!empty($study_experience)): ?>
                    <?php foreach ($study_experience as $experience): ?>
                        <!-- Display Entry -->
                        <div class="study-entry grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">School Name *</label>
                                <input type="text" class="school-name w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($experience['school_name']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Degree *</label>
                                <input type="text" class="degree w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($experience['degree']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Year of Attendance (From - To) *</label>
                                <input type="text" class="attendance-period w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($experience['attendance_period']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Contact Person</label>
                                <input type="text" class="contact-person w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($experience['contact_person'] ?? ''); ?>" />
                            </div>
                        </div>
                        <hr class="border border-gray-500">
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Blank Form for New Entry -->
                    <div class="study-entry grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">School Name *</label>
                            <input type="text" class="school-name w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Degree *</label>
                            <input type="text" class="degree w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Year of Attendance (From - To) *</label>
                            <input type="text" class="attendance-period w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Contact Person</label>
                            <input type="text" class="contact-person w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                    </div>
                    <hr class="border border-gray-500">
                <?php endif; ?>
            </div>
            <button id="add-study-entry" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                Add More
            </button>
        </div>

        <!-- Work History Section -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Work History</h3>
            <div id="work-history-container" class="space-y-4">
                <?php if (!empty($work_history)): ?>
                    <?php foreach ($work_history as $work): ?>
                        <!-- Existing Entry -->
                        <div class="work-entry grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Starting Time</label>
                                <input type="date" name="start_date"
                                    class="work-start w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($work['start_date']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Ending Time</label>
                                <input type="date" name="end_date"
                                    class="work-end w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($work['end_date']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Position</label>
                                <input type="text" name="position"
                                    class="position w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($work['position']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Company</label>
                                <input type="text" name="company"
                                    class="company w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($work['company']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Company Phone/Mobile</label>
                                <input type="tel" name="company_phone"
                                    class="phone w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($work['company_phone']); ?>" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Company Email</label>
                                <input type="email" name="company_email"
                                    class="email w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                    value="<?php echo htmlspecialchars($work['company_email']); ?>" />
                            </div>
                        </div>
                        <hr class="border border-gray-500">
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Blank Form for New Entry -->
                    <div class="work-entry grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Starting Time</label>
                            <input type="date" name="start_date"
                                class="work-start w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Ending Time</label>
                            <input type="date" name="end_date"
                                class="work-end w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Position</label>
                            <input type="text" name="position"
                                class="position w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Company</label>
                            <input type="text" name="company"
                                class="company w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Company Phone/Mobile</label>
                            <input type="tel" name="company_phone"
                                class="phone w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Company Email</label>
                            <input type="email" name="company_email"
                                class="email w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                        </div>
                    </div>
                    <hr class="border border-gray-500">
                <?php endif; ?>
            </div>
            <button id="add-work-entry" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                Add More
            </button>
        </div>

        <!-- Upload Documents Section -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Upload Documents</h3>
            <p class="text-gray-600 mb-4">
                The uploaded file type needs to be
                <strong>.jpg, .jpeg, .png, .bmp, .doc, .docx, .pdf, .xls, .xlsx</strong>. Maximum file size is payments.php.
            </p>

            <div class="grid grid-cols-1 gap-4">
                <!-- Valid passport with visa page -->
                <div>
                    <label for="valid_passport" class="block text-sm font-bold text-gray-700 mb-1">Valid Passport with Visa Page *</label>
                    <?php $validPassportUrl = getFileUrl($student_files, 'valid_passport'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="valid_passport" name="valid_passport"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($validPassportUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($validPassportUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Passport with Visa Page
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Highest academic Diploma/Certificate -->
                <div>
                    <label for="highest_academic_diploma" class="block text-sm font-bold text-gray-700 mb-1">Highest Academic Diploma/Certificate *</label>
                    <?php $academicDiplomaUrl = getFileUrl($student_files, 'highest_academic_diploma'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="highest_academic_diploma" name="highest_academic_diploma"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($academicDiplomaUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($academicDiplomaUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Diploma/Certificate
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Highest academic transcripts -->
                <div>
                    <label for="highest_academic_transcripts" class="block text-sm font-bold text-gray-700 mb-1">Highest Academic Transcripts *</label>
                    <?php $academicTranscriptsUrl = getFileUrl($student_files, 'highest_academic_transcripts'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="highest_academic_transcripts" name="highest_academic_transcripts"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($academicTranscriptsUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($academicTranscriptsUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Academic Transcripts
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Non-criminal record -->
                <div>
                    <label for="non_criminal_record" class="block text-sm font-bold text-gray-700 mb-1">Non-criminal Record *</label>
                    <?php $nonCriminalRecordUrl = getFileUrl($student_files, 'non_criminal_record'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="non_criminal_record" name="non_criminal_record"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($nonCriminalRecordUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($nonCriminalRecordUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Non-criminal Record
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Bank Statement -->
                <div>
                    <label for="bank_statement" class="block text-sm font-bold text-gray-700 mb-1">Bank Statement</label>
                    <?php $bankStatementUrl = getFileUrl($student_files, 'bank_statement'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="bank_statement" name="bank_statement"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($bankStatementUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($bankStatementUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Bank Statement
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Application Fee Receipt -->
                <div>
                    <label for="application_fee_receipt" class="block text-sm font-bold text-gray-700 mb-1">Application Fee Receipt</label>
                    <?php $applicationFeeReceiptUrl = getFileUrl($student_files, 'application_fee_receipt'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="application_fee_receipt" name="application_fee_receipt"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($applicationFeeReceiptUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($applicationFeeReceiptUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Application Fee Receipt
                            </a>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">Please note this application fee is non-refundable.</p>
                </div>

                <!-- Recommendation Letters -->
                <div>
                    <label for="recommendation_letters" class="block text-sm font-bold text-gray-700 mb-1">Recommendation Letter(s)</label>
                    <?php $recommendationLettersUrl = getFileUrl($student_files, 'recommendation_letters'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="recommendation_letters" name="recommendation_letters"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($recommendationLettersUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($recommendationLettersUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Recommendation Letter(s)
                            </a>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">Provide 2 recommendation letters (for Masters & PhD only).</p>
                </div>

                <!-- Publications, Articles, Thesis -->
                <div>
                    <label for="publications_articles_thesis" class="block text-sm font-bold text-gray-700 mb-1">Publications, Articles, Thesis, etc.</label>
                    <?php $publicationsUrl = getFileUrl($student_files, 'publications_articles_thesis'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="publications_articles_thesis" name="publications_articles_thesis"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($publicationsUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($publicationsUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Publications, Articles, or Thesis
                            </a>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">(For Masters & PhD only)</p>
                </div>


                <!-- Foreigner Physical Examination Form -->
                <div>
                    <label for="physical_examination_form" class="block text-sm font-bold text-gray-700 mb-1">Foreigner Physical Examination Form *</label>
                    <?php $physicalExamFormUrl = getFileUrl($student_files, 'physical_examination_form'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="physical_examination_form" name="physical_examination_form"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($physicalExamFormUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($physicalExamFormUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Physical Examination Form
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Guardian's Letter of Guarantee -->
                <div>
                    <label for="guardians_letter_of_guarantee" class="block text-sm font-bold text-gray-700 mb-1">Guardian's Letter of Guarantee</label>
                    <?php $guardiansLetterUrl = getFileUrl($student_files, 'guardians_letter_of_guarantee'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="guardians_letter_of_guarantee" name="guardians_letter_of_guarantee"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($guardiansLetterUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($guardiansLetterUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Guardian's Letter of Guarantee
                            </a>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">Applicants under 18 should submit this document.</p>
                </div>

                <!-- English Language Proficiency -->
                <div>
                    <label for="english_language_proficiency" class="block text-sm font-bold text-gray-700 mb-1">English Language Proficiency</label>
                    <?php $englishProficiencyUrl = getFileUrl($student_files, 'english_language_proficiency'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="english_language_proficiency" name="english_language_proficiency"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($englishProficiencyUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($englishProficiencyUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded English Language Proficiency Document
                            </a>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">Students from English-speaking countries are exempted.</p>
                </div>

                <!-- Chinese Language Certificate (HSK Certificate) -->
                <div>
                    <label for="chinese_language_certificate" class="block text-sm font-bold text-gray-700 mb-1">Chinese Language Certificate (HSK Certificate)</label>
                    <?php $chineseCertificateUrl = getFileUrl($student_files, 'chinese_language_certificate'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="chinese_language_certificate" name="chinese_language_certificate"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($chineseCertificateUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($chineseCertificateUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Chinese Language Certificate
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Parent's Authorization Letter -->
                <div>
                    <label for="parents_authorization_letter" class="block text-sm font-bold text-gray-700 mb-1">Parent's Authorization Letter</label>
                    <?php $parentsAuthorizationUrl = getFileUrl($student_files, 'parents_authorization_letter'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="parents_authorization_letter" name="parents_authorization_letter"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($parentsAuthorizationUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($parentsAuthorizationUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Parent's Authorization Letter
                            </a>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">Applicants under 18 should submit this document.</p>
                </div>


                <!-- Study Plan or Research Proposal -->
                <div>
                    <label for="study_plan_research_proposal" class="block text-sm font-bold text-gray-700 mb-1">Study Plan or Research Proposal</label>
                    <?php $studyPlanUrl = getFileUrl($student_files, 'study_plan_research_proposal'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="study_plan_research_proposal" name="study_plan_research_proposal"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($studyPlanUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($studyPlanUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Study Plan or Research Proposal
                            </a>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">For Masters & PhD only</p>
                </div>

                <!-- Curriculum Vitae -->
                <div>
                    <label for="curriculum_vitae" class="block text-sm font-bold text-gray-700 mb-1">Curriculum Vitae</label>
                    <?php $curriculumVitaeUrl = getFileUrl($student_files, 'curriculum_vitae'); ?>
                    <input type="file" onchange="handleFileUpload(event)" id="curriculum_vitae" name="curriculum_vitae"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <?php if ($curriculumVitaeUrl): ?>
                        <p class="mt-2 text-sm text-gray-500">
                            Current File:
                            <a href="<?= './../' . htmlspecialchars($curriculumVitaeUrl) ?>" target="_blank" class="text-blue-500 hover:underline">
                                View Uploaded Curriculum Vitae
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </form>
</div>