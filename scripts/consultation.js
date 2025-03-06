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