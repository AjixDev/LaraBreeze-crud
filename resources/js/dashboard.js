// Function to toggle the edit and save mode
function toggleEditMode(row) {
  const nameElement = row.querySelector('.state-name');
  const nameInputElement = row.querySelector('.state-name-input');
  const isoElement = row.querySelector('.state-iso');
  const isoInputElement = row.querySelector('.state-iso-input');
  const editButton = row.querySelector('.edit-button');
  const saveButton = row.querySelector('.save-button');
  const cancelButton = row.querySelector('.cancel-button');

  nameElement.classList.toggle('hidden');
  nameInputElement.classList.toggle('hidden');
  isoElement.classList.toggle('hidden');
  isoInputElement.classList.toggle('hidden');
  editButton.classList.toggle('hidden');
  saveButton.classList.toggle('hidden');
  cancelButton.classList.toggle('hidden');
}

// Function to handle the edit/save/cancel/delete button click event
function handleButtonClick(event) {
  const row = event.target.closest('tr');
  const editMode = row.classList.contains('edit-mode');
  const saveButton = row.querySelector('.save-button');
  const cancelButton = row.querySelector('.cancel-button');
  const deleteButton = row.querySelector('.delete-button');

  if (event.target.classList.contains('edit-button') && !editMode) {
    // Enter edit mode
    row.classList.add('edit-mode');
    toggleEditMode(row);
  } else if (event.target.classList.contains('save-button') && editMode) {
    // Save changes
    const nameInputElement = row.querySelector('.state-name-input');
    const isoInputElement = row.querySelector('.state-iso-input');
    const newName = nameInputElement.value;
    const newISO = isoInputElement.value;

    // Update the name and ISO elements with the new values
    const nameElement = row.querySelector('.state-name');
    const isoElement = row.querySelector('.state-iso');
    nameElement.textContent = newName;
    isoElement.textContent = newISO;

    // Make an AJAX request to update the state data on the server
    const stateId = event.target.dataset.stateId;
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

    fetch(`/states/${stateId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
      body: JSON.stringify({
        name: newName,
        iso: newISO,
      }),
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          console.log('State updated successfully:', data.state);
        }
      })
      .catch(error => {
        console.error('Error updating state:', error);
      });

    // Exit edit mode
    row.classList.remove('edit-mode');
    toggleEditMode(row);
  } else if (event.target.classList.contains('cancel-button') && editMode) {
    // Cancel changes
    row.classList.remove('edit-mode');
    toggleEditMode(row);
  } else if (event.target.classList.contains('delete-button')) {
    // Delete state
    if (confirm('Are you sure you want to delete this state?')) {
      const stateId = event.target.dataset.stateId;
      const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

      fetch(`/states/${stateId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
        },
      })
        .then(response => {
          if (response.ok) {
            row.remove(); // Remove the row from the DOM
            console.log('State deleted successfully');
          } else {
            console.error('Error deleting state');
          }
        })
        .catch(error => {
          console.error('Error deleting state:', error);
        });
    }
  }
}

// Add event listeners after page load
window.addEventListener('DOMContentLoaded', () => {
  const table = document.querySelector('table');

  table.addEventListener('click', (event) => {
    if (event.target.matches('.edit-button, .save-button, .cancel-button, .delete-button')) {
      handleButtonClick(event);
    }
  });
});
