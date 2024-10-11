// pen icon for the edit profile
document.addEventListener('DOMContentLoaded', function () {
    // Check if elements exist before attaching event listeners
    const penIcon = document.getElementById('penIcon');
    const fileInput = document.getElementById('fileInput');
    const imagePreview = document.getElementById('imagePreview');
    const userAvatar = document.querySelector('.custom-user-avatar');

    if (penIcon) {
        penIcon.addEventListener('click', function () {
            if (fileInput) {
                fileInput.click();
            } else {
                console.error('fileInput element not found');
            }
        });
    } else {
        console.error('penIcon element not found');
    }

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (imagePreview) {
                        imagePreview.src = e.target.result;
                    } else {
                        console.error('imagePreview element not found');
                    }
                    if (userAvatar) {
                        userAvatar.classList.add('d-none'); // Hide user initials
                    } else {
                        console.error('userAvatar element not found');
                    }
                };
                reader.readAsDataURL(file);
            } else {
                console.error('No file selected');
            }
        });
    } else {
        console.error('fileInput element not found');
    }
});
