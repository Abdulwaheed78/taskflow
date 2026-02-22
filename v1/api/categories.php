<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

// List all categories for dropdowns/filters
if ($action == 'list') {
    try {
        $stmt = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM tasks t WHERE t.category_id = c.id AND t.status = 'Pending') as pending_count FROM categories c ORDER BY c.name ASC");
        echo json_encode($stmt->fetchAll());
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Add a new category (The "Website" system)
if ($action == 'add') {
    $name = trim($_POST['name'] ?? '');
    $color = $_POST['color'] ?? '#6c757d';

    if (empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Name is required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO categories (name, color) VALUES (?, ?)");
        $stmt->execute([htmlspecialchars($name), $color]);
        echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Duplicate category name']);
    }
}