  <?php
  require_once __DIR__ . '/../includes/database.php';
  include('../includes/user-sidebar.php');

  $type = isset($_GET['type']) ? trim($_GET['type']) : null;
  $status = isset($_GET['status']) ? trim($_GET['status']) : null;
  $user_id = $_SESSION['user_id'];

  $sql = "SELECT request_id, request_type, subject, message, status, created_at, admin_response FROM customer_request WHERE user_id = :user_id";
  $requestFilter = [':user_id'=>$user_id];

  if($type){
    $sql .= " AND request_type = :type"; $requestFilter[':type'] = $type;
  }
  if($status){
    $sql .= " AND status = :status"; $requestFilter[':status'] = $status;
  }
  $stmtRequest = $pdo->prepare($sql);
  $stmtRequest->execute($requestFilter);
  $requests = $stmtRequest->fetchAll(PDO::FETCH_ASSOC);

  $currentType = $type ? ucfirst(str_replace("_", " ", $type)) : "All Types";
  $currentStatus = $status ? ucfirst(str_replace("-", " ", $status)) : "All Status";
   ?>
   <!DOCTYPE html>
   <html lang="en" dir="ltr">
     <head>
       <meta charset="utf-8">
       <title>Request</title>
       <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="../assets/css/user-sidebar.css">
       <link rel="stylesheet" href="../assets/css/request.css">
     </head>
     <body>
       <div class="main-content">

         <div class="container-fluid">
           <div class="row">
             <div class="col-12 col-md-4 col-lg-3 request-list bg-white">
               <h5 class="p-3 border-bottom text-center fw-bold" style="color: #1e40af;">My Requests</h5>

               <!-- FIXED DROPDOWN SECTION in request.php -->
                      <div class="d-flex justify-content-center gap-2 mb-3">
                       <!-- TYPE FILTER DROPDOWN -->
                       <div class="dropdown">
                           <a class="btn btn-primary dropdown-toggle" id="typeButton" role="button"
                              data-bs-toggle="dropdown" aria-expanded="false">
                               <?= htmlspecialchars($currentType) ?>
                           </a>
                           <ul class="dropdown-menu">
                               <li><a class="dropdown-item filter-btn" data-filter-type="type" data-value="">All Types</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="type" data-value="inquiry">Inquiry</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="type" data-value="complaint">Complaint</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="type" data-value="custom_order">Custom Order</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="type" data-value="other">Other</a></li>
                           </ul>
                       </div>

                       <!-- STATUS FILTER DROPDOWN -->
                       <div class="dropdown">
                           <a class="btn btn-primary dropdown-toggle" id="statusButton" role="button"
                              data-bs-toggle="dropdown" aria-expanded="false">
                               <?= htmlspecialchars($currentStatus) ?>
                           </a>
                           <ul class="dropdown-menu">
                               <li><a class="dropdown-item filter-btn" data-filter-type="status" data-value="">All Status</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="status" data-value="pending">Pending</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="status" data-value="in-progress">In Progress</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="status" data-value="resolved">Resolved</a></li>
                               <li><a class="dropdown-item filter-btn" data-filter-type="status" data-value="closed">Closed</a></li>
                           </ul>
                       </div>
                      </div>

                  <div id="requestItemsContainer">
                     <?php foreach ($requests as $index => $request): ?>
                       <div class="request-item <?= $index === 0 ? 'first-request' : '' ?>"
                            data-title="<?= htmlspecialchars($request['subject']); ?>"
                            data-message="<?= htmlspecialchars($request['message']); ?>"
                            data-type="<?= htmlspecialchars($request['request_type']); ?>"
                            data-status="<?= htmlspecialchars($request['status']); ?>"
                            data-admin_response="<?= htmlspecialchars($request['admin_response']); ?>"
                            data-date="<?= date("M d, Y h:i A", strtotime($request['created_at'])) ?>"
                            onclick="showRequestFromElement(this)">
                         <strong class="subject"><?= htmlspecialchars($request['subject']); ?></strong>
                         <div class="text-muted small message">
                           <?= htmlspecialchars(mb_strimwidth($request['message'], 0, 50, '...')); ?>
                         </div>
                       </div>
                     <?php endforeach; ?>

                     <?php if (empty($requests)): ?>
                       <div class="text-center text-muted p-3">No requests found.</div>
                     <?php endif; ?>
                   </div>
                 </div>

             <div class="col-12 col-md-8 col-lg-9 request-detail bg-light p-4">
                <h4 id="requestTitle" style="color: #1e40af;"class="mb-3">Select a request</h4>

                <div class="d-flex align-items-center gap-3 mb-3">
                  <span id="requestType" class="badge bg-secondary text-capitalize">Type</span>
                      <span id="requestStatus" class="badge bg-warning text-dark text-capitalize">Pending</span>
                    </div>

                <div class="card">
                  <div class="card-body">
                    <?php if (empty($requests)): ?>
                    <div class="text-center text-muted p-3">No requests found.</div>
                  <?php elseif (!empty($request)): ?>
                    <h6 class="text-muted mb-2">Message</h6>
                    <p id="requestContent" class="mb-3"></p>
                    <h6 class="text-muted mb-2">Date Submitted</h6>
                    <p id="requestDate" class="mb-0">—</p>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                      <button id="editBtn" class="btn btn-outline-primary btn-sm"> <img src="../assets/svg/edit.svg" alt="edit button"> </button>
                      <button id="deleteBtn" class="btn btn-outline-danger btn-sm"> <img src="../assets/svg/delete.svg" alt="delete button"> </button>
                    </div>
                  <?php endif; ?>
                  </div>
                </div>
                <div class="card mt-3">
                  <div class="card-body">
                    <h6 class="text-muted mb-2">Admin’s Reply</h6>
                      <p class="mb-0 text-body" id="adminReply">No admin reply yet.</p>

                  </div>
                </div>
              </div>


           </div>
         </div>

       </div>
          <script src="../assets/js/request.js"></script>
          <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
     </body>
   </html>
