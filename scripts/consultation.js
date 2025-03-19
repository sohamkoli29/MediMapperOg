document.addEventListener('DOMContentLoaded', () => {
    const onlineDoctorsBtn = document.getElementById('online-doctors-btn');
    const offlineDoctorsBtn = document.getElementById('offline-doctors-btn');

    // Online Doctors Button
    onlineDoctorsBtn.addEventListener('click', () => {
        window.location.href = "../templates/online_consultation.php";
    });

    // Offline Doctors Button
    offlineDoctorsBtn.addEventListener('click', () => {
        window.location.href = "../templates/offline_consultation.php";
    });
});

const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});