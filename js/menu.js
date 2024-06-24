const profileContainer = document.querySelector(".profile-container");
const profileDropdownList = document.querySelector(".profile-dropdown-list");
const logoutModal = document.getElementById("logoutModal");
const logoutSuccessModal = document.getElementById("logoutSuccessModal");

profileContainer.addEventListener("click", function (event) {
  profileDropdownList.classList.toggle("active");
  event.stopPropagation();
});

// Close the dropdown if clicked outside
document.addEventListener("click", function (event) {
  if (
    !profileContainer.contains(event.target) &&
    !profileDropdownList.contains(event.target)
  ) {
    profileDropdownList.classList.remove("active");
  }
});

function logout() {
  Swal.fire({
      icon: 'success',
      title: 'Logout Successfully',
      showConfirmButton: false,
      timer: 1500
  });
  setTimeout(function () {
      $.ajax({
          url: 'logout.php',
          type: 'POST',
          success: function() {
              window.location.href = "login.php";
          }
      });
  }, 1500);
}