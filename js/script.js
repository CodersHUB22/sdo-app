document.addEventListener("DOMContentLoaded", function () {
    const headerToggler = document.getElementById('headerToggler');
    headerToggler.addEventListener('click', function() {
        const navbarCollapse = document.getElementById('navbarSupportedContent');
        navbarCollapse.classList.toggle('show');
    });

    let masonry;

    // Function to initialize masonry layout
    function initMasonry() {
        const elem = document.querySelector('.wrapper-masonry');
        masonry = new Masonry(elem, {
            itemSelector: '.grid-cards',
            columnWidth: '.grid-cards',
            percentPosition: true,
            gutter: 10
        });
        masonry.layout();
    }

    // Function to filter and restructure cards
    function filterAndRestructureCards(filterText) {
        const gridItems = document.querySelectorAll('.grid-cards');
        let visibleItems = [];
        
        gridItems.forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            if (filterText === 'all-categories' || title.includes(filterText)) {
                item.style.display = 'block';
                visibleItems.push(item);
            } else {
                item.style.display = 'none';
            }
        });

        // Rearrange items in masonry layout after filtering
        visibleItems.forEach((item, index) => {
            const newIndex = index % 8;
            item.className = `grid-cards grid-item-span${newIndex + 1}`;
        });

        // Reinitialize masonry layout after filtering
        masonry.reloadItems();
        masonry.layout();
    }

    // Event listener for "All Categories" in desktop view
    document.getElementById('all-categories').addEventListener('click', function(event) {
        event.preventDefault();
        filterAndRestructureCards('all-categories');
    });

    // Event listener for "Web App" in desktop view
    document.getElementById('web-app').addEventListener('click', function(event) {
        event.preventDefault();
        filterAndRestructureCards('system');
    });

    // Event listener for "Web App" in mobile view
    document.getElementById('mobile-web-app').addEventListener('click', function(event) {
        event.preventDefault();
        filterAndRestructureCards('system');
        const navbarCollapse = document.getElementById('navbarSupportedContent');
        navbarCollapse.classList.remove('show');
        history.pushState({}, '', '/sdo-app/web-app');
    });

    // Event listener for "Home" in mobile view (ID mobile-all-categories)
    document.getElementById('mobile-all-categories').addEventListener('click', function(event) {
        event.preventDefault();
        filterAndRestructureCards('all-categories');
        const currentPath = '/sdo-app/index.php';
        if (window.location.pathname !== currentPath) {
            history.pushState({}, '', currentPath);
        }
    });

    // Initial masonry layout setup
    initMasonry();
});