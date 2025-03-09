
    
    // Also add click event listeners for the consultation buttons
    document.querySelectorAll('.visit-doctor-btn').forEach(button => {
        button.addEventListener('click', function() {
            const doctorId = this.getAttribute('data-doctor-id');
            // Navigate to chat or scheduling page with the doctor ID
            window.location.href = `onlineDoctors.php?doctor_id=${doctorId}`;
        });
    });


