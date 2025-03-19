document.querySelector(".smb").addEventListener("click", function () {
    document.querySelector(".ans").classList.toggle("active");
});

document.querySelector(".smb").addEventListener("click", function () {
    document.querySelector(".ans p").classList.toggle("active");
});
document.querySelector(".smb").addEventListener("click", function () {
    document.querySelector(".smb").classList.toggle("active");
});


const header = document.querySelector("header");
let lastScrollPosition = 0;
let ticking = false;

window.addEventListener("scroll", () => {
    if (!ticking) {
        requestAnimationFrame(() => {
            let currentScrollPosition = window.scrollY;

            if (currentScrollPosition > lastScrollPosition) {
                // Scroll Down - Hide Header
                header.style.top = "-100px";
            } else {
                // Scroll Up - Show Header
                header.style.top = "0";
            }

            lastScrollPosition = currentScrollPosition;
            ticking = false;
        });
        ticking = true;
    }
});



// Toggle the mobile navigation menu
// Toggle the mobile navigation menu
const hamburger = document.getElementById('hamburger');
const navLink = document.getElementById('nav-link');

hamburger.addEventListener('click', () => {
    navLink.classList.toggle('active');
});

// Close the hamburger menu when a link is clicked
const navLinks = document.querySelectorAll('.nav-link-item');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navLink.classList.remove('active'); // Close the menu
    });
});