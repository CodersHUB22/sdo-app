document.addEventListener("DOMContentLoaded", function () {
    var masonryContainer = document.querySelector('.grid-container');
    var masonry = new Masonry(masonryContainer, {
        itemSelector: '.grid-item',
        columnWidth: '.grid-item',
        percentPosition: true
    });

    function addItemToMasonry(item) {
        var container = document.querySelector('.grid-container');
        var newItem = document.createElement('div');
        newItem.className = 'grid-item card';
        newItem.innerHTML = `
            <a class="text-decoration-none" href="${item.applicationLink}" target="_blank">
                <img src="${item.applicationImage}" class="card-img-top" alt="${item.applicationTitle}" style="height: 40%; object-fit: cover;">
                <div class="card-body">
                    <h4 class="card-title">${item.applicationTitle}</h4>
                    <figcaption class="blockquote-footer mt-2 card-text">${item.applicationDescription}</figcaption>
                </div>
            </a>
            <div class="card-footer">
                <a href="#" class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal${item.applicationId}">Edit</a>
                <a href="#" class="btn btn-danger delete-btn" data-application-id="${item.applicationId}">Delete</a>
            </div>
        `;
        container.appendChild(newItem);
        masonry.appended(newItem);
        masonry.layout();
    }
});