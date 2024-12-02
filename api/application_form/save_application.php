<?php
// Start session to access the application ID from session
session_start();

// Ensure the application_id is set
if (!isset($_SESSION['application_id'])) {
    die('Error: Application ID not found.');
}else{
    require_once __DIR__ . '/../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
}

// Get application_id from session
$applicationId = $_SESSION['application_id'];

// Prepare SQL query to update the data in the database
$sql = "
    UPDATE applications
    SET 
        lname = :lname,
        fname = :fname,
        gender = :gender,
        passport = :passport,
        nationality = :nationality,
        marital_status = :marital_status,
        dob = :dob,
        religion = :religion,
        country_of_birth = :country_of_birth,
        occupation = :occupation,
        place_of_birth = :place_of_birth,
        employer = :employer,
        in_china_now = :in_china_now,
        native_language = :native_language,
        correspondence_detailed_address = :correspondence_detailed_address,
        correspondence_city = :correspondence_city,
        correspondence_zipcode = :correspondence_zipcode,
        correspondence_country = :correspondence_country,
        correspondence_phone = :correspondence_phone,
        correspondence_email = :correspondence_email,
        applicant_detailed_address = :applicant_detailed_address,
        applicant_city = :applicant_city,
        applicant_zipcode = :applicant_zipcode,
        applicant_country = :applicant_country,
        applicant_phone = :applicant_phone,
        applicant_email = :applicant_email,
        passport_number = :passport_number,
        passport_start_date = :passport_start_date,
        passport_expiry_date = :passport_expiry_date,
        old_passport_number = :old_passport_number,
        old_expiry_date = :old_expiry_date,
        studied_in_china = :studied_in_china,
        visa_type = :visa_type,
        visa_expiry_date = :visa_expiry_date,
        institution_in_china_studying = :institution_in_china_studying,
        sponsor_name = :sponsor_name,
        sponsor_relationship = :sponsor_relationship,
        sponsor_workplace = :sponsor_workplace,
        sponsor_occupation = :sponsor_occupation,
        sponsor_email = :sponsor_email,
        sponsor_phone = :sponsor_phone,
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
        study_duration = :study_duration,
        english_proficiency = :english_proficiency,
        english_proficiency_certificate = :english_proficiency_certificate,
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
        worst_mark_if_100 = :worst_mark_if_100,
        study_experience = :study_experience,
        work_history = :work_history,
        valid_passport = :valid_passport,
        highest_academic_diploma = :highest_academic_diploma,
        highest_academic_transcripts = :highest_academic_transcripts,
        non_criminal_record = :non_criminal_record,
        bank_statement = :bank_statement,
        application_fee_receipt = :application_fee_receipt,
        recommendation_letters = :recommendation_letters,
        publications_articles_thesis = :publications_articles_thesis,
        physical_examination_form = :physical_examination_form,
        guardians_letter_of_guarantee = :guardians_letter_of_guarantee,
        english_language_proficiency = :english_language_proficiency,
        chinese_language_certificate = :chinese_language_certificate,
        parents_authorization_letter = :parents_authorization_letter,
        study_plan_research_proposal = :study_plan_research_proposal,
        curriculum_vitae = :curriculum_vitae
    WHERE application_id = :application_id
";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind the form data to the SQL query
$stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);
$stmt->bindParam(':lname', $_POST['lname']);
$stmt->bindParam(':fname', $_POST['fname']);
$stmt->bindParam(':gender', $_POST['gender']);
$stmt->bindParam(':passport', json_encode($_POST['passport'])); // If passport is an object, convert it to JSON
$stmt->bindParam(':nationality', $_POST['nationality']);
$stmt->bindParam(':marital_status', $_POST['marital-status']);
$stmt->bindParam(':dob', $_POST['dob']);
$stmt->bindParam(':religion', $_POST['religion']);
$stmt->bindParam(':country_of_birth', $_POST['country_of_birth']);
$stmt->bindParam(':occupation', $_POST['occupation']);
$stmt->bindParam(':place_of_birth', $_POST['place_of_birth']);
$stmt->bindParam(':employer', $_POST['employer']);
$stmt->bindParam(':in_china_now', $_POST['in_china_now']);
$stmt->bindParam(':native_language', $_POST['native_language']);
$stmt->bindParam(':correspondence_detailed_address', $_POST['correspondence_detailed_address']);
$stmt->bindParam(':correspondence_city', $_POST['correspondence_city']);
$stmt->bindParam(':correspondence_zipcode', $_POST['correspondence_zipcode']);
$stmt->bindParam(':correspondence_country', $_POST['correspondence_country']);
$stmt->bindParam(':correspondence_phone', $_POST['correspondence_phone']);
$stmt->bindParam(':correspondence_email', $_POST['correspondence_email']);
$stmt->bindParam(':applicant_detailed_address', $_POST['applicant_detailed_address']);
$stmt->bindParam(':applicant_city', $_POST['applicant_city']);
$stmt->bindParam(':applicant_zipcode', $_POST['applicant_zipcode']);
$stmt->bindParam(':applicant_country', $_POST['applicant_country']);
$stmt->bindParam(':applicant_phone', $_POST['applicant_phone']);
$stmt->bindParam(':applicant_email', $_POST['applicant_email']);
$stmt->bindParam(':passport_number', $_POST['passport_number']);
$stmt->bindParam(':passport_start_date', $_POST['passport_start_date']);
$stmt->bindParam(':passport_expiry_date', $_POST['passport_expiry_date']);
$stmt->bindParam(':old_passport_number', $_POST['old_passport_number']);
$stmt->bindParam(':old_expiry_date', $_POST['old_expiry_date']);
$stmt->bindParam(':studied_in_china', $_POST['studied_in_china']);
$stmt->bindParam(':visa_type', $_POST['visa_type']);
$stmt->bindParam(':visa_expiry_date', $_POST['visa_expiry_date']);
$stmt->bindParam(':institution_in_china_studying', $_POST['institution_in_china_studying']);
$stmt->bindParam(':sponsor_name', $_POST['sponsor_name']);
$stmt->bindParam(':sponsor_relationship', $_POST['sponsor_relationship']);
$stmt->bindParam(':sponsor_workplace', $_POST['sponsor_workplace']);
$stmt->bindParam(':sponsor_occupation', $_POST['sponsor_occupation']);
$stmt->bindParam(':sponsor_email', $_POST['sponsor_email']);
$stmt->bindParam(':sponsor_phone', $_POST['sponsor_phone']);
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
$stmt->bindParam(':study_duration', $_POST['study_duration']);
$stmt->bindParam(':english_proficiency', $_POST['english_proficiency']);
$stmt->bindParam(':english_proficiency_certificate', json_encode($_POST['english_proficiency_certificate']));
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
$stmt->bindParam(':study_experience', json_encode($_POST['study_experience']));
$stmt->bindParam(':work_history', json_encode($_POST['work_history']));
// Continue binding the rest of the fields

// Execute the update
if ($stmt->execute()) {
    echo "Application updated successfully.";
} else {
    echo "Error: Could not update the application.";
}
