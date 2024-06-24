function displayProfilePic() {
    const input = document.getElementById('profile-pic');
    const preview = document.getElementById('preview-profile');

    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = 'img/white-background.jpg';
        preview.style.display = 'none';
    }
}

function previewImage() {
    const input = document.getElementById('appImage');
    const preview = document.getElementById('preview-image');

    const file = input.files[0];
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = 'img/white-background.jpg';
        preview.style.display = 'none';
    }
}

function previewEditImage(applicationId) {
    const fileInput = document.getElementById('editAppImage');
    const previewImage = document.getElementById('preview-edit-image-' + applicationId);
    const previewImageContainer = document.getElementById('preview-edit-image-container-' + applicationId);

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImageContainer.style.display = 'block';
        }

        reader.readAsDataURL(fileInput.files[0]);
    } else {
        previewImage.src = '';
        previewImageContainer.style.display = 'none';
    }
}