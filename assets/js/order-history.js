
document.addEventListener("DOMContentLoaded", function() {
  const detailButtons = document.querySelectorAll(".btn-details");
  const modalEl = document.getElementById("orderDetailsModal");
const modal = new bootstrap.Modal(modalEl);
const modalContent = document.getElementById("orderDetailsContent");

  detailButtons.forEach(button => {
    button.addEventListener("click", function(e) {
      e.preventDefault();
      const orderNumber = this.href.split('order_id=')[1];

      modalContent.innerHTML = `<p class="text-center text-muted">Loading details...</p>`;
      modal.show();

      fetch(`order-details.php?order_id=${encodeURIComponent(orderNumber)}`)
        .then(response => response.text())
        .then(data => {
          modalContent.innerHTML = data;
        })
        .catch(err => {
          console.error(err);
          modalContent.innerHTML = `<p class="text-danger text-center">Failed to load order details.</p>`;
        });
    });
  });
  const links = document.querySelectorAll(".status a");
  const container = document.querySelector("#order-list");

  links.forEach(link => {
    link.addEventListener("click", function(e) {
      e.preventDefault();
      const status = this.textContent.trim();

      links.forEach(l => l.classList.remove("active"));
      this.classList.add("active");

      const orderContainer = document.getElementById("order-container");
      fetch(`../ajax/fetch-order-history.php?status=${encodeURIComponent(status)}`)
        .then(res => res.json())
        .then(data => {
          setTimeout(()=>{
            if (data.success && data.orders.length > 0) {
              container.innerHTML = renderOrders(data.orders);
            } else {
              // dito yung no order error ko
              if(status === "All"){
                container.innerHTML = `<div class="text-center">
                <img src="../assets/images/order-history.png" class="img-fluid" style="max-height:250px;" alt="order history">
                <p class="fs-3 fw-bold" style="color: #002366;">You Have No Order History</p>
                <small>You haven't order anything yet. <br>Your Order History will appear here once you have!</small>
                </div>`
              } else { // else lang pala need wtf
                container.innerHTML = `<div class="text-center">
                <img src="../assets/images/order-history.png" class="img-fluid" style="max-height:250px;" alt="order history">
                <p class="fs-3 fw-bold" style="color: #002366;">No Orders Found for this "${status}".</p>
                </div>`;
              }
              container.style.opacity = 1;
            }
          },200);
        })
        .catch(err => {
          console.error(err);
          container.innerHTML = `<p class="text-danger text-center">Failed to load orders.</p>`;
        });
    });
  });

  function renderOrders(orders) {
    return orders.map(order => `
      <div class="items-container">
        <div class="order-header">
          <p>${new Date(order.order_date).toLocaleDateString()} | Order No: ${order.order_number}</p>
          <p>Total: ₱ <strong>${Number(order.final_amount).toFixed(2)}</strong></p>
        </div>
        <span class="order-status status-${order.order_status.toLowerCase()}">
          ${order.order_status}
        </span>
        <hr>
        ${order.items.map(item => `
          <div class="item">
            <img src="../assets/images/products/yellowpad.jpg" alt="item sample">
            <div class="item-text">
              <p class="mb-2">${item.product_name}</p>
              <sub>₱ ${Number(item.price).toFixed(2)} × ${item.qty}</sub>
            </div>
          </div>
        `).join('')}
        <div class="text-end mt-3">
          <a href="order-details.php?order_id=${encodeURIComponent(order.order_number)}" class="btn btn-details">Order Details</a>
        </div>
      </div>
    `).join('');
  }
  document.querySelector(".order-content").addEventListener("click", function(e) {
  if (e.target.closest(".btn-details")) {
    e.preventDefault();
    const button = e.target.closest(".btn-details");
    const orderNumber = button.href.split('order_id=')[1];

    // const modal = new bootstrap.Modal(document.getElementById("orderDetailsModal"));
    // // const modalContent = document.getElementById("orderDetailsContent");

    modalContent.innerHTML = `<p class="text-center text-muted">Loading details...</p>`;
    modal.show();

    fetch(`order-details.php?order_id=${encodeURIComponent(orderNumber)}`)
      .then(response => response.text())
      .then(data => modalContent.innerHTML = data)
      .catch(err => {
        console.error(err);
        modalContent.innerHTML = `<p class="text-danger text-center">Failed to load order details.</p>`;
      });
  }
});

});
