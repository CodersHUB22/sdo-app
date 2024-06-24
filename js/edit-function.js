document.querySelectorAll('input[type="color"]').forEach(function(colorPicker) {
    colorPicker.addEventListener('input', function() {
        let color = this.value;
        let applicationId = this.id.replace('editAppColor', '');
        document.getElementById('colorCode' + applicationId).textContent = color;
    });
});

function previewEditImage(id) {
    var editFile = document.getElementById('editAppImage' + id).files[0];
    var editReader = new FileReader();
    editReader.onloadend = function() {
        document.getElementById('preview-edit-image-' + id).src = editReader.result;
    }
    if (editFile) {
        editReader.readAsDataURL(editFile);
    } else {
        document.getElementById('preview-edit-image-' + id).src = "";
    }
}