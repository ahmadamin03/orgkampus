document.addEventListener('DOMContentLoaded', () => {
    // Sidebar Toggle for Mobile
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Optional: Add active class to current nav link
    const currentLocation = location.pathname.split("/").slice(-1)[0];
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href').split("/").slice(-1)[0];
        if (currentLocation === linkHref) {
            link.classList.add('active');
        } else if (currentLocation === '' && linkHref === 'dashboard.html') {
            // Default to dashboard if no specific page
            link.classList.add('active');
        }
    });
});
