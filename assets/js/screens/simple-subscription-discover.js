window.addEventListener('DOMContentLoaded', function () {

  const discoverBlock = document.getElementById("discover-book");
  const discoverUrl = discoverBlock && discoverBlock.dataset.discoverUrl


  // Handle missing required element / attribute
  if (!discoverUrl) {
    console.error('#discover-book" or #discover-book".data-discover-url not found')
  }

  fetch(discoverUrl) // Has Link: <https://hub.example.com/.well-known/mercure>; rel="mercure"
    .then(function (response) {
      // Get the Mercure Hub URL
      const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1];

      // Fills the dataset of the discoverBlock and update his content
      discoverBlock.setAttribute('data-mercure-hub', hubUrl)
      const discoverBlockHubURL =  discoverBlock.querySelector('[data-discover-hub-url]')

      discoverBlockHubURL.innerHTML = hubUrl;

      return response.json()

    })
    .then((content) => {
      const discoverBlockContent =  discoverBlock.querySelector('[data-discover-content]')
      const discoverBlockHubURL =  discoverBlock.querySelector('[data-discover-topic-url]')
      const discoverBlockStatus =  discoverBlock.querySelector('[data-discover-book-status]')
      const discoverSubscriptionUrl =  discoverBlock.querySelector('[data-discover-subscripion-url]')


      const hubUrl = discoverBlockContent && discoverBlock.dataset.mercureHub;
      const topic =  content['@id'];

      discoverBlockContent.innerHTML = JSON.stringify(content)
      discoverBlockHubURL.innerHTML = topic

      const topicHubUrl = new URL(hubUrl)
      topicHubUrl.searchParams.set('topic', topic)

      discoverSubscriptionUrl.innerHTML = topicHubUrl.toString();

      // Subscribe to updates
      const eventSource = new EventSource(topicHubUrl.toString())


      // Handling new message
      eventSource.onmessage = (event) => {
        console.log(event)
        const data = JSON.parse(event.data);
        discoverBlockStatus.innerHTML = data.status;
      };
    })
})


