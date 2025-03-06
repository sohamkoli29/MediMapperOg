document.addEventListener('DOMContentLoaded', () => {
    console.log("Script loaded!"); // ✅ Debugging Step

    const visitDoctorButtons = document.querySelectorAll('.visit-doctor-btn');

    visitDoctorButtons.forEach(button => {
        button.addEventListener('click', function() {
            const doctorId = this.getAttribute('data-doctor-id');
            
            console.log("Doctor ID:", doctorId); // ✅ Debugging Step

            if (doctorId) {
                window.location.href = `book_appointment.php?doctor_id=${doctorId}`;
            } else {
                console.error("Doctor ID is missing!");
            }
        });
    });
});
