<?php
include_once 'db.php';

$type = $_GET['type'] ?? 'stats';

if ($type !== 'stats') {
    die("Invalid export type");
}

// Fetch completed today tasks
$today = date('Y-m-d');
$completedResult = mysqli_query($con, "SELECT title FROM tasks WHERE status='completed' AND DATE(completed_at)='$today' ORDER BY completed_at DESC");

// Fetch pending tasks
$pendingResult = mysqli_query($con, "SELECT title FROM tasks WHERE status='pending' ORDER BY created_at DESC");

// File name
$filename = 'tasks_stats_' . date('Y-m-d') . '.txt';

// Headers for download
header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$output = fopen('php://output', 'w');

// Completed Today
fwrite($output, "=== Completed Today ===\n");
$sr = 1;
while ($row = mysqli_fetch_assoc($completedResult)) {
    fwrite($output, $sr . ". " . $row['title'] . "\n");
    $sr++;
}
fwrite($output, "\n");

// Pending
fwrite($output, "=== Pending Tasks ===\n");
$sr = 1;
while ($row = mysqli_fetch_assoc($pendingResult)) {
    fwrite($output, $sr . ". " . $row['title'] . "\n");
    $sr++;
}

fclose($output);
exit;
