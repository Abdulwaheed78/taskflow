<?php
include 'db.php';
$action = $_REQUEST['action'] ?? '';

if ($action == 'create') {
    // Create a new task
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $website = mysqli_real_escape_string($con, $_POST['website'] ?: 'General');
    $priority = mysqli_real_escape_string($con, $_POST['priority'] ?: 'Low');

    mysqli_query($con, "INSERT INTO tasks(title, website, priority, status, created_at) 
                        VALUES('$title','$website','$priority','pending', NOW())");

    echo "success";
} elseif ($action == 'fetch') {
    // Fetch tasks for table
    $status = $_GET['status'] ?? 'pending';
    $priority = $_GET['priority'] ?? 'all';
    $website = $_GET['website'] ?? 'all';
    $search = $_GET['search'] ?? '';

    $page = max(1, intval($_GET['page'] ?? 1));
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $query = "SELECT * FROM tasks WHERE 1";

    if ($status != 'all') $query .= " AND status='$status'";
    if ($priority != 'all') $query .= " AND priority='$priority'";
    if ($website != 'all') $query .= " AND website='$website'";
    if ($search != '') $query .= " AND title LIKE '%" . mysqli_real_escape_string($con, $search) . "%'";

    // Total count for pagination
    $totalResult = mysqli_query($con, $query);
    $totalRows = mysqli_num_rows($totalResult);
    $totalPages = max(1, ceil($totalRows / $limit));

    // Add limit & offset
    $query .= " ORDER BY FIELD(priority,'High','Medium','Low'), created_at DESC LIMIT $offset, $limit";
    $res = mysqli_query($con, $query);

    echo '<table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Website</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';

    $i = $offset + 1;
    while ($task = mysqli_fetch_assoc($res)) {
        $detailsCard = "<b>Title:</b> " . htmlspecialchars($task['title']) .
            "<br><b>Website:</b> " . htmlspecialchars($task['website']) .
            "<br><b>Priority:</b> " . htmlspecialchars($task['priority']) .
            "<br><b>Status:</b> " . ucfirst($task['status']);
        echo '
<tr data-id="' . $task['id'] . '" class="priority-' . $task['priority'] . '">
    <td>' . ($i++) . '</td>
    <td>
        <input type="text" value="' . htmlspecialchars($task['title']) . '" 
            class="form-control form-control-sm edit_input edit_title" 
            data-details="' . $detailsCard . '">
    </td>
    <td>
        <input type="text" value="' . htmlspecialchars($task['website']) . '" 
            class="form-control form-control-sm edit_input edit_website">
    </td>
    <td>
        <select class="form-select form-select-sm edit_input edit_priority">
            <option value="High" ' . ($task['priority'] == 'High' ? 'selected' : '') . '>High</option>
            <option value="Medium" ' . ($task['priority'] == 'Medium' ? 'selected' : '') . '>Medium</option>
            <option value="Low" ' . ($task['priority'] == 'Low' ? 'selected' : '') . '>Low</option>
        </select>
    </td>
    <td class="text-start">
        <input type="checkbox" class="form-check-input toggle-status" data-id="' . $task['id'] . '" ' . ($task['status'] == 'completed' ? 'checked' : '') . '>
        <span class="status-text">' . ucfirst($task['status']) . '</span>
    </td>
    <td class="text-center">
        <button class="icon-btn delete_task" data-id="' . $task['id'] . '" title="Delete Task">
            <i class="bi bi-trash3"></i>
        </button>
    </td>
</tr>';
    }

    echo '</tbody></table>';

    // Pagination
    echo '<nav class="mt-2"><ul class="pagination justify-content-center align-items-center">';

    $prevPage = max(1, $page - 1);
    $nextPage = min($totalPages, $page + 1);

    $disabledPrev = $page == 1 ? 'disabled' : '';
    $disabledNext = $page == $totalPages ? 'disabled' : '';

    echo '<li class="page-item ' . $disabledPrev . '">
        <a class="page-link rounded-pill" href="#" data-page="' . $prevPage . '"><</a>
    </li>';

    echo '<li class="page-item disabled mx-2">
        <span class="page-link rounded-pill">Page ' . $page . ' of ' . $totalPages . '</span>
    </li>';

    echo '<li class="page-item ' . $disabledNext . '">
        <a class="page-link rounded-pill" href="#" data-page="' . $nextPage . '">></a>
    </li>';

    echo '<li class="ms-3 d-flex align-items-center">
        <input type="number" min="1" max="' . $totalPages . '" value="' . $page . '" class="form-control form-control-sm rounded-pill" style="width:80px" id="goto_page_input">
        <button class="btn btn-primary btn-sm ms-2 rounded-pill" id="goto_page_btn">Go</button>
    </li>';

    echo '</ul></nav>';
} elseif ($action == 'edit') {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $priority = mysqli_real_escape_string($con, $_POST['priority']);
    $website = mysqli_real_escape_string($con, $_POST['website']);
    mysqli_query($con, "UPDATE tasks SET title='$title', status='$status', priority='$priority', website='$website' WHERE id=$id");
    echo "success";
} elseif ($action == 'delete') {
    $id = intval($_GET['id']);
    mysqli_query($con, "DELETE FROM tasks WHERE id=$id");
    echo "success";
} elseif ($action == 'websites') {
    $res = mysqli_query($con, "SELECT DISTINCT website FROM tasks ORDER BY website ASC");
    while ($w = mysqli_fetch_assoc($res)) {
        echo '<option value="' . htmlspecialchars($w['website']) . '">' . htmlspecialchars($w['website']) . '</option>';
    }
} elseif ($action == 'summary') {
    $overall = mysqli_fetch_assoc(mysqli_query($con, "
        SELECT 
            COUNT(*) as total,
            SUM(status='pending') as pending,
            SUM(status='completed') as completed
        FROM tasks
    "));

    $res = mysqli_query($con, "
        SELECT 
            website,
            COUNT(*) as total,
            SUM(status='pending') as pending,
            SUM(status='completed') as completed
        FROM tasks
        GROUP BY website
        ORDER BY website
    ");

    echo '<div class="row text-center mb-4">';
    echo '<div class="col-md-4"><div class="card shadow-sm border-primary">
            <div class="card-body">
                <h6 class="text-muted">Pending</h6>
                <h5 class="text-primary">' . $overall['pending'] . '</h5>
            </div></div></div>';
    echo '<div class="col-md-4"><div class="card shadow-sm border-success">
            <div class="card-body">
                <h6 class="text-muted">Done</h6>
                <h5 class="text-success">' . $overall['completed'] . '</h5>
            </div></div></div>';
    echo '<div class="col-md-4"><div class="card shadow-sm border-dark">
            <div class="card-body">
                <h6 class="text-muted">Total</h6>
                <h5 class="text-dark">' . $overall['total'] . '</h5>
            </div></div></div>';
    echo '</div>';

    echo '<table class="table table-bordered table-sm align-middle text-center">
            <thead class="table-transparent">
                <tr><th>Website</th><th>Pending</th><th>Completed</th><th>Total</th></tr>
            </thead><tbody>';
    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>
                <td>' . htmlspecialchars($row['website']) . '</td>
                <td class="text-primary">' . $row['pending'] . '</td>
                <td class="text-success">' . $row['completed'] . '</td>
                <td class="text-dark fw-bold">' . $row['total'] . '</td>
              </tr>';
    }
    echo '</tbody></table>';
} elseif ($action == 'markcomplete') {
    $id = intval($_POST['id']);
    $status = $_POST['status'] === 'completed' ? 'completed' : 'pending';
    $completedAt = ($status === 'completed') ? "NOW()" : "NULL";
    $query = "UPDATE tasks SET status = '$status', completed_at = $completedAt WHERE id = $id";
    if (mysqli_query($con, $query)) echo "success";
    else echo "error: " . mysqli_error($con);
}
