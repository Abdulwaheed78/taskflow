<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action == 'list') {
    $search = $_GET['search'] ?? '';
    $cat = $_GET['category'] ?? '';
    $priority = $_GET['priority'] ?? '';
    $status = $_GET['status'] ?? '';
    
    $query = "SELECT t.*, c.name as category_name, c.color FROM tasks t 
              LEFT JOIN categories c ON t.category_id = c.id WHERE 1=1";
    $params = [];

    if ($search) {
        $query .= " AND (t.title LIKE ? OR t.description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    if ($cat) {
        $query .= " AND t.category_id = ?";
        $params[] = $cat;
    }
    if ($priority) {
        $query .= " AND t.priority = ?";
        $params[] = $priority;
    }
    if ($status) {
        $query .= " AND t.status = ?";
        $params[] = $status;
    }

    $query .= " ORDER BY t.position ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    echo json_encode($stmt->fetchAll());
}

if ($action == 'stats') {
    $total = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
    $pending = $pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'Pending'")->fetchColumn();
    $completed = $pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'Completed'")->fetchColumn();
    echo json_encode(['total' => $total, 'pending' => $pending, 'completed' => $completed]);
}

if ($action == 'save') {
    $id = $_POST['id'] ?? null;
    $title = htmlspecialchars($_POST['title']);
    $cat_id = $_POST['category_id'];
    $priority = $_POST['priority'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE tasks SET title=?, category_id=?, priority=? WHERE id=?");
        $stmt->execute([$title, $cat_id, $priority, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO tasks (title, category_id, priority) VALUES (?, ?, ?)");
        $stmt->execute([$title, $cat_id, $priority]);
    }
    echo json_encode(['status' => 'success']);
}

if ($action == 'toggle') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE tasks SET status = IF(status='Pending', 'Completed', 'Pending'), completed_at = IF(status='Completed', NOW(), NULL) WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
}

if ($action == 'delete') {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    echo json_encode(['status' => 'success']);
}