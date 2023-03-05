window.addEventListener('DOMContentLoaded', function () {

  const firstBookStatus = document.getElementById("book-1-status");
  const firstBookStatusSource = firstBookStatus && firstBookStatus.dataset.bookSource;

  // Handle missing required element / attribute
  if (!firstBookStatusSource) {
    console.error('#books-1-status or #books-1-status.data-book-source not found')
  }

  // Initialise the event source based on the mercure hub
  const eventSource = new EventSource(firstBookStatusSource);

  // Handling new message
  eventSource.onmessage = (event) => {
    const data = JSON.parse(event.data);
    firstBookStatus.innerHTML = data.status;
  };
})


