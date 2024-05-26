window.addEventListener('error', (event) => {
    console.error('An error occurred:', event.message);
    document.getElementById('book-list').innerHTML = '<li>Error loading books. Please try again later.</li>';
});
