

// function loadApplications() {
//     console.log('Applications page loaded!');
//     // JavaScript to handle form navigation and API fetch calls
//     const form = document.getElementById('application-form');
//     const submitBtn = document.getElementById('submit-btn');
//     const saveBtn = document.getElementById('save-btn');

//     form.addEventListener('input', checkFormCompletion);

//     function checkFormCompletion() {
//         const isComplete = Array.from(form.elements).every(input => {
//             return input.type === "file" ? input.files.length > 0 : input.value.trim() !== "";
//         });
//         submitBtn.disabled = !isComplete;
//         submitBtn.classList.toggle('bg-blue-500', isComplete);
//         submitBtn.classList.toggle('bg-gray-300', !isComplete);
//         submitBtn.classList.toggle('cursor-not-allowed', !isComplete);
//     }
// //0246814884
//     saveBtn.addEventListener('click', async (e) => {
//         e.preventDefault();
//         const formData = new FormData();
//         const data = {};

//         // Collect all form field values
//         Array.from(form.elements).forEach(element => {
//             if (element.name && element.value) {
//                 data[element.name] = element.value;
//             }
//         });

//         formData.append('form_data', JSON.stringify(data));

//         try {
//             const response = await fetch('../handlers/formHandler.php', {
//                 method: 'POST',
//                 body: formData
//             });

//             const result = await response.json();
//             if (result.success) {
//                 alert('Form data saved successfully!');
//             } else {
//                 alert('Error saving form data: ' + (result.error || 'Unknown error'));
//             }
//         } catch (error) {
//             console.error('Error saving form data:', error);
//             alert('Failed to save form data. Please try again.');
//         }
//     });

//     submitBtn.addEventListener('click', async (e) => {
//         e.preventDefault();
//         if (form.checkValidity()) {
//             if (confirm('Are you sure you want to submit the application? You won\'t be able to edit it after submission.')) {
//                 const formData = new FormData();
//                 const data = {
//                     status: 'submitted',
//                     submission_date: new Date().toISOString()
//                 };

//                 // Collect all form field values
//                 Array.from(form.elements).forEach(element => {
//                     if (element.name && element.value) {
//                         data[element.name] = element.value;
//                     }
//                 });

//                 formData.append('form_data', JSON.stringify(data));

//                 try {
//                     const response = await fetch('../handlers/formHandler.php', {
//                         method: 'POST',
//                         body: formData
//                     });

//                     const result = await response.json();
//                     if (result.success) {
//                         alert('Application submitted successfully!');
//                         window.location.href = 'dashboard.php'; // Redirect to dashboard
//                     } else {
//                         alert('Error submitting application: ' + (result.error || 'Unknown error'));
//                     }
//                 } catch (error) {
//                     console.error('Error submitting application:', error);
//                     alert('Failed to submit application. Please try again.');
//                 }
//             }
//         } else {
//             alert('Please fill out all required fields.');
//         }
//     });

//     // Load existing form data when page loads
//     async function loadFormData() {
//         try {
//             const response = await fetch('../handlers/formHandler.php');
//             if (response.ok) {
//                 const data = await response.json();
//                 Object.keys(data).forEach(fieldName => {
//                     const field = form.querySelector(`[name="${fieldName}"]`);
//                     if (field) {
//                         field.value = data[fieldName];
//                     }
//                 });
//                 checkFormCompletion();
//             }
//         } catch (error) {
//             console.error('Error loading form data:', error);
//         }
//     }

//     // Load form data when page loads
//     loadFormData();

//     // JavaScript to Add More Entries  
//     document.getElementById('add-study-entry').addEventListener('click', () => {
//         const studyContainer = document.getElementById('study-experience-container');
//         const newEntry = document.createElement('div');
//         newEntry.className = 'study-entry grid grid-cols-1 md:grid-cols-2 gap-4 mt-4';
//         newEntry.innerHTML = `
//             <h2 class="text-xl font-bold text-gray-700">Next School</h2>
//             <br>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">School Name *</label>
//                 <input type="text" class="school-name w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Degree *</label>
//                 <input type="text" class="degree w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Year of Attendance (From - To) *</label>
//                 <input type="text" class="attendance-period w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400" required>
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Contact Person</label>
//                 <input type="text" class="contact-person w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
//             </div>
//         `;
//         studyContainer.appendChild(newEntry);
//     });

//     document.getElementById('add-work-entry').addEventListener('click', () => {
//         const workContainer = document.getElementById('work-history-container');
//         const newEntry = document.createElement('div');
//         newEntry.className = 'work-entry grid grid-cols-1 md:grid-cols-2 gap-4 mt-4';
//         newEntry.innerHTML = `
//                 <h2 class="text-xl font-bold text-gray-700">Next Work Experience</h2>
//             <br>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Starting Time</label>
//                 <input type="date" class="work-start w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Ending Time</label>
//                 <input type="date" class="work-end w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Occupation</label>
//                 <input type="text" class="occupation w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Company</label>
//                 <input type="text" class="company w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Phone/Mobile</label>
//                 <input type="tel" class="phone w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
//             </div>
//             <div>
//                 <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
//                 <input type="email" class="email w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-400">
//             </div>
//         `;
//         workContainer.appendChild(newEntry);
//     });


//     const nationalitySelect = document.getElementById('nationality');
//     const selectedNationality = nationalitySelect.dataset.selected; // Get the value set by PHP

//     // Assume options are dynamically populated elsewhere in your script
//     Array.from(nationalitySelect.options).forEach(option => {
//         if (option.value.toLowerCase() === selectedNationality.toLowerCase()) {
//             option.selected = true;
//         }
//     });

