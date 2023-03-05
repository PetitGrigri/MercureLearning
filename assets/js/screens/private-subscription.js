window.addEventListener('DOMContentLoaded', function () {

  const firstPrivateBookStatus = document.getElementById("private-book-1-status");
  const firstPrivateBookStatusSource = firstPrivateBookStatus && firstPrivateBookStatus.dataset.bookSource;

  const secondPrivateBookStatus = document.getElementById("private-book-2-status");
  const secondPrivateBookStatusSource = secondPrivateBookStatus && secondPrivateBookStatus.dataset.bookSource;

  // Handle missing required element / attribute
  if (!firstPrivateBookStatusSource) {
    console.error('#private-books-1-status or #private-books-1-status.data-book-source not found')
  }

  // Handle missing required element / attribute
  if (!secondPrivateBookStatusSource) {
    console.error('#private-books-1-status or #private-books-1-status.data-book-source not found')
  }

  // Initialise the event source based on the mercure hub
  const eventSourceFirstBook = new EventSource(firstPrivateBookStatusSource); // Allowed
  const eventSourceSecondBook = new EventSource(secondPrivateBookStatusSource); // Not-Allowed

  // Handling new message
  eventSourceFirstBook.onmessage = (event) => {
    const data = JSON.parse(event.data);
    firstPrivateBookStatus.innerHTML = data.status;
  };

  eventSourceSecondBook.onmessage = (event) => {
    const data = JSON.parse(event.data);
    secondPrivateBookStatus.innerHTML = data.status;
  };
})


