
let isEditMode = false;
let originalMessage = '';

function showRequestFromElement(element) {
  // line 51 yung func
  if (isEditMode) {
    cancelEdit();
  }

  document.getElementById("requestTitle").innerText = element.dataset.title;
  document.getElementById("requestContent").innerText = element.dataset.message;
  document.getElementById("requestType").innerText = element.dataset.type;
  document.getElementById("requestStatus").innerText = element.dataset.status;
  document.getElementById("requestDate").innerText = element.dataset.date;

  const hiddenInput = document.querySelector('#requestActionForm input[name="request_id"]');
  if (hiddenInput) hiddenInput.value = element.dataset.requestId;

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

  fetch('../ajax/mark-seen.php', {
    method: 'POST',
    header: {'Content-Type': 'application/x-www-form-urlencoded'},
    body:`request_id=${encodeURIComponent(hiddenInput)}`
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      element.classList.remove('fw-bold', 'bg-light');
      const badge = element.querySelector('.badge');
      if(badge) badge.remove();
    }
  })
  .catch(err => console.error('Error marking as seen:', err));
}

function cancelEdit() {
  const content = document.getElementById('requestContent');
  const editBtn = document.getElementById('editBtn');
  const deleteBtn = document.querySelector('[data-action="delete"]');

  // kinuha yung orig message nilagay kay originalMessage variable kapag = '';
  if (originalMessage) {
    content.innerHTML = originalMessage.replace(/\n/g, '<br>'); // testing version
    // content.textContent = originalMessage; 1st version
  }

  if (editBtn) editBtn.style.display = '';
  if (deleteBtn) deleteBtn.style.display = '';

  isEditMode = false;
  originalMessage = '';
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
      div.dataset.request_id = req.request_id;

      div.innerHTML = `
      <strong class="subject">${escapeHtml(req.subject)}</strong>
      <div class="text-muted small message">${escapeHtml(req.message.substring(0, 50))}...</div>
      `;

      div.addEventListener("click", () => showRequestFromElement(div));
      requestList.appendChild(div);
    });

    const firstRequest = document.querySelector(".request-item.first-request");
    if (firstRequest) showRequestFromElement(firstRequest);
  }

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

  //edit delete func
  document.addEventListener('click', function(e) {
    const btn = e.target.closest('.action-btn');
    if (!btn) return;

    const action = btn.dataset.action;
    const form = btn.closest('form');
    const requestId = form.querySelector('[name="request_id"]').value;

    if (action === 'edit') {
      const content = document.getElementById('requestContent');
      const originalText = content.textContent;
      // pang prevent ng multiple edit return kapag isEditMode is true
      if (isEditMode) return;

      isEditMode = true;
      originalMessage = originalText;

      const editBtn = document.getElementById('editBtn');
      const deleteBtn = form.querySelector('[data-action="delete"]');

      editBtn.style.display = 'none';
      deleteBtn.style.display = 'none';

      content.innerHTML = '';
      const textarea = document.createElement('textarea');
      textarea.id = 'editMessage';
      textarea.className = 'form-control mb-2';
      textarea.rows = 4;
      textarea.value = originalText; // this preserves formatting (line breaks, dashes, etc.)
      content.appendChild(textarea);

      const btnContainer = document.createElement('div');
      btnContainer.className = 'd-flex justify-content-end gap-2';
      btnContainer.innerHTML = `
        <button id="saveEditBtn" class="btn btn-outline-primary btn-sm action-btn" type="button">
          <img src="../assets/svg/save.svg" alt="save"> Save
        </button>
        <button id="cancelEditBtn" class="btn btn-outline-danger btn-sm" type="button">
          <img src="../assets/svg/cancel.svg" alt="cancel"> Cancel
        </button>
      `;
      content.appendChild(btnContainer);
      // content.innerHTML = `
      //   <textarea id="editMessage" class="form-control mb-2" rows="4">${originalText}</textarea>
      //   <div class="d-flex justify-content-end gap-2">
      //     <button id="saveEditBtn" class="btn btn-outline-primary btn-sm action-btn" type="button">
      //       <img src="../assets/svg/save.svg" alt="save"> Save
      //     </button>
      //     <button id="cancelEditBtn" class="btn btn-outline-danger btn-sm" type="button">
      //       <img src="../assets/svg/cancel.svg" alt="cancel"> Cancel
      //     </button>
      //   </div>
      // `;
      document.getElementById('saveEditBtn').onclick = () => {
        // const newMessage = document.getElementById('editMessage').value.trim();
        const newMessage = textarea.value.trim();
        if (!newMessage) {
          showNotif('Message cannot be empty', 'warning');
          return;
        }

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
            content.innerHTML = newMessage.replace(/\n/g, '<br>'); // testing version
            // content.textContent = newMessage; 1st version

            // Update in the side list
            const activeItem = document.querySelector('.request-item.active-request');
            if (activeItem) {
              activeItem.dataset.message = newMessage;
              const msgPreview = activeItem.querySelector('.message');
              if (msgPreview) {
                msgPreview.textContent = newMessage.substring(0, 50) + (newMessage.length > 50 ? '...' : '');
              }
            }

            editBtn.style.display = '';
            deleteBtn.style.display = '';
            isEditMode = false;
            originalMessage = '';
          } else {
            showNotif('Error: ' + data.message, 'danger');
          }
        })
        .catch(err => {
          console.error('Fetch error:', err);
          showNotif('Error updating request', 'danger');
        });
      };

      // Cancel button
      document.getElementById('cancelEditBtn').onclick = () => {
        cancelEdit();
      };

      return;
    }

    // delete logic update pa
    if (action === 'delete') {
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        confirmBtn.onclick = () => {
          confirmModal.hide();

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
              loadRequests();
            } else {
              showNotif('Error: ' + data.message, 'danger');
            }
          })
          .catch(err => {
            console.error('Fetch error:', err);
            showNotif('Error deleting request', 'danger');
          });
        };

        confirmModal.show();
      }
  });
  // notif pantanga
  function showNotif(message, type) {
    const notifContainer = document.getElementById('notifContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} shadow-sm alert-dismissible fade show`;
    alert.role = 'alert';
    alert.innerHTML = `
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    notifContainer.appendChild(alert);

    setTimeout(() => {
      alert.classList.remove('show');
      setTimeout(() => alert.remove(), 300);
    }, 3000);
  }

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
