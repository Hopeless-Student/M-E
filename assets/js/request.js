function showRequestFromElement(element) {
  document.getElementById("requestTitle").innerText = element.dataset.title;
  document.getElementById("requestContent").innerText = element.dataset.message;
  document.getElementById("requestType").innerText = element.dataset.type;
  document.getElementById("requestStatus").innerText = element.dataset.status;
  document.getElementById("requestDate").innerText = element.dataset.date;

  const adminReply = document.getElementById("adminReply");
  if (element.dataset.admin_response && element.dataset.admin_response.trim()) {
    adminReply.innerText = element.dataset.admin_response;
  } else {
    adminReply.innerText = "No admin reply yet.";
  }

  let items = document.querySelectorAll(".request-item");
  items.forEach(el => el.classList.remove("active-request"));
  element.classList.add("active-request");

  const status = element.dataset.status.toLowerCase();
  const statusBadge = document.getElementById("requestStatus");
  statusBadge.className = "badge text-capitalize";
  if (status === "pending") statusBadge.classList.add("bg-warning", "text-dark");
  else if (status === "in-progress") statusBadge.classList.add("bg-info", "text-dark");
  else if (status === "resolved") statusBadge.classList.add("bg-success");
  else if (status === "closed") statusBadge.classList.add("bg-secondary");

  const type = element.dataset.type.toLowerCase();
  const typeBadge = document.getElementById("requestType");
  typeBadge.className = "badge text-capitalize";
  if (type === "inquiry") typeBadge.classList.add("bg-primary");
  else if (type === "complaint") typeBadge.classList.add("bg-danger");
  else if (type === "custom_order") typeBadge.classList.add("bg-success");
  else if (type === "other") typeBadge.classList.add("bg-secondary");

  console.log(`Viewing request: type="${type}" | status="${status}"`);
}

