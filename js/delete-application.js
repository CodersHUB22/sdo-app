document.addEventListener("DOMContentLoaded", function() {
    // Attach event listener to all delete buttons
    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior

            var applicationId = this.getAttribute('data-application-id');
            confirmDelete(applicationId); // Call function to display SweetAlert confirmation
        });
    });

    // Function to display SweetAlert confirmation
    function confirmDelete(applicationId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this application',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, proceed with deletion
                window.location.href = 'delete-application.php?id=' + applicationId;
            }
        });
    }
});