
    <style>
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        /* Modal Container */
        .modal {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Modal Header */
        .modal-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
        }

        .close-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .close-btn:hover {
            background-color: #f1f5f9;
            color: #334155;
        }

        /* Modal Body */
        .modal-body {
            padding: 1.5rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.25rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.875rem;
        }

        .form-label.required::after {
            content: ' *';
            color: #dc2626;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Image Upload */
        .image-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            align-items: start;
        }

        .current-image-container {
            text-align: center;
        }

        .current-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin-bottom: 0.5rem;
        }

        .current-image-label {
            font-size: 0.75rem;
            color: #64748b;
        }

        .file-upload-container {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: border-color 0.2s ease;
            background: #f9fafb;
            position: relative;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .file-upload-container:hover {
            border-color: #1e40af;
            background: #eff6ff;
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-label {
            cursor: pointer;
            color: #1e40af;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .file-upload-text {
            color: #64748b;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin-top: 0.5rem;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        .btn .lucide {
            width: 16px;
            height: 16px;
        }

        /* Delete Confirmation Modal */
        .delete-modal {
            max-width: 400px;
        }

        .delete-modal .modal-body {
            text-align: center;
            padding: 1.5rem;
        }

        .delete-modal .modal-body p {
            color: #64748b;
            margin-bottom: 1.5rem;
        }


        /* Alert */
        .alert {
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            z-index: 1100;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .alert.show {
            transform: translateX(0);
        }

        .alert.success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert.error {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* ============================================
     MOBILE RESPONSIVE - EDIT-PRODUCT.PHP
     Add this to the <style> section in edit-product.php
     ============================================ */

  /* Tablet & Mobile (1024px and below) */
  @media (max-width: 1024px) {
      .modal {
          width: 90%;
          max-height: 85vh;
      }

      .form-row {
          grid-template-columns: 1fr;
      }

      .image-section {
          grid-template-columns: 1fr;
      }

      .current-image,
      .image-preview {
          width: 120px;
          height: 120px;
      }
  }

  /* Mobile (768px and below) */
  @media (max-width: 768px) {
      .modal {
          width: 95%;
      }

      .modal-header {
          padding: 1rem 1.25rem;
      }

      .modal-title {
          font-size: 1.1rem;
      }

      .modal-body {
          padding: 1.25rem;
      }

      .form-label {
          font-size: 0.85rem;
      }

      .form-input,
      .form-textarea,
      .form-select {
          font-size: 0.875rem;
          min-height: 44px;
      }

      .current-image,
      .image-preview {
          width: 100px;
          height: 100px;
      }

      .modal-footer {
          flex-wrap: wrap;
      }

      .btn {
          flex: 1;
          min-width: calc(50% - 0.5rem);
          font-size: 0.85rem;
          min-height: 44px;
      }

      .delete-modal {
          width: 95%;
      }
  }

  /* Small Mobile (640px and below) */
  @media (max-width: 640px) {
      .modal {
          width: 100%;
          height: 100%;
          max-height: 100vh;
          border-radius: 0;
      }

      .modal-header {
          padding: 0.875rem 1rem;
      }

      .modal-title {
          font-size: 1rem;
      }

      .modal-body {
          padding: 1rem;
          max-height: calc(100vh - 140px);
          overflow-y: auto;
      }

      .form-input,
      .form-textarea,
      .form-select {
          font-size: 0.8rem;
      }

      .current-image,
      .image-preview {
          width: 90px;
          height: 90px;
      }

      .modal-footer {
          flex-direction: column;
          padding: 0.75rem 1rem;
      }

      .btn {
          width: 100%;
          min-width: auto;
      }

      .delete-modal {
          width: calc(100% - 2rem);
      }
  }
    </style>
</head>
<body>
    <!-- Demo Button -->
    <!-- <button class="demo-btn" onclick="openEditModal()">Open Edit Product Modal</button> -->

    <!-- Edit Product Modal -->
    <div class="modal-overlay" id="editModal" onclick="closeModal(event)">
        <div class="modal" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 class="modal-title">Edit Product</h3>
                <button type="button" class="close-btn" onclick="closeModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label required" for="productName">Product Name</label>
                        <input type="text" class="form-input" id="productName" name="product_name" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required" for="productCategory">Category</label>
                            <select class="form-select" id="productCategory" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Office">Office Supplies</option>
                                <option value="School">School Supplies</option>
                                <option value="Sanitary">Sanitary Supplies</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label required" for="productPrice">Price (₱)</label>
                            <input type="number" class="form-input" id="productPrice" name="price" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="productDescription">Description</label>
                        <textarea class="form-textarea" id="productDescription" name="description" required placeholder="Enter product description..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label required" for="productCode">Product Code</label>
                        <input type="text" class="form-input" id="productCode" name="product_code" placeholder="e.g BP-BLK01">
                    </div>


                    <div class="form-group">
                        <label class="form-label">Product Image</label>
                        <div class="image-section">
                            <div class="current-image-container" id="currentImageContainer">
                                <img id="currentImage" class="current-image" src="" alt="Current product">
                                <div class="current-image-label">Current Image</div>
                            </div>
                            <div class="file-upload-container">
                                <input type="file" class="file-upload-input" id="productImage" name="product_image" accept="image/*">
                                <div class="file-upload-label">Upload New Image</div>
                                <div class="file-upload-text">PNG, JPG up to 5MB</div>
                                <img id="imagePreview" class="image-preview" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="button" class="btn btn-danger" id="deleteModal2" onclick="openDeleteModal()">
                        <i data-lucide="trash-2"></i>
                        Delete
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal" style="display: none;">
        <div class="modal delete-modal">
            <div class="modal-header">
                <h3 class="modal-title" style="color: #dc2626;">Confirm Deletion</h3>
                <button type="button" class="close-btn" onclick="closeDeleteModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product? This action cannot be undone.</p>
                <div style="display: flex; gap: 0.75rem; justify-content: center;">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Container -->
    <div class="alert" id="alertContainer"></div>


</body>
</html>
