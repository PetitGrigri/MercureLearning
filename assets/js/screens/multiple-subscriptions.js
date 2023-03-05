window.addEventListener('DOMContentLoaded', function () {

  const books = document.getElementById("books");
  const bookStatusSources = books && books.dataset.bookSources;

  // Handle missing required element / attribute
  if (!bookStatusSources) {
    console.error('#books or #books.data-book-source not found')
  }

  // Initialise the event sources based on the mercure hub
  const eventSources = new EventSource(bookStatusSources);

  eventSources.onmessage = (event) => {
    const {id, status} = JSON.parse(event.data);
    const bookStatus = document.querySelector(`#book-${id}-status`)

    if (bookStatus) bookStatus.innerHTML = status;
  };
})
