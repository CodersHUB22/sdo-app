document.addEventListener("DOMContentLoaded", function() {
    // Event listener for edit button click
    document.querySelectorAll('.edit-button').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var applicationId = this.getAttribute('data-id');
            
            // Fetch request to retrieve application data
            fetch('edit-application.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ appId: applicationId })
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(function(data) {
                // Populate the modal with fetched data
                document.getElementById('editAppImage').src = data.application_image;
                document.getElementById('editAppTitle').value = data.application_title;
                document.getElementById('editAppDescription').value = data.application_description;
                document.getElementById('editAppLink').value = data.application_link;
                document.getElementById('editAppColor').value = data.application_color;
                
                // Show the edit modal
                $('#editApplicationModal').modal('show');
            })
            .catch(console.error);
        });
    });
});