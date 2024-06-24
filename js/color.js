document.getElementById('appColor').addEventListener('change', function() {
    var colorPicker = this;
    var colorCode = document.getElementById('colorCode');
    colorCode.innerHTML = colorPicker.value;
    colorCode.style.color = colorPicker.value;
});