<?php
require_once __DIR__ . '/../../../../api/applicants/single_applicant.php';
?>

<div class="flex flex-col md:flex-row max-w-full mx-0 top-0">
    <!--  Start Application Sidebar -->
    <div class="w-full overflow-y-hidden h-full md:min-h-screen md:w-2/5 lg:w-1/4 bg-white shadow-lg p-6 pt-2 md:sticky md:top-0">
        <!-- Back Button -->
        <div>
            <button onclick="loadPage('applicants.html')"
                class="bg-gray-500 text-white py-1 px-2 rounded inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </button>
        </div>

        <h2 class="text-lg font-semibold mb-2 text-gray-800">Application Menu</h2>
        <div class="space-y-4">

            <!-- Payment Status -->
            <div class="bg-green-100 text-green-800 p-2 rounded">
                <strong>Applicant ID: </strong><span id="application_id"><?php echo $applicant['application_id']; ?></span><br>
                <strong>Applicant Status: </strong><?php echo $applicant['status']; ?><br>
                <strong>Payment Status: </strong><?php echo $applicant['payment_status']; ?>
            </div>

            <!-- Update Application Status -->
            <button class="bg-blue-500 text-white w-full inline-block py-2 px-4 rounded"
                onclick="toggleApplicationStatusModal(true)">
                Update Application Status
            </button>

            <!-- Download Form -->
            <a href="#" class="bg-gray-500 text-white w-full inline-block text-center py-2 px-4 rounded"
                onclick="saveForm()">Download Form</a>

            <!-- Add Update Button -->
            <button onclick="toggleAddUpdateModal(true)"
                class="bg-green-500 text-white w-full inline-block py-2 px-4 rounded"> Add Update </button>

            <!-- Move to Updates Button -->
            <a href="#updatesTableBody"
                class="bg-purple-500 text-white w-full inline-block text-center py-2 px-4 rounded hover:bg-purple-600">
                Move to Updates
            </a>

        </div>
    </div>
    <!-- End Application Sidebar -->

    <!-- Container -->
    <div class="flex-1 bg-gray-100 p-4 pt-0 w-full md:w-3/5 lg:3/4 application-form">
        <!-- Application Details -->
        <div id="application_details">
            <h2 class="font-bold text-xl text-black mx-auto p-4 text-center">
                Student Application Form
            </h2>

            <!-- Passport Photo -->
            <div class="flex justify-center mb-6">
                <img src="./images/applicants/<?php echo $applicant['picture'] ?? 'default.png'; ?>" alt="Passport Photo" class="w-32 h-32 rounded-full border-2 border-gray-300">
            </div>

            <!-- Section Heading Styles -->
            <style>
                @layer base {
                    img {
                        display: initial;
                    }
                }

                .section-header {
                    background-color: #edf2f7;
                    /* bg-gray-200 */
                    border: 1px solid #d2d6dc;
                    /* border-gray-300 */
                    font-size: 1.125rem;
                    /* text-lg */
                    font-weight: 600;
                    /* font-semibold */
                    padding: 0.75rem 1rem;
                    /* px-3 py-2 */
                    border-radius: 0.375rem;
                    /* rounded */
                    margin-bottom: 1rem;
                    /* mb-4 */
                    color: #212a39;
                    /* text-gray-800 */
                }
            </style>

            <!-- Personal Information -->
            <h2 class="section-header">Personal Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p id="applicant_name" class="hidden"><?php echo  $applicant['firstname'] . " " . $applicant['lastname'] ?>
                </p>
                <p><strong>Family Name:</strong> <?php echo $applicant['lastname'] ?? 'Not provided'; ?></p>
                <p><strong>Given Name:</strong> <?php echo $applicant['firstname'] ?? 'Not provided'; ?></p>
                <p><strong>Gender:</strong> <?php echo $applicant['gender'] ?? 'Not provided'; ?></p>
                <p><strong>Nationality:</strong> <?php echo $applicant['nationality'] ?? 'Not provided'; ?></p>
                <p><strong>Marital Status:</strong> <?php echo $applicant['marital_status'] ?? 'Not provided'; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo $applicant['dob'] ?? 'Not provided'; ?></p>
                <p><strong>Religion:</strong> <?php echo $applicant['religion'] ?? 'Not provided'; ?></p>
                <p><strong>Country of Birth:</strong> <?php echo $applicant['country_of_birth'] ?? 'Not provided'; ?></p>
                <p><strong>Occupation:</strong> <?php echo $applicant['occupation'] ?? 'Not provided'; ?></p>
                <p><strong>Place of Birth:</strong> <?php echo $applicant['place_of_birth'] ?? 'Not provided'; ?></p>
                <p><strong>Affiliated Institution:</strong> <?php echo $applicant['affiliated_institution'] ?? 'Not provided'; ?></p>
                <p><strong>Currently in China:</strong> <?php echo $applicant['in_china_now'] ?? 'Not provided'; ?></p>
                <p><strong>Native Language:</strong> <?php echo $applicant['native_language'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Address Information -->
            <h2 class="section-header">Address Information</h2>
            <h3 class="font-semibold mb-2 text-gray-700 px-3">Correspondence Address</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 text-gray-700 px-3">
                <p><strong>Detailed Address:</strong> <?php echo $applicant['correspondence_detailed_address'] ?? 'Not provided'; ?> </p>
                <p><strong>City/Province:</strong> <?php echo $applicant['correspondence_city'] ?? 'Not provided'; ?></p>
                <p><strong>Zipcode:</strong> <?php echo $applicant['correspondence_zipcode'] ?? 'Not provided'; ?></p>
                <p><strong>Phone:</strong> <?php echo $applicant['correspondence_phone'] ?? 'Not provided'; ?></p>
                <p><strong>Email:</strong> <?php echo $applicant['correspondence_email'] ?? 'Not provided'; ?></p>
            </div>

            <h3 class="font-semibold mt-4 mb-2 text-gray-700 px-3">Current Address</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Detailed Address:</strong> <?php echo $applicant['applicant_detailed_address'] ?? 'Not provided'; ?></p>
                <p><strong>City/Province:</strong> <?php echo $applicant['applicant_city'] ?? 'Not provided'; ?></p>
                <p><strong>Zipcode:</strong> <?php echo $applicant['applicant_zipcode'] ?? 'Not provided'; ?></p>
                <p><strong>Phone:</strong> <?php echo $applicant['applicant_phone'] ?? 'Not provided'; ?></p>
                <p><strong>Email:</strong> <?php echo $applicant['applicant_email'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Passport Information -->
            <h2 class="section-header">Passport and Visa Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Passport No:</strong> <?php echo $applicant['passport_number'] ?? 'Not provided'; ?></p>
                <p><strong>Start Date:</strong> <?php echo $applicant['passport_start_date'] ?? 'Not provided'; ?></p>
                <p><strong>Expiry Date:</strong> <?php echo $applicant['passport_expiry_date'] ?? 'Not provided'; ?></p>
                <p><strong>Old Passport No:</strong> <?php echo $applicant['old_passport_number'] ?? 'Not provided'; ?></p>
                <p><strong>Old Expiration:</strong> <?php echo $applicant['old_expiry_date'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Financial Sponsor -->
            <h2 class="section-header">Financial Sponsor Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Name:</strong> <?php echo $applicant['fin_sponsor_name'] ?? 'Not provided'; ?></p>
                <p><strong>Relationship:</strong> <?php echo $applicant['fin_sponsor_relationship'] ?? 'Not provided'; ?></p>
                <p><strong>Work Place:</strong> <?php echo $applicant['fin_sponsor_work_place'] ?? 'Not provided'; ?></p>
                <p><strong>Occupation:</strong> <?php echo $applicant['fin_sponsor_occupation'] ?? 'Not provided'; ?></p>
                <p><strong>Email:</strong> <?php echo $applicant['fin_sponsor_email'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Emergency Contact -->
            <h2 class="section-header">Emergency Contact</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Name:</strong> <?php echo $applicant['emergency_contact_name'] ?? 'Not provided'; ?></p>
                <p><strong>Relationship:</strong> <?php echo $applicant['emergency_contact_relationship'] ?? 'Not provided'; ?></p>
                <p><strong>Work Place:</strong> <?php echo $applicant['emergency_contact_work_place'] ?? 'Not provided'; ?></p>
                <p><strong>Occupation:</strong> <?php echo $applicant['emergency_contact_occupation'] ?? 'Not provided'; ?></p>
                <p><strong>Email:</strong> <?php echo $applicant['emergency_contact_email'] ?? 'Not provided'; ?></p>
                <p><strong>Phone:</strong> <?php echo $applicant['emergency_contact_phone'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Major Information -->
            <h2 class="section-header">Major Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Country:</strong> <?php echo $applicant['major_country'] ?? 'Not provided'; ?></p>
                <p><strong>School:</strong> <?php echo $applicant['major_school'] ?? 'Not provided'; ?></p>
                <p><strong>Program:</strong> <?php echo $applicant['major_program'] ?? 'Not provided'; ?></p>
                <p><strong>Teaching Language:</strong> <?php echo $applicant['major_teaching_language'] ?? 'Not provided'; ?></p>
                <p><strong>Entry Year:</strong> <?php echo $applicant['major_entry_year'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Language Proficiency -->
            <h2 class="section-header">Language Proficiency</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>English Proficiency:</strong> <?php echo $applicant['english_proficiency'] ?? 'Not provided'; ?></p>
                <p><strong>Chinese Proficiency:</strong> <?php echo $applicant['chinese_proficiency'] ?? 'Not provided'; ?></p>
                <p><strong>HSK Level:</strong> <?php echo $applicant['hsk_level'] ?? 'Not provided'; ?></p>
                <p><strong>HSK Scores:</strong> <?php echo $applicant['hsk_scores'] ?? 'Not provided'; ?></p>
                <p><strong>HSKK Scores:</strong> <?php echo $applicant['hskk_scores'] ?? 'Not provided'; ?></p>
                <p><strong>Time of Chinese Learning:</strong> <?php echo $applicant['time_of_chinese_learning'] ?? 'Not provided'; ?></p>
                <p><strong>Chinese Teacher Nationality:</strong> <?php echo ($applicant['teacher_nationlity_chinese'] == 1) ? 'Yes' : 'Not provided'; ?></p>
                <p><strong>Chinese Learning Institution:</strong> <?php echo $applicant['chinese_learning_institution'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Education Background -->
            <h2 class="section-header">Education Background</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Highest Degree:</strong> <?php echo $applicant['highest_degree'] ?? 'Not provided'; ?></p>
                <p><strong>Graduation School:</strong> <?php echo $applicant['highest_degree_school'] ?? 'Not provided'; ?></p>
                <p><strong>Certificate Type:</strong> <?php echo $applicant['highest_degree_certificate_type'] ?? 'Not provided'; ?></p>
                <p><strong>Best Mark (out of 100):</strong> <?php echo $applicant['best_mark_if_100'] ?? 'Not provided'; ?></p>
                <p><strong>Worst Mark (out of 100):</strong> <?php echo $applicant['worst_mark_if_100'] ?? 'Not provided'; ?></p>
            </div>

            <!-- Study Experience -->
            <h2 class="section-header">Study Experience</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <?php if (!empty($study_experience)): ?>
                    <?php foreach ($study_experience as $experience): ?>
                        <p><strong>Institution:</strong> <?php echo $experience['institution'] ?? 'Not provided'; ?></p>
                        <p><strong>Degree:</strong> <?php echo $experience['degree'] ?? 'Not provided'; ?></p>
                        <p><strong>Field of Study:</strong> <?php echo $experience['field_of_study'] ?? 'Not provided'; ?></p>
                        <p><strong>Start Date:</strong> <?php echo $experience['start_date'] ?? 'Not provided'; ?></p>
                        <p><strong>End Date:</strong> <?php echo $experience['end_date'] ?? 'Not provided'; ?></p>
                        <hr class="col-span-2 border-2">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No study experience provided.</p>
                <?php endif; ?>
            </div>

            <!-- Work History -->
            <h2 class="section-header">Work History</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <?php if (!empty($work_history)): ?>
                    <?php foreach ($work_history as $work): ?>
                        <p><strong>Position:</strong> <?php echo $work['position'] ?? 'Not provided'; ?></p>
                        <p><strong>Company:</strong> <?php echo $work['company'] ?? 'Not provided'; ?></p>
                        <p><strong>Start Year:</strong> <?php echo $work['start_year'] ?? 'Not provided'; ?></p>
                        <p><strong>End Year:</strong> <?php echo $work['end_year'] ?? 'Not provided'; ?></p>
                        <hr class="col-span-2 border-2">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No work history provided.</p>
                <?php endif; ?>
            </div>

            <!-- Document Uploads -->
            <h2 class="section-header">Uploaded Documents</h2>
            <ul class="list-disc pl-6 text-gray-700 mb-6 px-3">
                <?php
                $documentLabels = [
                    'application_id' => 'Application ID',
                    'passport' => 'Passport',
                    'highest_certificate' => 'Highest Certificate',
                    'academic_transcript' => 'Academic Transcript',
                    'non_criminal_record_certificate' => 'Non-Criminal Record Certificate',
                    'bank_statement' => 'Bank Statement',
                    'application_fee_receipt' => 'Application Fee Receipt',
                    'recommendation_letter' => 'Recommendation Letter',
                    'articles_thesis' => 'Articles/Thesis',
                    'physical_examination_form' => 'Physical Examination Form',
                    'guardian_guarantee_letter' => 'Guardian Guarantee Letter',
                    'english_proficiency' => 'English Proficiency',
                    'hsk_certificate' => 'HSK Certificate',
                    'parent_authorization' => 'Parent Authorization',
                    'research_proposal' => 'Research Proposal',
                    'cv' => 'CV',
                    'additional_document' => 'Additional Document'
                ];
                ?>
                <?php if (!empty($documents)): ?>
                    <?php foreach ($documents as $document => $status): ?>
                        <?php if ($status == 1): ?>
                            <li><?php echo $documentLabels[$document] ?? ucfirst(str_replace('_', ' ', $document)); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No documents uploaded.</li>
                <?php endif; ?>
            </ul>

            <!-- Updates Section -->
            <h2 class="section-header">Updates</h2>
            <div class="mb-5 pb-5 overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Date</th>
                            <th class="py-2 px-4 border-b">Message</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <!-- Updates Table -->
                    <tbody id="updatesTableBody">
                        <?php if (!empty($updates)): ?>
                            <?php foreach ($updates as $update): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b">
                                        <?php echo $update['title']; ?>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <?php echo $update['datetime']; ?>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <?php echo $update['message']; ?>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <button
                                            onclick="toggleEditUpdateModal(true, this)"
                                            class="text-blue-500"
                                            data-id="<?php echo $update['id']; ?>"
                                            data-title="<?php echo htmlspecialchars($update['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                            data-date="<?php echo htmlspecialchars($update['datetime'], ENT_QUOTES, 'UTF-8'); ?>"
                                            data-message="<?php echo htmlspecialchars($update['message'], ENT_QUOTES, 'UTF-8'); ?>">
                                            Edit
                                        </button>
                                        <button onclick="deleteUpdate(<?php echo $update['id']; ?>)" class="text-red-500">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="align-center text-center font-bold py-4 my-2">No Updates Yet</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <!-- Add Update Modal -->
            <div id="addUpdateModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full mx-4 md:mx-0">
                    <h2 class="text-xl font-semibold mb-4">Add Update</h2>
                    <form id="addUpdateForm" onsubmit="addUpdate(event)">
                        <div class="mb-4">
                            <label class="block text-gray-700">Title</label>
                            <input type="text" id="addUpdateTitle" class="w-full border border-gray-300 rounded p-2"
                                placeholder="Enter title">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Time and Date</label>
                            <input type="datetime-local" id="addUpdateDateTime" class="w-full border border-gray-300 rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Message</label>
                            <textarea id="addUpdateMessage" class="w-full border border-gray-300 rounded p-2" rows="4"
                                placeholder="Enter message"></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="toggleAddUpdateModal(false)"
                                class="px-4 py-2 rounded bg-gray-400 text-white">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 rounded bg-blue-500 text-white flex items-center justify-center min-w-[80px]"
                                id="addUpdateBtn">
                                <span class="inline-block">Save</span>
                                <svg class="w-4 h-4 ml-2 hidden animate-spin" id="addUpdateSpinner" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Update Modal -->
            <div id="editUpdateModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full mx-4 md:mx-0">
                    <h2 class="text-xl font-semibold mb-4">Edit Update</h2>
                    <form id="editUpdateForm" onsubmit="editUpdate(event)">
                        <div class="mb-4 hidden">
                            <label class="block text-gray-700">Update ID</label>
                            <input type="text" id="editUpdateId" class="w-full border border-gray-300 rounded p-2"
                                placeholder="ID">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Title</label>
                            <input type="text" id="editUpdateTitle" class="w-full border border-gray-300 rounded p-2"
                                placeholder="Enter title">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Time and Date</label>
                            <input type="datetime-local" id="editUpdateDate" class="w-full border border-gray-300 rounded p-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Message</label>
                            <textarea id="editUpdateMessage" class="w-full border border-gray-300 rounded p-2" rows="4"
                                placeholder="Enter message"></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="toggleEditUpdateModal(false)"
                                class="px-4 py-2 rounded bg-gray-400 text-white">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 rounded bg-blue-500 text-white flex items-center justify-center min-w-[80px]"
                                onclick="editUpdate(event)"
                                id="editUpdateBtn">
                                <span class="inline-block">Save</span>
                                <svg class="w-4 h-4 ml-2 hidden animate-spin" id="editUpdateSpinner" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Application Status Modal -->
            <div id="applicationStatusModal"
                class="hidden fixed inset-0 md:ml-64 mx-auto bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full mx-4 md:mx-0">
                    <h2 class="text-xl font-semibold mb-4">Update Application Status</h2>
                    <form>
                        <div class="mb-4">
                            <label class="block text-gray-700">Application Status</label>
                            <select name="application_status" class="w-full border border-gray-300 rounded p-2">
                                <option value="Processing" <?php echo ($applicant['status'] === 'Processing') ? 'selected' : ''; ?>>Processing</option>
                                <option value="Admitted" <?php echo ($applicant['status'] === 'Admitted') ? 'selected' : ''; ?>>Admitted</option>
                                <option value="Rejected" <?php echo ($applicant['status'] === 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                <option value="Pending Payment" <?php echo ($applicant['status'] === 'Pending Payment') ? 'selected' : ''; ?>>Pending Payment</option>
                                <option value="Pending Processing" <?php echo ($applicant['status'] === 'Pending Processing') ? 'selected' : ''; ?>>Pending Processing</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="toggleApplicationStatusModal(false)"
                                class="px-4 py-2 rounded bg-gray-400 text-white">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 rounded bg-blue-500 text-white flex items-center justify-center min-w-[80px]"
                                onclick="updateApplicationStatus(event)"
                                id="updateStatusBtn">
                                <span class="inline-block">Save</span>
                                <svg class="w-4 h-4 ml-2 hidden animate-spin" id="updateStatusSpinner" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>