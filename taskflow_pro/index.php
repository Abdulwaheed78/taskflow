<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow | Modern Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-layer-group me-2"></i>TaskFlow</a>
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light btn-sm me-3" id="darkModeToggle">
                    <i class="fas fa-moon"></i>
                </button>
                <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-folder-plus me-1"></i> New Category <kbd class="ms-1 bg-dark text-light" style="font-size: 0.7rem">C</kbd>
                </button>
                <button class="btn btn-primary btn-sm" id="btnAddTask" data-bs-toggle="modal" data-bs-target="#taskModal">
                    <i class="fas fa-plus me-1"></i> New Task <kbd class="ms-1 bg-dark text-light" style="font-size: 0.7rem">T</kbd>
                </button>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-5 mt-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3">
                    <h6 class="text-muted">Total Tasks</h6>
                    <h2 class="counter" id="stat-total">0</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3">
                    <h6 class="text-muted">Pending</h6>
                    <h2 class="counter text-warning" id="stat-pending">0</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-3">
                    <h6 class="text-muted">Completed</h6>
                    <h2 class="counter text-success" id="stat-completed">0</h2>
                </div>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <ul class="nav nav-pills" id="categoryTabs">
                </ul>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 shadow-sm"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-0 shadow-sm" placeholder="Search tasks... (Press 'S')">
                </div>
            </div>
        </div>

        <div id="taskList" class="row g-3"></div>

        <nav class="mt-4">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>

    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="taskForm" class="modal-content">
                <input type="hidden" name="id" id="taskId">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="taskTitle" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="taskCategory" class="form-select" required></select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" id="taskPriority" class="form-select">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Save Task</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <form id="categoryForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Website" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" class="form-control form-control-color w-100" value="#0d6efd">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Create</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>