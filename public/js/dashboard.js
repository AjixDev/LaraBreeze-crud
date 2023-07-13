/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/dashboard.js ***!
  \***********************************/
// Function to toggle the edit and save mode
function toggleEditMode(row) {
  var nameElement = row.querySelector('.state-name');
  var nameInputElement = row.querySelector('.state-name-input');
  var isoElement = row.querySelector('.state-iso');
  var isoInputElement = row.querySelector('.state-iso-input');
  var editButton = row.querySelector('.edit-button');
  var saveButton = row.querySelector('.save-button');
  var cancelButton = row.querySelector('.cancel-button');
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
  var row = event.target.closest('tr');
  var editMode = row.classList.contains('edit-mode');
  var saveButton = row.querySelector('.save-button');
  var cancelButton = row.querySelector('.cancel-button');
  var deleteButton = row.querySelector('.delete-button');
  if (event.target.classList.contains('edit-button') && !editMode) {
    // Enter edit mode
    row.classList.add('edit-mode');
    toggleEditMode(row);
  } else if (event.target.classList.contains('save-button') && editMode) {
    // Save changes
    var nameInputElement = row.querySelector('.state-name-input');
    var isoInputElement = row.querySelector('.state-iso-input');
    var newName = nameInputElement.value;
    var newISO = isoInputElement.value;

    // Update the name and ISO elements with the new values
    var nameElement = row.querySelector('.state-name');
    var isoElement = row.querySelector('.state-iso');
    nameElement.textContent = newName;
    isoElement.textContent = newISO;

    // Make an AJAX request to update the state data on the server
    var stateId = event.target.dataset.stateId;
    var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    fetch("/states/".concat(stateId), {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({
        name: newName,
        iso: newISO
      })
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data.success) {
        console.log('State updated successfully:', data.state);
      }
    })["catch"](function (error) {
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
      var _stateId = event.target.dataset.stateId;
      var _csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
      fetch("/states/".concat(_stateId), {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': _csrfToken
        }
      }).then(function (response) {
        if (response.ok) {
          row.remove(); // Remove the row from the DOM
          console.log('State deleted successfully');
        } else {
          console.error('Error deleting state');
        }
      })["catch"](function (error) {
        console.error('Error deleting state:', error);
      });
    }
  }
}

// Add event listeners after page load
window.addEventListener('DOMContentLoaded', function () {
  var table = document.querySelector('table');
  table.addEventListener('click', function (event) {
    if (event.target.matches('.edit-button, .save-button, .cancel-button, .delete-button')) {
      handleButtonClick(event);
    }
  });
});
/******/ })()
;