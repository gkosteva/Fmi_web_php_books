var booksArray = [];
const bookList = document.getElementById("book-list");

document.addEventListener("DOMContentLoaded", function () {
  fetchBooks();

  bookList.addEventListener("click", function (event) {
    if (event.target.classList.contains("finishBook")) {
      const bookItem = event.target.closest(".book");
      deleteBook(bookItem.title);
      loadBooks(booksArray);
    }
  });
});

function loadBooks(books) {
  if (!books) {
    document.getElementById("noBooks").innerText = "You have no active books";
  } else {
    document.getElementById("noBooks").innerText = "";
    bookList.innerHTML = "";
    books.forEach((book) => {
      const bookLi = document.createElement("li");
      bookLi.className = "book";
      bookLi.innerHTML = `
      <li class="book">
      <div>
        <img class="imgBook" src="${book.image}" alt="image of ${book.title}" />
        <div class="info">
          <p class="title">Title: ${book.title}</p>
          <p class="author">Author: ${book.author}</p>
        </div>
        <p class="description">Description: ${book.description}</p>
      </div>
      <p class="daysLeft">Days left: ${book.daysLeft}</p>
      <div class="buttons">
        <button class="finishBook">
          <a class="pathPDF" href="${book.pathPDF}" target="_blank"
            >Open PDF</a
          >
        </button>
        <button class="finishBook">Finish</button>
      </div>
    </li>
        `;
      bookList.appendChild(bookLi);
    });
  }
}

function fetchBooks() {
  fetch("/api/activeBooks")
    .then((response) => response.json())
    .then((books) => {
      loadBooks(books);
    })
    .catch((error) => {
      console.error("Error fetching books:", error);
      document.getElementById("noBooks").innerText = "You have no active books";
    });
}

function deleteBook(title) {
  fetch(`/api/deleteBook/${title}`, {
    method: "DELETE",
  })
    .then((response) => response.text())
    .then((message) => {
      console.log(message);
    })
    .catch((error) => console.error("Error deleting book:", error));
}

function handleFinishBook(bookTitle) {
  deleteBook(title);
  booksArray = booksArray.filter((b) => b.title != bookTitle);
  loadBooks(booksArray);
}