//     // Populate religion options with a custom list
//     const religions = ["Christianity", "Islam", "Hinduism", "Buddhism", "Sikhism", "Judaism", "Atheism", "Other"];
//     const religionInput = document.getElementById("religion");

//     religions.forEach(religion => {
//         let religionOption = document.createElement("option");
//         religionOption.value = religion;
//         religionOption.text = religion;
//         religionInput.add(religionOption);
//     });

//    // populateFormOptions();

//     // Fetch schools based on country
//     function fetchSchools() {
//         const countryId = document.getElementById('country').value;
//         fetchData('school', countryId, 'country_id', 'school');
//     }

//     // Fetch degrees based on school
//     function fetchDegrees() {
//         const schoolId = document.getElementById('school').value;
//         fetchData('degree', schoolId, 'school_id', 'degree');
//     }

//     // Fetch programs based on degree
//     function fetchPrograms() {
//         const schoolId = document.getElementById('school').value;
//         const degree = document.getElementById('degree').value;
//         fetchData('program', { school_id: schoolId, degree: degree }, 'program');
//     }

//     // Display study duration based on program
//     function showDuration() {
//         const programId = document.getElementById('program').value;
//         fetchData('duration', programId, 'program_id', 'study-duration', true);
//     }

//     // General function to fetch data and populate dropdowns
//     function fetchData(type, id, filter, targetId, isDuration = false) {
//         fetch(`get_data.php?type=${type}&id=${id}&filter=${filter}`)
//             .then(response => response.json())
//             .then(data => {
//                 if (isDuration) {
//                     document.getElementById(targetId).value = data.duration;
//                 } else {
//                     populateOptions(data, targetId);
//                 }
//             })
//             .catch(error => console.error("Error fetching data:", error));
//     }

//     // Populate dropdown with options
//     function populateOptions(data, targetId) {
//         const dropdown = document.getElementById(targetId);
//         dropdown.innerHTML = `<option value="">Select ${targetId}</option>`;
//         data.forEach(item => {
//             const option = document.createElement('option');
//             option.value = item.id;
//             option.textContent = item.name;
//             dropdown.appendChild(option);
//         });
//     }

//     const countrySelect = document.getElementById("country");
//     const schoolSelect = document.getElementById("school");
//     const degreeSelect = document.getElementById("degree");
//     const programSelect = document.getElementById("program");
//     const studyDurationInput = document.getElementById("study-duration");

//     let data = {};

//     // Fetch data from JSON file
//     fetch('../../../api/majorInfo/majorInfo.json')
//         .then(response => response.json())
//         .then(jsonData => {
//             data = jsonData;
//             populateCountries(data.countries);
//         })
//         .catch(error => console.error("Error fetching data:", error));

//     // Populate countries
//     function populateCountries(countries) {
//         countrySelect.innerHTML = '<option value="">Select Country</option>';
//         countries.forEach(country => {
//             const option = new Option(country.country_name, country.id);
//             countrySelect.add(option);
//         });
//     }

//     // Country selection changes
//     countrySelect.addEventListener("change", () => {
//         const selectedCountryId = countrySelect.value;
//         const filteredSchools = data.schools.filter(school => school.country_id === selectedCountryId);
//         populateSchools(filteredSchools);
//         resetSelections(["school", "degree", "program"]);
//     });

//     // Populate schools
//     function populateSchools(schools) {
//         schoolSelect.innerHTML = '<option value="">Select School</option>';
//         schools.forEach(school => {
//             const option = new Option(school.school_name, school.id);
//             schoolSelect.add(option);
//         });
//     }

//     // School selection changes
//     schoolSelect.addEventListener("change", () => {
//         const selectedSchoolId = schoolSelect.value;
//         const filteredPrograms = data.programs.filter(program => program.school_id === selectedSchoolId);
//         const uniqueDegrees = Array.from(new Set(filteredPrograms.map(program => program.degree)));
//         populateDegrees(uniqueDegrees);
//         resetSelections(["degree", "program"]);
//     });

//     // Populate degrees
//     function populateDegrees(degrees) {
//         degreeSelect.innerHTML = '<option value="">Select Degree</option>';
//         degrees.forEach(degree => {
//             const option = new Option(degree, degree); // Using degree name as both value and display text
//             degreeSelect.add(option);
//         });
//     }

//     // Degree selection changes
//     degreeSelect.addEventListener("change", () => {
//         const selectedSchoolId = schoolSelect.value;
//         const selectedDegree = degreeSelect.value;
//         const filteredPrograms = data.programs.filter(
//             program => program.school_id === selectedSchoolId && program.degree === selectedDegree
//         );
//         populatePrograms(filteredPrograms);
//     });

//     // Populate programs and set study duration
//     function populatePrograms(programs) {
//         programSelect.innerHTML = '<option value="">Select Program</option>';
//         programs.forEach(program => {
//             const option = new Option(program.program_name, program.id);
//             programSelect.add(option);
//         });
//         studyDurationInput.value = "";
//     }

//     // Program selection changes
//     programSelect.addEventListener("change", () => {
//         const selectedProgramId = programSelect.value;
//         const selectedProgram = data.programs.find(p => p.id === selectedProgramId);
//         studyDurationInput.value = selectedProgram ? selectedProgram.duration : "";
//     });

//     // Reset dependent dropdowns
//     function resetSelections(elements) {
//         elements.forEach(id => {
//             document.getElementById(id).innerHTML = `<option value="">Select ${id.charAt(0).toUpperCase() + id.slice(1)}</option>`;
//         });
//     }
// }
