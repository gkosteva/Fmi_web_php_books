document.addEventListener("DOMContentLoaded", function() {
    // Get the error message from the PHP session
    var errorMessage = document.getElementById('errorMessage').dataset.error;

    if (errorMessage) {
        const errorMessageDiv = document.getElementById('errorMessage');
        errorMessageDiv.innerText = errorMessage;
        errorMessageDiv.style.display = 'block';
    }

    // Add event listeners to hide error message when typing
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            document.getElementById('errorMessage').style.display = 'none';
        });
    });
});