window.addEventListener("DOMContentLoaded", function () {
  const firstRequest = document.querySelector(".request-item.first-request");
  if (firstRequest) {
    showRequestFromElement(firstRequest);
  }

  const filterBtns = document.querySelectorAll(".filter-btn");
  const requestList = document.querySelector("#requestItemsContainer");

  let currentType = "";
  let currentStatus = "";

  filterBtns.forEach(btn => {
    btn.addEventListener("click", e => {
      e.preventDefault();

      const filterType = btn.getAttribute("data-filter-type");
      const filterValue = btn.getAttribute("data-value");

      if (filterType === "type") {
        currentType = filterValue;

        document.getElementById("typeButton").textContent = btn.textContent.trim();
      } else if (filterType === "status") {
        currentStatus = filterValue;

        document.getElementById("statusButton").textContent = btn.textContent.trim();
      }

      console.log(`Filtering: type="${currentType}" | status="${currentStatus}"`);
      fetch(`../ajax/fetch-request.php?type=${currentType}&status=${currentStatus}`)
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            renderRequestList(data.requests);
          } else {
            console.error("Error:", data.error);
            requestList.innerHTML = `<div class="text-center text-danger p-3">Error: ${data.error}</div>`;
          }
        })
        .catch(err => {
          console.error("Fetch error:", err);
          requestList.innerHTML = `<div class="text-center text-danger p-3">Error: ${data.error}</div>`;
        });
    });
  });

  function renderRequestList(requests) {
    requestList.innerHTML = "";

    if (!requests || requests.length === 0) {
      requestList.innerHTML = `<div class="text-center text-muted p-3">No requests found.</div>`;

      document.getElementById("requestTitle").innerText = "No requests found";
      document.getElementById("requestContent").innerText = "Try adjusting your filters";
      document.getElementById("requestType").innerText = "-";
      document.getElementById("requestStatus").innerText = "-";
      document.getElementById("requestDate").innerText = "-";
      document.getElementById("adminReply").innerText = "-";
      return;
    }

    requests.forEach((req, index) => {
      const div = document.createElement("div");
      div.className = "request-item";
      if (index === 0) div.classList.add("first-request");

      div.dataset.title = req.subject;
      div.dataset.message = req.message;
      div.dataset.type = req.request_type;
      div.dataset.status = req.status;
      div.dataset.date = formatDate(req.created_at);
      div.dataset.admin_response = req.admin_response || "";

      div.innerHTML = `
        <strong class="subject">${escapeHtml(req.subject)}</strong>
        <div class="text-muted small message">${escapeHtml(req.message.substring(0, 50))}...</div>
      `;

      div.addEventListener("click", () => showRequestFromElement(div));
      requestList.appendChild(div);
    });

    // Auto-display first one
    const firstRequest = document.querySelector(".request-item.first-request");
    if (firstRequest) showRequestFromElement(firstRequest);
  }

  // Helper function to format date
  function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });
  }

  // Helper function to escape HTML
  function escapeHtml(text) {
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
  }
  // pang edit delete naman
  document.addEventListener('click', function(e) {
  const btn = e.target.closest('.action-btn'); // find button clicked
  if (!btn) return;

  const action = btn.dataset.action; // pag edit or delete
  const form = btn.closest('form');
  const requestId = form.querySelector('[name="request_id"]').value;

  if (action === 'edit') {
  const content = document.getElementById('requestContent');
  const originalText = content.textContent.trim();

  // Prevent duplicate edit boxes if already in edit mode
  if (document.getElementById('editMessage')) return;

  const editBtn = document.getElementById('editBtn');
const deleteBtn = form.querySelector('[data-action="delete"]');
editBtn.style.display = 'none';
deleteBtn.style.display = 'none';

  content.innerHTML = `
    <textarea id="editMessage" class="form-control mb-2" rows="4">${originalText}</textarea>
    <div class="d-flex justify-content-end gap-2">
      <button id="saveEditBtn" class="btn btn-outline-primary btn-sm" type="button"><img src="../assets/svg/save.svg" alt="save button"> Save</button>
      <button id="cancelEditBtn" class="btn btn-outline-danger btn-sm  btn-sm" type="button"><img src="../assets/svg/cancel.svg" alt="cancel button"> Cancel</button>
    </div>
  `;

  const saveBtn = document.getElementById('saveEditBtn');
  const cancelBtn = document.getElementById('cancelEditBtn');

  saveBtn.onclick = () => {
    const newMessage = document.getElementById('editMessage').value.trim();

    fetch('../ajax/action-request.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        action: 'edit',
        request_id: requestId,
        message: newMessage
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        showNotif('Request updated successfully!', 'success');
        content.textContent = newMessage;
        editBtn.style.display = '';
        deleteBtn.style.display = '';

        content.classList.add('fade');
      setTimeout(() => content.classList.remove('fade'), 200);
        loadRequests(); // refresh after ng edit
      } else {
        showNotif('Error: ' + data.message, 'danger');
      }
    })
    .catch(err => {
      console.error('Fetch error:', err);
      showNotif('Error updating request.', 'danger');
    });
  };

  cancelBtn.onclick = () => {
    content.innerHTML = `<div class="mb-2">${originalText}</div>`;
    editBtn.style.display = '';
    deleteBtn.style.display = '';

    content.classList.add('fade');
  setTimeout(() => content.classList.remove('fade'), 200);
  };

  return; // stop here
}


  // delete logic
  if (action === 'delete') {
    fetch('../ajax/action-request.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        action: 'delete',
        request_id: requestId
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        showNotif('Request deleted successfully!', 'success');
        loadRequests(); // reload the updated list
      } else {
        showNotif('Error: ' + data.message, 'danger');
      }
    })
    .catch(err => {
      console.error('Fetch error:', err);
      showNotif('Error deleting request.', 'danger');
    });
  }
});

  // para s notif na bulok
    function showNotif(message, type) {
      const notifContainer = document.getElementById('notifContainer');
      const alert = document.createElement('div');
        alert.className = `alert alert-${type} shadow-sm fade show`;
        alert.role = 'alert';
      alert.textContent = message;
      notifContainer.appendChild(alert);

      setTimeout(() => {
        alert.classList.remove('show');
        alert.classList.add('fade');
        setTimeout(() => alert.remove(), 300);
      }, 3000);
      }

// pang reload
    function loadRequests() {
      fetch('../ajax/fetch-request.php')
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          renderRequestList(data.requests);
        } else {
          console.error("Error:", data.error);
        }
      })
      .catch(err => console.error("Fetch error:", err));
    }

});
