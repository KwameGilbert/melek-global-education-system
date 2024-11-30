

function loadApplications() {
    document.getElementById('add-study-entry').addEventListener('click', function (event) {
        const applicationForm = document.getElementById('application-form');
        event.preventDefault();
        const container = document.getElementById('study-experience-container');
        const newEntry = document.querySelector('.study-entry').cloneNode(true);
        container.appendChild(newEntry);
    });

}
// //0246814884