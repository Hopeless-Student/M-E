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
          requestList.innerHTML = `<div class="text-center text-danger p-3">Error: ${err.message}</div>`;
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
});
