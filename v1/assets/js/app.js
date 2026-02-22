$(document).ready(function () {
    let currentCategoryId = null;

    loadCategories(true);

    // Dark Mode Toggle
    $('#darkModeToggle').click(function () {
        const theme = $('html').attr('data-bs-theme') === 'dark' ? 'light' : 'dark';
        $('html').attr('data-bs-theme', theme);
        $(this).find('i').toggleClass('fa-moon fa-sun');
    });

    // Load Categories & Build Tabs
    function loadCategories(isFirstLoad = false) {
        $.get('api/categories.php?action=list', function (data) {
            let tabs = '';
            let options = '';
            let firstCategory = null;

            data.forEach(c => {
                if (c.pending_count > 0) {
                    if (!firstCategory) firstCategory = c.id;
                    tabs += `<li class="nav-item"><button class="nav-link ${currentCategoryId == c.id ? 'active' : ''}" data-id="${c.id}">${c.name} <span class="badge bg-secondary ms-1" style="font-size:0.7em">${c.pending_count}</span></button></li>`;
                }
                options += `<option value="${c.id}">${c.name}</option>`;
            });

            // Add Completed Tab
            tabs += `<li class="nav-item"><button class="nav-link ${currentCategoryId === 'completed' ? 'active' : ''}" data-id="completed">Completed</button></li>`;

            $('#categoryTabs').html(tabs);
            $('#taskCategory').html(options);

            // Handle Tab Selection Logic (Auto-switch if current tab is empty/invalid)
            if (isFirstLoad || (!data.find(c => c.id == currentCategoryId && c.pending_count > 0) && currentCategoryId !== 'completed')) {
                currentCategoryId = firstCategory || 'completed';
                $(`#categoryTabs .nav-link[data-id="${currentCategoryId}"]`).addClass('active');
            }
            
            loadTasks();
            loadStats();
        });
    }

    // Handle Tab Clicking
    $(document).on('click', '#categoryTabs .nav-link', function () {
        $('#categoryTabs .nav-link').removeClass('active');
        $(this).addClass('active');
        currentCategoryId = $(this).data('id');
        loadTasks();
    });

    // Reset Modal for "New Task"
    $('#btnAddTask').click(function () {
        $('#taskForm')[0].reset();
        $('#taskId').val('');
        $('#taskModalLabel').text('New Task');
    });

    // Edit Task - Correct Logic
    $(document).on('click', '.edit-task', function () {
        const task = $(this).data('task'); // Note: Ensure HTML escaping in loadTasks

        $('#taskId').val(task.id);
        $('#taskTitle').val(task.title);
        $('#taskCategory').val(task.category_id);
        $('#taskPriority').val(task.priority);

        $('#taskModalLabel').text('Edit Task');
        $('#taskModal').modal('show');
    });

    // Save Task (Add or Update)
    $('#taskForm').submit(function (e) {
        e.preventDefault();
        $.post('api/tasks.php?action=save', $(this).serialize(), function () {
            $('#taskModal').modal('hide');
            loadCategories();
            Swal.fire('Success!', 'Task has been updated.', 'success');
        });
    });

    // Save New Category
    $('#categoryForm').submit(function (e) {
        e.preventDefault();
        $.post('api/categories.php?action=add', $(this).serialize(), function () {
            $('#categoryModal').modal('hide');
            $('#categoryForm')[0].reset();
            loadCategories();
            Swal.fire('Success!', 'New category created.', 'success');
        });
    });

    // Search input
    $('#searchInput').on('keyup', loadTasks);

    function loadTasks() {
        const filters = {
            search: $('#searchInput').val(),
            category: currentCategoryId === 'completed' ? '' : currentCategoryId,
            status: currentCategoryId === 'completed' ? 'Completed' : 'Pending'
        };

        $.get('api/tasks.php?action=list', filters, function (tasks) {
            let html = '';

            if (tasks.length === 0) {
                html = '<div class="text-center p-5 w-100"><i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i><p>No tasks found in this section.</p></div>';
            }

            tasks.forEach(task => {
                // Critical: Stringify and escape the task object for the data attribute
                const taskAttr = JSON.stringify(task).replace(/'/g, "&apos;");

                html += `
                <div class="col-12" data-id="${task.id}">
                    <div class="card task-card shadow-sm mb-2 priority-${task.priority} ${task.status.toLowerCase()}">
                        <div class="card-body d-flex align-items-center justify-content-between py-2">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" class="form-check-input me-3 toggle-status" 
                                    ${task.status === 'Completed' ? 'checked' : ''} data-id="${task.id}">
                                <div>
                                    <h6 class="mb-0 ${task.status === 'Completed' ? 'text-decoration-line-through text-muted' : ''}">${task.title}</h6>
                                    <small class="badge rounded-pill" style="background-color: ${task.color} !important">
                                        ${task.category_name}
                                    </small>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-light border edit-task" data-task='${taskAttr}'><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger delete-task" data-id="${task.id}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            $('#taskList').html(html);
        });
    }

    function loadStats() {
        $.get('api/tasks.php?action=stats', function (stats) {
            animateStats(stats);
        });
    }

    // Toggle Status
    $(document).on('change', '.toggle-status', function () {
        const id = $(this).data('id');
        $.post('api/tasks.php?action=toggle', { id }, () => loadCategories());
    });

    // Delete Task
    $(document).on('click', '.delete-task', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Delete this task?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('api/tasks.php?action=delete', { id }, () => loadCategories());
            }
        });
    });

    function animateStats(stats) {
        $('#stat-total').text(stats.total);
        $('#stat-pending').text(stats.pending);
        $('#stat-completed').text(stats.completed);
    }

    // Initialize Sortable
    new Sortable(document.getElementById('taskList'), {
        animation: 150
    });

    // --- Keyboard Shortcuts ---
    $(document).on('keydown', function (e) {
        // Ignore shortcuts if the user is currently typing in an input or textarea
        if ($(e.target).is('input, textarea, select')) {
            // Exception: Allow 'Escape' to blur the input
            if (e.key === 'Escape') {
                $(e.target).blur();
            }
            return;
        }

        switch (e.key.toLowerCase()) {
            case 't':
                // [T] - Open New Task Modal
                e.preventDefault();
                $('#btnAddTask').click();
                break;

            case 'c':
                // [C] - Open New Category Modal
                e.preventDefault();
                $('[data-bs-target="#categoryModal"]').click();
                break;

            case 's':
                // [S] - Focus Search Bar
                e.preventDefault();
                $('#searchInput').focus();
                break;

            case 'escape':
                // [Esc] - Close any open modals
                $('.modal').modal('hide');
                break;
        }
    });
});