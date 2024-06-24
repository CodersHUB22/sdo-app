var lastActivityTime = new Date().getTime();
var inactiveTime = 10 * 60 * 1000; // 10 minutes in milliseconds

function checkInactivity() {
    var currentTime = new Date().getTime();
    var timeSinceLastActivity = currentTime - lastActivityTime;

    if (timeSinceLastActivity > inactiveTime) {
        // Redirect to logout if inactive for more than 10 minutes
        window.location.href = 'logout.php';
    }
}

// Check for inactivity periodically
setInterval(checkInactivity, 60000); // Check every minute (adjust as needed)

// Event listeners to update lastActivityTime on user interaction
document.addEventListener('keydown', function() {
    lastActivityTime = new Date().getTime();
});

document.addEventListener('mousemove', function() {
    lastActivityTime = new Date().getTime();
});

document.addEventListener('click', function() {
    lastActivityTime = new Date().getTime();
});

// Optional: Prevent iframe usage (if needed)
if (self !== top) {
    top.location = self.location;
}