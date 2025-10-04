<?php
require_once __DIR__ . '/../includes/database.php';
include('../includes/user-sidebar.php');

  try {
    $type = isset($_GET['type']) ? trim($_GET['type']) : null;
    $status = isset($_GET['status']) ? trim($_GET['status']) : null;

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT request_id, request_type, subject, message, status, created_at FROM customer_request WHERE user_id = :user_id";
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


  } catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
  }

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

                <div class="d-flex justify-content-center gap-2 mb-3">
                  <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" id="typeButton" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <?= htmlspecialchars($currentType) ?>
                    </a>
                    <ul class="dropdown-menu dropend">
                      <li><a class="dropdown-item" href="request.php?status=<?= urlencode($status ?? '') ?>">All</a></li>
                      <li><a class="dropdown-item" href="?type=inquiry&status=<?= urlencode($status ?? '') ?>">Inquiry</a></li>
                      <li><a class="dropdown-item" href="?type=complaint&status=<?= urlencode($status ?? '') ?>">Complaint</a></li>
                      <li><a class="dropdown-item" href="?type=custom_order&status=<?= urlencode($status ?? '') ?>">Custom Order</a></li>
                      <li><a class="dropdown-item" href="?type=other&status=<?= urlencode($status ?? '') ?>">Other</a></li>
                    </ul>
                  </div>

                  <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" id="statusButton" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <?= htmlspecialchars($currentStatus) ?>
                    </a>
                    <ul class="dropdown-menu dropend">
                      <li><a class="dropdown-item" href="request.php?type=<?= urlencode($type ?? '') ?>">All</a></li>
                      <li><a class="dropdown-item" href="?status=pending&type=<?= urlencode($type ?? '') ?>">Pending</a></li>
                      <li><a class="dropdown-item" href="?status=in-progress&type=<?= urlencode($type ?? '') ?>">In-progress</a></li>
                      <li><a class="dropdown-item" href="?status=resolved&type=<?= urlencode($type ?? '') ?>">Resolved</a></li>
                      <li><a class="dropdown-item" href="?status=closed&type=<?= urlencode($type ?? '') ?>">Closed</a></li>
                    </ul>

                  </div>

                </div>

              <?php foreach ($requests as $index => $request): ?>
                <div class="request-item <?= $index === 0 ? 'first-request' : '' ?>"
                     data-title="<?= htmlspecialchars($request['subject']); ?>"
                     data-message="<?= htmlspecialchars($request['message']); ?>"
                     data-type="<?= htmlspecialchars($request['request_type']); ?>"
                     data-status="<?= htmlspecialchars($request['status']); ?>"
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

           <div class="col-12 col-md-8 col-lg-9 request-detail bg-light p-4">
              <h4 id="requestTitle" style="color: #1e40af;"class="mb-3">Select a request</h4>

              <div class="d-flex align-items-center gap-3 mb-3">
                <span id="requestType" class="badge bg-secondary text-capitalize">Type</span>
                    <span id="requestStatus" class="badge bg-warning text-dark text-capitalize">Pending</span>
                  </div>

              <div class="card shadow-sm">
                <div class="card-body">
                  <?php if (empty($requests)): ?>
                  <div class="text-center text-muted p-3">No requests found.</div>
                <?php elseif (!empty($request)): ?>
                  <h6 class="text-muted mb-2">Message</h6>
                  <p id="requestContent" class="mb-3"></p>
                  <h6 class="text-muted mb-2">Date Submitted</h6>
                  <p id="requestDate" class="mb-0">—</p>
                <?php endif; ?>
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
