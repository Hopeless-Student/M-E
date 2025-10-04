function showRequestFromElement(element) {
   document.getElementById("requestTitle").innerText = element.dataset.title;
   document.getElementById("requestContent").innerText = element.dataset.message;
   document.getElementById("requestType").innerText = element.dataset.type;
   document.getElementById("requestStatus").innerText = element.dataset.status;
   document.getElementById("requestDate").innerText = element.dataset.date;
   const typeButton = document.getElementById('typeButton');
   const statusButton = document.getElementById('statusButton');

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
 }
 window.addEventListener("DOMContentLoaded", function () {
   const firstRequest = document.querySelector(".request-item.first-request");
   if (firstRequest) {
     showRequestFromElement(firstRequest);
   }
 });
