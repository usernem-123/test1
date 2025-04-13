
  document.getElementById('eventForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the values from the form
    const title = document.getElementById('eventTitle').value;
    const date = document.getElementById('eventDate').value;
    const description = document.getElementById('eventDescription').value;

    // Create a new card element
    const card = document.createElement('div');
    card.className = 'card mb-3';
    card.innerHTML = `
      <div class="card-body">
        <h5 class="card-title">${title}</h5>
        <h6 class="card-subtitle mb-2 text-muted">${date}</h6>
        <p class="card-text">${description}</p>
      </div>
    `;

    // Append the card to the container (you need to create a container for events)
    document.querySelector('.container.mt-4').appendChild(card);

    // Clear the form fields
    document.getElementById('eventForm').reset();

    // Close the modal
    var modal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
    modal.hide();
  });
