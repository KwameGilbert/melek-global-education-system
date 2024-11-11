<div class="flex flex-col md:flex-row max-w-full mx-0 top-0">
    <!--  Start Application Sidebar -->
    <div
        class="w-full overflow-y-hidden h-full md:min-h-screen md:w-1/4 bg-white shadow-lg p-6 pt-2 md:sticky md:top-0">
        <!-- Back Button -->
        <div>
            <button onclick="loadPage('applicants.html')"
                class="bg-gray-500 text-white py-1 px-2 rounded inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
        </div>

        <h2 class="text-lg font-semibold mb-2 text-gray-800"> Application Menu </h2>
        <div class="space-y-4">
            
            <!-- Payment Status -->
            <div class="bg-green-100 text-green-800 p-2 rounded">
                <strong>Applicant ID:</strong> A1324
                <br>
                <strong>Applicant Status:</strong> Pending Processing
                <br>
                <strong>Payment Status:</strong> Paid
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
    <div class="flex-1 bg-gray-100 p-4 pt-0 w-full application-form">
        <div>
            <h2 class="font-bold text-xl text-black mx-auto p-4 text-center">
                Student Application Form
            </h2>

            <!-- Passport Photo -->
            <div class="flex justify-center mb-6">
                <img src="./images/public.png" alt="Passport Photo" class="w-32 h-32 rounded-full border-2 border-gray-300">
            </div>

            <!-- Section Heading Styles -->
            <style>
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
                <p><strong>Family Name:</strong> Doe</p>
                <p><strong>Given Name:</strong> John</p>
                <p><strong>Gender:</strong> Male</p>
                <p><strong>Nationality:</strong> American</p>
                <p><strong>Marital Status:</strong> Single</p>
                <p><strong>Date of Birth:</strong> 1990-01-01</p>
                <p><strong>Religion:</strong> Christianity</p>
                <p><strong>Country of Birth:</strong> USA</p>
                <p><strong>Occupation:</strong> Software Engineer</p>
                <p><strong>Place of Birth:</strong> New York</p>
                <p><strong>Employer:</strong> ABC Corp</p>
                <p><strong>Currently in China:</strong> No</p>
                <p><strong>Native Language:</strong> English</p>
            </div>

            <!-- Address Information -->
            <h2 class="section-header">Address Information</h2>
            <h3 class="font-semibold mb-2 text-gray-700 px-3">Correspondence Address</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 text-gray-700 px-3">
                <p><strong>Detailed Address:</strong> 123 Main St, Apt 4B</p>
                <p><strong>City/Province:</strong> New York</p>
                <p><strong>Zipcode:</strong> 10001</p>
                <p><strong>Phone:</strong> +1-555-0100</p>
                <p><strong>Email:</strong> johndoe@example.com</p>
            </div>

            <h3 class="font-semibold mt-4 mb-2 text-gray-700 px-3">Current Address</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Detailed Address:</strong> 456 Elm St, Apt 12C</p>
                <p><strong>City/Province:</strong> Boston</p>
                <p><strong>Zipcode:</strong> 02118</p>
                <p><strong>Phone:</strong> +1-555-0101</p>
                <p><strong>Email:</strong> john.doe@workmail.com</p>
            </div>

            <!-- Passport Information -->
            <h2 class="section-header">Passport and Visa Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Passport No:</strong> ABC1234567</p>
                <p><strong>Start Date:</strong> 2018-01-01</p>
                <p><strong>Expiry Date:</strong> 2028-01-01</p>
                <p><strong>Old Passport No:</strong> XYZ9876543</p>
                <p><strong>Old Expiration:</strong> 2017-12-31</p>
            </div>

            <!-- Financial Sponsor -->
            <h2 class="section-header">Financial Sponsor Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Name:</strong> Jane Doe</p>
                <p><strong>Relationship:</strong> Mother</p>
                <p><strong>Work Place:</strong> XYZ Corp</p>
                <p><strong>Occupation:</strong> Financial Analyst</p>
                <p><strong>Email:</strong> janedoe@example.com</p>
                <p><strong>Phone:</strong> +1-555-0202</p>
            </div>

            <!-- Emergency Contact -->
            <h2 class="section-header">Emergency Contact</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Name:</strong> Alex Doe</p>
                <p><strong>Relationship:</strong> Brother</p>
                <p><strong>Work Place:</strong> LMN Co.</p>
                <p><strong>Occupation:</strong> Project Manager</p>
                <p><strong>Email:</strong> alexdoe@example.com</p>
                <p><strong>Phone:</strong> +1-555-0303</p>
            </div>

            <!-- Major Information -->
            <h2 class="section-header">Major Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Degree:</strong> Bachelor’s</p>
                <p><strong>Program:</strong> Computer Science</p>
                <p><strong>Teaching Language:</strong> English</p>
                <p><strong>Entry Year:</strong> 2022</p>
                <p><strong>Study Duration:</strong> 4 years</p>
            </div>

            <!-- Language Proficiency -->
            <h2 class="section-header">Language Proficiency</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>English Proficiency:</strong> Fluent</p>
                <p><strong>Chinese Proficiency:</strong> Intermediate</p>
                <p><strong>HSK Level:</strong> 4</p>
                <p><strong>Chinese Learning Institution:</strong> Beijing Language University</p>
            </div>

            <!-- Education Background -->
            <h2 class="section-header">Education Background</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Highest Degree:</strong> High School Diploma</p>
                <p><strong>Graduation School:</strong> Riverside High School</p>
                <p><strong>Graduation Marks:</strong> 85%</p>
            </div>

            <!-- Study Experience -->
            <h2 class="section-header">Study Experience</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>High School:</strong> Riverside High School (2006-2010)</p>
                <p><strong>University:</strong> ABC University (2010-2014)</p>
            </div>

            <!-- Work History -->
            <h2 class="section-header">Work History</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>2015-2018:</strong> Software Developer at ABC Corp</p>
                <p><strong>2019-Present:</strong> Senior Developer at XYZ Solutions</p>
            </div>

            <!-- Family Members -->
            <h2 class="section-header">Family Members</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-gray-700 px-3">
                <p><strong>Mother:</strong> Jane Doe - Financial Analyst</p>
                <p><strong>Father:</strong> John Doe Sr. - Retired</p>
            </div>

            <!-- Document Uploads -->
            <h2 class="section-header">Uploaded Documents</h2>
            <ul class="list-disc pl-6 text-gray-700 mb-6 px-3">
                <li>Valid Passport with Visa</li>
                <li>Highest Academic Diploma</li>
                <li>Non-criminal Record</li>
                <li>Bank Statement</li>
            </ul>
        </div>

        <!-- Updates Section -->
        <h2 class="section-header">Updates</h2>
        <div class="overflow-x-auto">
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
                    <?php $updates = [
                        ['id' => 1, 'title' => 'Application Submitted', 'date' => '2024-10-01T10:30', 'message' => 'Application submitted successfully.'],
                        ['id' => 2, 'title' => 'Application Approved', 'date' => '2024-10-05T10:30', 'message' => 'Application approved by the admissions office.'],
                        ['id' => 3, 'title' => 'Visa Issued', 'date' => '2024-10-10T10:30', 'message' => 'Visa issued by the Chinese consulate.'],
                    ]; ?>

                    <?php foreach ($updates as $update): ?>
                        <tr>
                            <td class="py-2 px-4 border-b">
                                <?php echo $update['title']; ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?php echo $update['date']; ?>
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
                                    data-date="<?php echo htmlspecialchars($update['date'], ENT_QUOTES, 'UTF-8'); ?>"
                                    data-message="<?php echo htmlspecialchars($update['message'], ENT_QUOTES, 'UTF-8'); ?>">
                                    Edit
                                </button>
                                <button onclick="deleteUpdate(<?php echo $update['id']; ?>)" class="text-red-500">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <div>
        <!-- Add Update Modal -->
        <div id="addUpdateModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full mx-4 md:mx-0">
                <h2 class="text-xl font-semibold mb-4">Add Update</h2>
                <form id="addUpdateForm">
                    <div class="mb-4">
                        <label class="block text-gray-700">Title</label>
                        <input type="text" id="addUpdateTitle" class="w-full border border-gray-300 rounded p-2"
                            placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Time and Date</label>
                        <input type="datetime-local" id="addUpdateDate" class="w-full border border-gray-300 rounded p-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Message</label>
                        <textarea id="addUpdateMessage" class="w-full border border-gray-300 rounded p-2" rows="4"
                            placeholder="Enter message"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Attach File</label>
                        <input type="file" id="addUpdateFile" class="w-full border border-gray-300 rounded p-2">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="toggleAddUpdateModal(false)"
                            class="px-4 py-2 rounded bg-gray-400 text-white">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Update Modal -->
        <div id="editUpdateModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full mx-4 md:mx-0">
                <h2 class="text-xl font-semibold mb-4">Edit Update</h2>
                <form id="editUpdateForm">
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
                    <div class="mb-4">
                        <label class="block text-gray-700">Attach File</label>
                        <input type="file" id="editUpdateFile" class="w-full border border-gray-300 rounded p-2">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="toggleEditUpdateModal(false)"
                            class="px-4 py-2 rounded bg-gray-400 text-white">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white">Save</button>
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
                        <input type="text" class="w-full border border-gray-300 rounded p-2"
                            placeholder="Enter application status">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="toggleApplicationStatusModal(false)"
                            class="px-4 py-2 rounded bg-gray-400 text-white">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>