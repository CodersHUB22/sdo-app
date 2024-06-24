document.addEventListener("DOMContentLoaded", function() {
    const navItems = document.querySelectorAll('.nav-item');

    // Function to set active state based on current URL path
    function setActiveNavItem() {
        const path = window.location.pathname;
        navItems.forEach(item => {
            const link = item.querySelector('a');
            if (link.getAttribute('href') === path) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Initial call to set active state on page load
    setActiveNavItem();

    // Event listener for click on nav items
    navItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            navItems.forEach(navItem => navItem.classList.remove('active'));
            item.classList.add('active');
            const url = new URL(item.querySelector('a').getAttribute('href'), window.location.origin + '/sdo-app');
            history.pushState(null, '', url);
            localStorage.setItem('currentPage', url);
        });
    });    

    // Check if there's a stored state on page load
    const storedPage = localStorage.getItem('currentPage');
    if (storedPage) {
        history.replaceState(null, '', storedPage);
    }
});

document.querySelector('.profile-dropdown').addEventListener('click', function() {
    document.querySelector('.profile-dropdown-list').classList.toggle('active');
});

window.onclick = function(event) {
    if (!event.target.matches('.profile-dropdown')) {
        var dropdowns = document.querySelectorAll('.profile-dropdown-list');
        dropdowns.forEach(function(dropdown) {
            if (dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
            }
        });
    }
}

function adjustNavItems() {
    const mainNav = document.querySelector('.main-nav');
    const mobileCategories = document.getElementById('mobile-all-categories');
    const mobileWebApp = document.getElementById('mobile-web-app');
    const headerToggler = document.getElementById('headerToggler');

    if (window.innerWidth <= 992) {
        if (!mobileCategories || !mobileWebApp) {
            const allCategories = document.getElementById('all-categories');
            const webApp = document.getElementById('web-app');

            if (allCategories) {
                const cloneAllCategories = allCategories.cloneNode(true);
                cloneAllCategories.id = "mobile-all-categories";
                cloneAllCategories.classList.remove("nav-link");
                cloneAllCategories.classList.add("profile-dropdown-list-item");
                document.querySelector('.profile-dropdown-list').appendChild(cloneAllCategories);
            }

            if (webApp) {
                const cloneWebApp = webApp.cloneNode(true);
                cloneWebApp.id = "mobile-web-app";
                cloneWebApp.classList.remove("nav-link");
                cloneWebApp.classList.add("profile-dropdown-list-item");
                document.querySelector('.profile-dropdown-list').appendChild(cloneWebApp);
            }
        }
        headerToggler.style.display = 'none';
    } else {
        if (mobileCategories && mobileCategories.parentNode) {
            mobileCategories.parentNode.removeChild(mobileCategories);
        }
        if (mobileWebApp && mobileWebApp.parentNode) {
            mobileWebApp.parentNode.removeChild(mobileWebApp);
        }
    }
}

window.addEventListener('resize', adjustNavItems);
window.addEventListener('load', adjustNavItems);