<?php
// Start session to access the application ID from session
session_start();

// Ensure the application_id is set
if (!isset($_SESSION['application_id'])) {
    die('Error: Application ID not found.');
} else {
    require_once __DIR__ . '/../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
}

// Get application_id from session
$applicationId = $_SESSION['application_id'];

try {

    // Prepare SQL query to update the data in the database
    $sql = "
    UPDATE application_details
    SET 
        firstname = :firstname,
        lastname = :lastname,
        gender = :gender,
        nationality = :nationality,
        marital_status = :marital_status,
        dob = :dob,
        religion = :religion,
        country_of_birth = :country_of_birth,
        occupation = :occupation,
        place_of_birth = :place_of_birth,
        affiliated_institution = :affiliated_institution,
        in_china_now = :in_china_now,
        native_language = :native_language,
        correspondence_detailed_address = :correspondence_detailed_address,
        correspondence_city = :correspondence_city,
        correspondence_zipcode = :correspondence_zipcode,
        correspondence_phone = :correspondence_phone,
        correspondence_email = :correspondence_email,
        correspondence_country = :correspondence_country,
        applicant_detailed_address = :applicant_detailed_address,
        applicant_city = :applicant_city,
        applicant_zipcode = :applicant_zipcode,
        applicant_phone = :applicant_phone,
        applicant_email = :applicant_email,
        applicant_country = :applicant_country,
        passport_number = :passport_number,
        passport_start_date = :passport_start_date,
        passport_expiry_date = :passport_expiry_date,
        old_passport_number = :old_passport_number,
        old_expiry_date = :old_expiry_date,
        studied_in_china = :studied_in_china,
        visa_type = :visa_type,
        visa_expiry_date = :visa_expiry_date,
        institution_in_china_studying = :institution_in_china_studying,
        fin_sponsor_name = :fin_sponsor_name,
        fin_sponsor_relationship = :fin_sponsor_relationship,
        fin_sponsor_work_place = :fin_sponsor_work_place,
        fin_sponsor_occupation = :fin_sponsor_occupation,
        fin_sponsor_email = :fin_sponsor_email,
        fin_sponsor_phone = :fin_sponsor_phone,
        guarantor_name = :guarantor_name,
        guarantor_relationship = :guarantor_relationship,
        guarantor_work_place = :guarantor_work_place,
        guarantor_occupation = :guarantor_occupation,
        guarantor_email = :guarantor_email,
        guarantor_phone = :guarantor_phone,
        emergency_contact_name = :emergency_contact_name,
        emergency_contact_relationship = :emergency_contact_relationship,
        emergency_contact_work_place = :emergency_contact_work_place,
        emergency_contact_occupation = :emergency_contact_occupation,
        emergency_contact_email = :emergency_contact_email,
        emergency_contact_phone = :emergency_contact_phone,
        major_country = :major_country,
        major_school = :major_school,
        major_degree = :major_degree,
        major_program = :major_program,
        english_proficiency = :english_proficiency,
        chinese_proficiency = :chinese_proficiency,
        hsk_level = :hsk_level,
        hsk_scores = :hsk_scores,
        hskk_scores = :hskk_scores,
        time_of_chinese_learning = :time_of_chinese_learning,
        chinese_learning_institution = :chinese_learning_institution,
        highest_degree = :highest_degree,
        highest_degree_school = :highest_degree_school,
        highest_degree_certificate_type = :highest_degree_certificate_type,
        best_mark_if_100 = :best_mark_if_100,
        worst_mark_if_100 = :worst_mark_if_100
    WHERE application_id = :application_id
";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind the form data to the SQL query
    $stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);
    $stmt->bindParam(':firstname', $_POST['firstname']);
    $stmt->bindParam(':lastname', $_POST['lastname']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':nationality', $_POST['nationality']);
    $stmt->bindParam(':marital_status', $_POST['marital_status']);
    $stmt->bindParam(':dob', $_POST['dob']);
    $stmt->bindParam(':religion', $_POST['religion']);
    $stmt->bindParam(':country_of_birth', $_POST['country_of_birth']);
    $stmt->bindParam(':occupation', $_POST['occupation']);
    $stmt->bindParam(':place_of_birth', $_POST['place_of_birth']);
    $stmt->bindParam(':affiliated_institution', $_POST['affiliated_institution']);
    $stmt->bindParam(':in_china_now', $_POST['in_china_now']);
    $stmt->bindParam(':native_language', $_POST['native_language']);
    $stmt->bindParam(':correspondence_detailed_address', $_POST['correspondence_detailed_address']);
    $stmt->bindParam(':correspondence_city', $_POST['correspondence_city']);
    $stmt->bindParam(':correspondence_zipcode', $_POST['correspondence_zipcode']);
    $stmt->bindParam(':correspondence_phone', $_POST['correspondence_phone']);
    $stmt->bindParam(':correspondence_email', $_POST['correspondence_email']);
    $stmt->bindParam(':correspondence_country', $_POST['correspondence_country']);
    $stmt->bindParam(':applicant_detailed_address', $_POST['applicant_detailed_address']);
    $stmt->bindParam(':applicant_city', $_POST['applicant_city']);
    $stmt->bindParam(':applicant_zipcode', $_POST['applicant_zipcode']);
    $stmt->bindParam(':applicant_phone', $_POST['applicant_phone']);
    $stmt->bindParam(':applicant_email', $_POST['applicant_email']);
    $stmt->bindParam(':applicant_country', $_POST['applicant_country']);
    $stmt->bindParam(':passport_number', $_POST['passport_number']);
    $stmt->bindParam(':passport_start_date', $_POST['passport_start_date']);
    $stmt->bindParam(':passport_expiry_date', $_POST['passport_expiry_date']);
    $stmt->bindParam(':old_passport_number', $_POST['old_passport_number']);
    $stmt->bindParam(':old_expiry_date', $_POST['old_expiry_date']);
    $stmt->bindParam(':studied_in_china', $_POST['studied_in_china']);
    $stmt->bindParam(':visa_type', $_POST['visa_type']);
    $stmt->bindParam(':visa_expiry_date', $_POST['visa_expiry_date']);
    $stmt->bindParam(':institution_in_china_studying', $_POST['institution_in_china_studying']);
    $stmt->bindParam(':fin_sponsor_name', $_POST['fin_sponsor_name']);
    $stmt->bindParam(':fin_sponsor_relationship', $_POST['fin_sponsor_relationship']);
    $stmt->bindParam(':fin_sponsor_work_place', $_POST['fin_sponsor_work_place']);
    $stmt->bindParam(':fin_sponsor_occupation', $_POST['fin_sponsor_occupation']);
    $stmt->bindParam(':fin_sponsor_email', $_POST['fin_sponsor_email']);
    $stmt->bindParam(':fin_sponsor_phone', $_POST['fin_sponsor_phone']);
    $stmt->bindParam(':guarantor_name', $_POST['guarantor_name']);
    $stmt->bindParam(':guarantor_relationship', $_POST['guarantor_relationship']);
    $stmt->bindParam(':guarantor_work_place', $_POST['guarantor_work_place']);
    $stmt->bindParam(':guarantor_occupation', $_POST['guarantor_occupation']);
    $stmt->bindParam(':guarantor_email', $_POST['guarantor_email']);
    $stmt->bindParam(':guarantor_phone', $_POST['guarantor_phone']);
    $stmt->bindParam(':emergency_contact_name', $_POST['emergency_contact_name']);
    $stmt->bindParam(':emergency_contact_relationship', $_POST['emergency_contact_relationship']);
    $stmt->bindParam(':emergency_contact_work_place', $_POST['emergency_contact_work_place']);
    $stmt->bindParam(':emergency_contact_occupation', $_POST['emergency_contact_occupation']);
    $stmt->bindParam(':emergency_contact_email', $_POST['emergency_contact_email']);
    $stmt->bindParam(':emergency_contact_phone', $_POST['emergency_contact_phone']);
    $stmt->bindParam(':major_country', $_POST['major_country']);
    $stmt->bindParam(':major_school', $_POST['major_school']);
    $stmt->bindParam(':major_degree', $_POST['major_degree']);
    $stmt->bindParam(':major_program', $_POST['major_program']);
    $stmt->bindParam(':english_proficiency', $_POST['english_proficiency']);
    $stmt->bindParam(':chinese_proficiency', $_POST['chinese_proficiency']);
    $stmt->bindParam(':hsk_level', $_POST['hsk_level']);
    $stmt->bindParam(':hsk_scores', $_POST['hsk_scores']);
    $stmt->bindParam(':hskk_scores', $_POST['hskk_scores']);
    $stmt->bindParam(':time_of_chinese_learning', $_POST['time_of_chinese_learning']);
    $stmt->bindParam(':chinese_learning_institution', $_POST['chinese_learning_institution']);
    $stmt->bindParam(':highest_degree', $_POST['highest_degree']);
    $stmt->bindParam(':highest_degree_school', $_POST['highest_degree_school']);
    $stmt->bindParam(':highest_degree_certificate_type', $_POST['highest_degree_certificate_type']);
    $stmt->bindParam(':best_mark_if_100', $_POST['best_mark_if_100']);
    $stmt->bindParam(':worst_mark_if_100', $_POST['worst_mark_if_100']);

    // Execute the update
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Application updated successfully'
        ]);
    } else {
        throw new Exception('Falid to update application');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error updating application: ' . $e->getMessage()
    ]);
    exit;
}
// Continue binding the rest of the fields
