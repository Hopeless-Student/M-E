<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';

try {
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $pageSize = isset($_GET['pageSize']) ? min(48, max(1, (int)$_GET['pageSize'])) : 12;
    $sort = $_GET['sort'] ?? 'default';
    $category = $_GET['category'] ?? 'all';
    $q = trim($_GET['q'] ?? '');
    $idsParam = isset($_GET['ids']) ? trim($_GET['ids']) : '';

    $offset = ($page - 1) * $pageSize;

    $where = ['p.isActive = 1'];
    $params = [];
    $idBindings = [];

    // Filter by product id
    if ($idsParam !== '') {
        $ids = array_values(array_filter(array_map('intval', explode(',', $idsParam)), function ($v) {
            return $v > 0;
        }));

        if (count($ids) > 0) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $where[] = "p.product_id IN ($placeholders)";
            $idBindings = $ids;
        }
    }

    // Category filter
    if ($category !== 'all') {
        if (ctype_digit($category)) {
            $where[] = 'p.category_id = :catId';
            $params[':catId'] = (int)$category;
        } else {
            $where[] = '(c.category_slug = :catSlug OR c.category_name = :catName)';
            $params[':catSlug'] = $category;
            $params[':catName'] = $category;
        }
    }

    // Search filter
    if ($q !== '') {
        $where[] = '(p.product_name LIKE :q OR p.description LIKE :q OR c.category_name LIKE :q)';
        $params[':q'] = '%' . $q . '%';
    }

    // Sorting
    $orderBy = 'p.created_at DESC';
    switch ($sort) {
        case 'price-low':
            $orderBy = 'p.price ASC';
            break;
        case 'price-high':
            $orderBy = 'p.price DESC';
            break;
        case 'name-az':
            $orderBy = 'p.product_name ASC';
            break;
        case 'name-za':
            $orderBy = 'p.product_name DESC';
            break;
    }

    $whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

    // Get total count
    $countSql = "SELECT COUNT(*) FROM products p
                 INNER JOIN categories c ON c.category_id = p.category_id
                 $whereSql";

    $stmt = $pdo->prepare($countSql);

    // Bind named parameters
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }

    // Bind ID parameters
    if (count($idBindings) > 0) {
        $pos = 1;
        foreach ($idBindings as $id) {
            $stmt->bindValue($pos++, $id, PDO::PARAM_INT);
        }
    }

    $stmt->execute();
    $total = (int)$stmt->fetchColumn();

    // Get products
    $sql = "SELECT p.product_id, p.product_name, p.description, p.price,
                   p.product_image, p.stock_quantity, p.unit,
                   c.category_name, c.category_slug
            FROM products p
            INNER JOIN categories c ON c.category_id = p.category_id
            $whereSql
            ORDER BY $orderBy
            LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);

    // Bind named parameters
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }

    // Bind ID parameters
    if (count($idBindings) > 0) {
        $pos = 1;
        foreach ($idBindings as $id) {
            $stmt->bindValue($pos++, $id, PDO::PARAM_INT);
        }
    }

    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $baseImg = '../assets/images/products/';
    $items = array_map(function ($r) use ($baseImg) {
        $img = $r['product_image'] ? ($baseImg . $r['product_image']) : '../assets/images/default.png';
        return [
            'id' => (int)$r['product_id'],
            'title' => $r['product_name'],
            'description' => $r['description'] ?? '',
            'price' => (float)$r['price'],
            'unit' => $r['unit'] ?? 'piece',
            'category' => $r['category_name'],
            'category_slug' => $r['category_slug'],
            'image' => $img,
            'stock' => (int)$r['stock_quantity'],
        ];
    }, $rows);

    echo json_encode([
        'success' => true,
        'items' => $items,
        'total' => $total,
        'page' => $page,
        'pageSize' => $pageSize,
        'totalPages' => max(1, (int)ceil($total / $pageSize)),
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error occurred',
        'message' => 'Unable to fetch products at this time'
    ]);
    error_log('Products API Error: ' . $e->getMessage());
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error',
        'message' => 'An unexpected error occurred'
    ]);
    error_log('Products API Error: ' . $e->getMessage());
}
?>
