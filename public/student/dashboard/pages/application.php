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

$stmt = $conn->prepare("SELECT * FROM study_experience WHERE application_id = ?");
$stmt->execute([$_SESSION['application_id']]);
$study_experience = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <button id="save-btn" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
        Save
    </button>
    <button id="submit-btn" class="bg-gray-300 text-white py-2 px-4 rounded cursor-not-allowed" disabled>
        Submit
    </button>
</div>
<!-- Form Heading -->
<div class="container mx-auto">

    <!-- Application Form -->
    <form id="application-form" class="bg-white py-4 rounded">
        <h2 class="text-2xl font-bold text-center">Application Form</h2>
        <!-- Personal Information -->

        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Family Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Family Name *</label>
                    <input type="text" id="family-name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        required
                        value='<?php echo $application['lastname'] ?>' />
                </div>
                <!-- Given Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Given Name *</label>
                    <input type="text" id="given-name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        required
                        value="<?php echo $application['firstname'] ?>" />
                </div>
                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-bold text-gray-700 mb-1">Gender:</label>
                    <select id="gender"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        required>
                        <option value="">Select</option>
                        <option value="Male" <?php echo $application['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?php echo $application['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?php echo $application['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <!-- Passport Size Photo -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Upload Passport Size Photo *</label>
                    <input type="file" id="passport-photo" accept="image" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        required />
                </div>
                <!-- Nationality -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nationality *</label>
                    <input type="text" name="nationality" id="nationality" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo $application['nationality'] ?>" />
                </div>
                <!-- Marital Status -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Marital Status *</label>
                    <select id="marital-status"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        required>
                        <option value="">Select</option>
                        <option value="single" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                        <option value="married" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                        <option value="divorced" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                        <option value="widowed" <?php echo isset($application['marital_status']) && $application['marital_status'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                    </select>
                </div>
                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Date of Birth *</label>
                    <input type="date" id="dob"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        required />
                </div>
                <!-- Religion -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Religion *</label>
                    <select id="religion" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Country of Birth *</label>
                    <select id="country-birth"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        required>
                        <option value="">Select</option>
                        <?php
                        // Array of countries
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Occupation *</label>
                    <input type="text" id="occupation" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required value="<?php echo htmlspecialchars($application['occupation'] ?? ''); ?>" />
                </div>
                <!-- Place of Birth -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Place of Birth *</label>
                    <input type="text" id="place-birth"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['place_of_birth'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>

                <!-- Employer or Institution Affiliated -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Employer or Institution Affiliated to *</label>
                    <input type="text" id="employer"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['affiliated_institution'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>

                <!-- Whether in China -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Whether in China now? *</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="in-china" value="yes"
                                class="form-radio text-blue-400 focus:border-blue-400"
                                <?php echo (isset($application['in_china_now']) && $application['in_china_now'] === 'Yes') ? 'checked' : ''; ?> required />
                            <span class="ml-2">Yes</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="in-china" value="no"
                                class="form-radio text-blue-400 focus:border-blue-400"
                                <?php echo (isset($application['in_china_now']) && $application['in_china_now'] === 'No') ? 'checked' : ''; ?> required />
                            <span class="ml-2">No</span>
                        </label>
                    </div>
                </div>

                <!-- Native Language -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Native Language *</label>
                    <input type="text" id="native-language"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['native_language'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Detailed Address *</label>
                    <input type="text" id="correspondence-detailed-address"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_detailed_address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- City/Province -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">City/Province *</label>
                    <input type="text" id="correspondence-city-province"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_city'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Zipcode -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Zipcode *</label>
                    <input type="text" id="correspondence-zipcode"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_zipcode'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Country of Correspondence -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Country *</label>
                    <select id="country-correspondence"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
                        <option value="">Select</option>
                        <?php
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
                        foreach ($countries as $country) {
                            $selected = (isset($application['correspondence_country']) && $application['correspondence_country'] === $country) ? 'selected' : '';
                            echo "<option value=\"$country\" $selected>$country</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Phone or Mobile -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Phone or Mobile *</label>
                    <input type="tel" id="correspondence-phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Email Address -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Address *</label>
                    <input type="email" id="correspondence-email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['correspondence_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
            </div>
        </div>


        <!-- Current Address -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Current Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Detailed Address -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Detailed Address *</label>
                    <input type="text" id="current-detailed-address"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_detailed_address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- City/Province -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">City/Province *</label>
                    <input type="text" id="current-city-province"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_city'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Zipcode -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Zipcode *</label>
                    <input type="text" id="current-zipcode"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_zipcode'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Country of Current Address -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Country *</label>
                    <select id="country-residence"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
                        <option value="">Select</option>
                        <?php
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
                        foreach ($countries as $country) {
                            $selected = (isset($application['applicant_country']) && $application['applicant_country'] === $country) ? 'selected' : '';
                            echo "<option value=\"$country\" $selected>$country</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Phone or Mobile -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Phone or Mobile *</label>
                    <input type="tel" id="current-phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Email Address -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Address *</label>
                    <input type="email" id="current-email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['applicant_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Passport No.</label>
                    <input type="text" id="passport-no"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['passport_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Passport Start Date -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Passport Start Date</label>
                    <input type="date" id="passport-start-date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['passport_start_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Passport Expiry Date -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Passport Expiry Date</label>
                    <input type="date" id="passport-expiry-date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['passport_expiry_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Old Passport No. -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Old Passport No.</label>
                    <input type="text" id="old-passport-no"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['old_passport_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Expiration of Old Passport -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Expiration of Old Passport</label>
                    <input type="date" id="old-passport-expiry-date"
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Have you studied in China or not?</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="studied-in-china" value="Yes" class="form-radio text-blue-500"
                                <?php echo isset($application['studied_in_china']) && $application['studied_in_china'] === 'Yes' ? 'checked' : ''; ?> required />
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="studied-in-china" value="No" class="form-radio text-blue-500"
                                <?php echo isset($application['studied_in_china']) && $application['studied_in_china'] === 'No' ? 'checked' : ''; ?> />
                            <span>No</span>
                        </label>
                    </div>
                </div>
                <!-- Visa Type -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Visa Type *</label>
                    <input type="text" id="visa-type"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['visa_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Visa Expiry Date -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Visa Expiry Date *</label>
                    <input type="date" id="visa-expiry-date"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['visa_expiry_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Institution in China -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Institution in China that you are studying now</label>
                    <input type="text" id="institution-china"
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Name *</label>
                    <input type="text" id="sponsor-name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Sponsor Relationship -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Relationship *</label>
                    <input type="text" id="sponsor-relationship"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_relationship'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Sponsor Work Place -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Work Place *</label>
                    <input type="text" id="sponsor-workplace"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_work_place'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Sponsor Occupation -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Occupation *</label>
                    <input type="text" id="sponsor-occupation"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_occupation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Sponsor Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email *</label>
                    <input type="email" id="sponsor-email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['fin_sponsor_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Sponsor Phone/Mobile -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile *</label>
                    <input type="tel" id="sponsor-phone"
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Name *</label>
                    <input type="text" id="guarantor-name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Guarantor Relationship -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Relationship *</label>
                    <input type="text" id="guarantor-relationship"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_relationship'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Guarantor Work Place -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Work Place *</label>
                    <input type="text" id="guarantor-workplace"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_work_place'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Guarantor Occupation -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Occupation *</label>
                    <input type="text" id="guarantor-occupation"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_occupation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Guarantor Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email *</label>
                    <input type="email" id="guarantor-email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Guarantor Phone/Mobile -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile *</label>
                    <input type="tel" id="guarantor-phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['guarantor_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
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
                    <label class="block text-sm font-bold text-gray-700 mb-1">Name *</label>
                    <input type="text" id="emergency-contact-name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Emergency Contact Relationship -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Relationship *</label>
                    <input type="text" id="emergency-contact-relationship"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_relationship'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Emergency Contact Work Place -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Work Place *</label>
                    <input type="text" id="emergency-contact-workplace"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_work_place'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Emergency Contact Occupation -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Occupation *</label>
                    <input type="text" id="emergency-contact-occupation"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_occupation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Emergency Contact Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email *</label>
                    <input type="email" id="emergency-contact-email"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Emergency Contact Phone/Mobile -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile *</label>
                    <input type="tel" id="emergency-contact-phone"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['emergency_contact_phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
            </div>
        </div>


        <!-- Major's Information Form -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Major's Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Country -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Country *</label>
                    <select id="country" onchange="fetchSchools()" class="w-full p-3 border border-gray-300 rounded-md"
                        required>
                        <option value="">Select a country</option>

                    </select>
                </div>
                <!-- School -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">School *</label>
                    <select id="school" onchange="fetchDegrees()" class="w-full p-3 border border-gray-300 rounded-md" required>
                        <option value="">Select a school</option>
                    </select>
                </div>
                <!-- Degree -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Degree *</label>
                    <select id="degree" onchange="fetchPrograms()" class="w-full p-3 border border-gray-300 rounded-md"
                        required>
                        <option value="">Select a degree</option>
                    </select>
                </div>
                <!-- Program -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Program *</label>
                    <select id="program" onchange="showDuration()" class="w-full p-3 border border-gray-300 rounded-md"
                        required>
                        <option value="">Select a program</option>
                    </select>
                </div>
                <!-- Study Duration -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Study Duration *</label>
                    <input type="text" id="study-duration" class="w-full p-3 border border-gray-300 rounded-md" readonly />
                </div>
            </div>
        </div>

        <!-- Language Proficiency -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Language Proficiency</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- English Proficiency -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">English Proficiency *</label>
                    <input type="text" id="english-proficiency"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['english_proficiency'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- English Proficiency Certificate -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">English Proficiency Certificate *</label>
                    <input type="file" id="english-proficiency-certificate"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                </div>
                <!-- Chinese Proficiency -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Chinese Proficiency *</label>
                    <input type="text" id="chinese-proficiency"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['chinese_proficiency'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- HSK Level -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">HSK Level *</label>
                    <input type="text" id="hsk-level"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['hsk_level'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- HSK Scores -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">HSK Scores</label>
                    <input type="text" id="hsk-scores"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['hsk_scores'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- HSKK Scores -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">HSKK Scores</label>
                    <input type="text" id="hskk-scores"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['hskk_scores'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                </div>
                <!-- Time of Chinese language learning -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Time of Chinese language learning *</label>
                    <input type="text" id="chinese-learning-time"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['time_of_chinese_learning'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Whether the Chinese teacher own a Chinese Nationality -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Chinese Teacher's Nationality *</label>
                    <select id="teacher-nationality"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
                        <option value="" <?php echo !isset($application['teacher_nationlity_chinese']) ? 'selected' : ''; ?>>Select</option>
                        <option value="yes" <?php echo ($application['teacher_nationlity_chinese'] ?? '') === '1' ? 'selected' : ''; ?>>Yes</option>
                        <option value="no" <?php echo ($application['teacher_nationlity_chinese'] ?? '') === '0' ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                <!-- Name of institution for Chinese learning -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Name of institution for Chinese learning *</label>
                    <input type="text" id="institution-name"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['chinese_learning_institution'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
            </div>
        </div>

        <!-- Education Background Section -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Education Background</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Highest Degree -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Highest Degree *</label>
                    <input type="text" id="highest-degree"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['highest_degree'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Highest Degree Graduation School -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Highest Degree Graduation School *</label>
                    <input type="text" id="graduation-school"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['highest_degree_school'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Certificate Type of Highest Degree Level -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Certificate Type of Highest Degree Level *</label>
                    <input type="text" id="certificate-type"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['highest_degree_certificate_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Mark Range if Full Mark is 100 -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Mark Range if Full Mark is 100 *</label>
                    <input type="number" id="mark-range"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['best_mark_if_100'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
                <!-- Any Failure in Highest Degree Marks if Full Mark is 100 -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Any Failure in Highest Degree Marks if Full Mark is 100 *</label>
                    <input type="text" id="degree-failure"
                        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        value="<?php echo htmlspecialchars($application['worst_mark_if_100'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required />
                </div>
            </div>
        </div>

        <!-- Study Experience Section -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">
                Study Experience (Start from High School Till Now)
            </h3>
            <div id="study-experience-container" class="space-y-4">
                <?php foreach ($study_experience as $experience): ?>
                    <div class="study-entry grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">School Name *</label>
                            <input type="text" class="school-name w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                value="<?php echo htmlspecialchars($experience['institution']); ?>" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Degree *</label>
                            <input type="text" class="degree w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                value="<?php echo htmlspecialchars($experience['degree']); ?>" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Year of Attendance (From - To) *</label>
                            <input type="text" class="attendance-period w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                value="<?php echo htmlspecialchars($experience['start_date']) . ' - ' . htmlspecialchars($experience['end_date']); ?>" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Contact Person</label>
                            <input type="text" class="contact-person w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                                value="<?php echo htmlspecialchars($experience['contact_person']); ?>" />
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="add-study-entry" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md">
                Add More
            </button>
        </div>

        <!-- Work History Section -->
        <div class="form-section p-4 bg-gray-100 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Work History</h3>
            <div id="work-history-container" class="space-y-4">
                <div class="work-entry grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Starting Time</label>
                        <input type="date"
                            class="work-start w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Ending Time</label>
                        <input type="date"
                            class="work-end w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Occupation</label>
                        <input type="text"
                            class="occupation w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Company</label>
                        <input type="text"
                            class="company w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile</label>
                        <input type="tel"
                            class="phone w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                        <input type="email"
                            class="email w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" />
                    </div>
                </div>
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
                <strong>.jpg, .jpeg, .png, .bmp, .doc, .docx, .pdf, .xls, .xlsx</strong>. Maximum file size is 5MB.
            </p>

            <div class="grid grid-cols-1 gap-4">
                <!-- Valid passport with visa page -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Valid Passport with Visa Page *</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" required />
                </div>

                <!-- Highest academic Diploma/Certificate -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Highest Academic Diploma/Certificate
                        *</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" required />
                </div>

                <!-- Highest academic transcripts -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Highest Academic Transcripts *</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" required />
                </div>

                <!-- Non-criminal record -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Non-criminal Record/Certificate of
                        Non-criminal Record *</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" required />
                </div>

                <!-- Bank Statement -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Bank Statement</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                </div>

                <!-- Application Fee Receipt -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Application Fee Receipt</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <p class="text-sm text-gray-500">
                        Please note this application fee is non-refundable.
                    </p>
                </div>

                <!-- Recommendation Letters -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Recommendation Letter(s)</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <p class="text-sm text-gray-500">
                        Provide 2 recommendation letters (for Masters & PhD only).
                    </p>
                </div>

                <!-- Publications, Articles, Thesis -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Publications, Articles, Thesis,
                        etc.</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <p class="text-sm text-gray-500">(For Masters & PhD only)</p>
                </div>

                <!-- Foreigner Physical Examination Form -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Foreigner Physical Examination Form
                        *</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" required />
                </div>

                <!-- Guardian's Letter of Guarantee -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Guardian's Letter of Guarantee</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <p class="text-sm text-gray-500">
                        Applicants under 18 should submit this document.
                    </p>
                </div>

                <!-- English Language Proficiency -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">English Language Proficiency</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <p class="text-sm text-gray-500">
                        Students from English-speaking countries are exempted.
                    </p>
                </div>

                <!-- Chinese Language Certificate (HSK Certificate) -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Chinese Language Certificate (HSK
                        Certificate)</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                </div>

                <!-- Parent's Authorization Letter -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Parent's Authorization Letter</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <p class="text-sm text-gray-500">
                        Applicants under 18 should submit this document.
                    </p>
                </div>

                <!-- Study Plan or Research Proposal -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Study Plan or Research Proposal</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                    <p class="text-sm text-gray-500">For Masters & PhD only</p>
                </div>

                <!-- Curriculum Vitae -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Curriculum Vitae</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                </div>

                <!-- Additional Documents -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Additional Documents</label>
                    <input type="file"
                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                        accept=".jpg,.jpeg,.png,.bmp,.doc,.docx,.pdf,.xls,.xlsx" />
                </div>
            </div>

            <!-- Admission Notice Collection Method -->
            <div class="mt-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">How to Collect the Admission Notice *</label>
                <select class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400"
                    required>
                    <option value="" disabled selected>Select an option</option>
                    <option value="home">The same as home address</option>
                    <option value="current">
                        The same as the current postal address
                    </option>
                    <option value="pickup">Pick Up By Myself</option>
                </select>
                <p class="text-sm text-gray-500 mt-2">
                    Please make sure the postal address you provided is valid for at least
                    3 months to receive admission documents successfully.
                </p>
            </div>
        </div>
    </form>
</div>