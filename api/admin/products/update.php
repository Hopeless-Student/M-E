<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../../../includes/api_auth.php'; // Uncomment to enable authentication

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Support form-data and JSON
$input = $_POST;
if (empty($input)) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);
    if (is_array($json)) { $input = $json; }
}

$id = isset($input['id']) ? (int)$input['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product id']);
    exit;
}

// Get current product data (for old image cleanup)
$sqlCurrent = "SELECT product_image FROM products WHERE product_id = :id LIMIT 1";
$stmtCurrent = $pdo->prepare($sqlCurrent);
$stmtCurrent->execute([':id' => $id]);
$currentProduct = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

if (!$currentProduct) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

$oldImage = $currentProduct['product_image'];

$fields = [];
$params = [':id' => $id];

// Validate and add fields
if (isset($input['product_name'])) {
    $name = trim($input['product_name']);
    if (strlen($name) > 255) {
        http_response_code(400);
        echo json_encode(['error' => 'Product name too long (max 255 characters)']);
        exit;
    }
    $fields[] = 'product_name = :name';
    $params[':name'] = $name;
}

if (isset($input['product_code'])) {
    $fields[] = 'product_code = :sku';
    $params[':sku'] = trim($input['product_code']);
}

if (isset($input['description'])) {
    $desc = trim($input['description']);
    if (strlen($desc) > 1000) {
        http_response_code(400);
        echo json_encode(['error' => 'Description too long (max 1000 characters)']);
        exit;
    }
    $fields[] = 'description = :desc';
    $params[':desc'] = $desc;
}

if (isset($input['price'])) {
    $fields[] = 'price = :price';
    $params[':price'] = (float)$input['price'];
}

if (isset($input['stock'])) {
    $fields[] = 'stock_quantity = :stock';
    $params[':stock'] = (int)$input['stock'];
}

if (isset($input['unit'])) {
    $unit = strtolower(trim($input['unit']));
    $allowedUnits = ['box', 'pieces', 'reams', 'rolls', 'gallon', 'pack', 'pads'];
    if (!in_array($unit, $allowedUnits)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid unit']);
        exit;
    }
    $fields[] = 'unit = :unit';
    $params[':unit'] = $unit;
}

if (isset($input['category'])) {
    $cat = trim($input['category']);
    if (ctype_digit($cat)) {
        $fields[] = 'category_id = :catId';
        $params[':catId'] = (int)$cat;
    } else {
        // Map category names/slugs
        $catMap = [
            'office' => ['office-supplies', 'Office Supplies'],
            'school' => ['school-supplies', 'School Supplies'],
            'sanitary' => ['sanitary', 'Sanitary', 'Hygiene Products', 'Sanitary Supplies']
        ];

        $searches = [];
        $catLower = strtolower($cat);
        if (isset($catMap[$catLower])) {
            $searches = $catMap[$catLower];
        } else {
            $searches[] = $cat;
        }

        $catId = 0;
        foreach ($searches as $searchTerm) {
            $sqlCat = "SELECT category_id FROM categories WHERE category_slug = :c OR category_name = :c LIMIT 1";
            $stmt = $pdo->prepare($sqlCat);
            $stmt->execute([':c' => $searchTerm]);
            $catId = (int)($stmt->fetchColumn() ?: 0);
            if ($catId > 0) break;
        }

        if ($catId > 0) {
            $fields[] = 'category_id = :catId';
            $params[':catId'] = $catId;
        }
    }
}

// Handle new image if provided via multipart
$newImageUploaded = false;
$newImageFilename = null;

if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['product_image']['tmp_name'];
    $orig = basename($_FILES['product_image']['name']);
    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image format']);
        exit;
    }

    // Validate file size
    $maxSize = 5 * 1024 * 1024;
    if (@filesize($tmp) > $maxSize) {
        http_response_code(400);
        echo json_encode(['error' => 'Image too large (max 5MB)']);
        exit;
    }

    // Validate image
    $imageInfo = @getimagesize($tmp);
    if ($imageInfo === false) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image file']);
        exit;
    }

    $newImageFilename = 'prod_' . time() . '_' . mt_rand(1000,9999) . '.' . $ext;
    $destDir = __DIR__ . '/../../../assets/images/products/';

    if (!is_dir($destDir)) {
        @mkdir($destDir, 0775, true);
    }

    if (!move_uploaded_file($tmp, $destDir . $newImageFilename)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save image']);
        exit;
    }

    $fields[] = 'product_image = :img';
    $params[':img'] = $newImageFilename;
    $newImageUploaded = true;
}

if (count($fields) === 0) {
    echo json_encode(['success' => true, 'message' => 'No changes to update']);
    exit;
}

try {
    // Update the product
    $sql = 'UPDATE products SET ' . implode(', ', $fields) . ' WHERE product_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Delete old image if new image was uploaded successfully
    if ($newImageUploaded && $oldImage) {
        $oldImagePath = __DIR__ . '/../../../assets/images/products/' . $oldImage;
        if (file_exists($oldImagePath)) {
            @unlink($oldImagePath);
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product updated successfully']);

} catch (PDOException $e) {
    // If update fails and new image was uploaded, delete the new image
    if ($newImageUploaded && $newImageFilename) {
        $newImagePath = __DIR__ . '/../../../assets/images/products/' . $newImageFilename;
        if (file_exists($newImagePath)) {
            @unlink($newImagePath);
        }
    }

    if ($e->getCode() == 23000) {
        http_response_code(400);
        echo json_encode(['error' => 'Product code already exists']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
    exit;
}
?>
