document.addEventListener('DOMContentLoaded', () => {
    const imageDropArea = document.querySelector('.image-drop-area');
    const pdfDropArea = document.querySelector('.pdf-drop-area');

    const handleFileUpload = (uploadIcon, fileMsg, file) => {
        const reader = new FileReader();
        reader.onload = (event) => {
            uploadIcon.src = event.target.result;
            uploadIcon.style.width = '200px'; 
            uploadIcon.style.height = 'auto'; 
            fileMsg.textContent = file.name;
        };
        reader.readAsDataURL(file);
    };

    const setupDropArea = (area, fileType) => {
        const fileInput = area.querySelector('.file-input');
        const fileMsg = area.querySelector('.file-msg');
        const uploadIcon = area.querySelector('.upload-icon');

        area.addEventListener('dragover', (event) => {
            event.preventDefault();
            area.classList.add('dragover');
        });

        area.addEventListener('dragleave', () => {
            area.classList.remove('dragover');
        });

        area.addEventListener('drop', (event) => {
            event.preventDefault();
            area.classList.remove('dragover');
            const files = event.dataTransfer.files;
            if (files.length && fileType === 'image') {
                handleFileUpload(uploadIcon, fileMsg, files[0]);
            } else {
                fileMsg.textContent = files[0].name;
            }
        });

        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            if (files.length && fileType === 'image') {
                handleFileUpload(uploadIcon, fileMsg, files[0]);
            } else {
                fileMsg.textContent = files[0].name;
            }
        });
    };

    setupDropArea(imageDropArea, 'image');
    setupDropArea(pdfDropArea, 'pdf');
});
