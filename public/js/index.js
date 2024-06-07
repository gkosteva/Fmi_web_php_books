
var requestPdfButtons = document.querySelectorAll('.request-pdf-button');
requestPdfButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var pdfName = this.parentNode.querySelector('.title').innerText.trim();
        var authorName=this.parentNode.querySelector('.author').innerText.trim();
        console.log(authorName);
        openModal('modal', pdfName, authorName);
    });
});


function openModal(modalId, pdfName, authorName) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
    handleModal(pdfName, authorName);
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

function handleModal(pdfName, authorName) {
    var loadingIndicator = document.getElementById('loading-indicator');
    var modal = document.getElementById('modal');
    var emailInput = document.getElementById('emailInput');
    var submitButton = document.getElementById('submitButton');

    submitButton.addEventListener('click', function(event) {
        event.preventDefault();
        
        var email = emailInput.value.trim(); 
        
        if (email === '') {
            alert('Please enter your email address');
            return;
        }
        loadingIndicator.style.display = 'block';

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/Fmi_web_php_books/handlers/sendInitialEmailHandler.php", true); 
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                loadingIndicator.style.display = 'none';
                if (xhr.status === 200) {
                    console.log(xhr.responseText); 
                    //alert("Email sent successfully!"); 
                    closeModal('modal'); 
                    this.parentNode.classList.add('grayed-out');
                } else {
                    console.error(xhr.statusText); 
                    alert("Failed to send email. Please try again."); 
                }
            }
        };
        var cleanedPdfName = pdfName.replace('Title:', '').trim();
        var cleanedAuthorName = authorName.replace('Author:', '').trim();
        var formData = 'email=' + encodeURIComponent(email) +
                   '&pdfName=' + encodeURIComponent(cleanedPdfName) +
                   '&authorName=' + encodeURIComponent(cleanedAuthorName);
        xhr.send(formData);
    });
}

