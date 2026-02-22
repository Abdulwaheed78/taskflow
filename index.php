<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CareComp Tasks</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- ckeditor for title creation -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <style>
        body {
            background: #b7f8ce;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-fluid {
            max-width: 1300px;
        }

        h2 {
            color: #0d6efd;
            font-weight: 600;
        }

        /* Table */
        .table thead {
            background: linear-gradient(90deg, #0d6efd, #007bff);
            color: #fff;
        }

        tr:hover {
            background: #f1f5ff !important;
            transition: 0.2s ease;
        }

        /* Priority colors */
        .priority-High {
            background: #ffe5e5 !important;
            border-left: 5px solid #dc3545 !important;
        }

        .priority-Medium {
            background: #fff6e5 !important;
            border-left: 5px solid #ffc107 !important;
        }

        .priority-Low {
            background: #e8f8e8 !important;
            border-left: 5px solid #28a745 !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #ced4da;
        }

        .icon-btn {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }

        .icon-btn:hover i {
            color: #dc3545;
            transform: scale(1.1);
            transition: 0.2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: inherit !important;
        }

        .task-detail-card {
            position: absolute;
            z-index: 1000;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: none;
            width: 250px;
            font-size: 13px;
        }

        .task-detail-card b {
            color: #0d6efd;
        }
    </style>

    <style>
        /* Table transparent */
        #tasks_table table,
        #tasks_table table thead,
        #tasks_table table tbody,
        #tasks_table table tr,
        #tasks_table table td,
        #tasks_table table th {
            background: transparent !important;
            border: none !important;
            color: #000;
            /* keep text readable */
        }

        /* Table header semi-transparent */
        #tasks_table table thead tr {
            background: rgba(13, 110, 253, 0.2) !important;
            /* light transparent blue */
            color: #000;
        }

        /* Table rows semi-transparent */
        #tasks_table table tbody tr {
            background: rgba(255, 255, 255, 0.2) !important;
            /* light transparent white */
            transition: background 0.2s ease;
            border-radius: 0;
        }

        /* Hover effect on rows */
        #tasks_table table tbody tr:hover {
            background: rgba(241, 245, 255, 0.3) !important;
        }

        /* Inputs and selects inside table transparent */
        #tasks_table input.form-control,
        #tasks_table select.form-select {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #000;
        }

        /* Summary cards transparent */
        #summary_section>div {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 10px 14px;
        }

        /* Task detail hover card */
        .task-detail-card {
            background: black !important;
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: white;
        }

        /* Optional: make table text bold/stand out on transparent */
        #tasks_table table td,
        #tasks_table table th {
            font-weight: 500;
        }

        /* Website/Summary Table Transparent */
        #summary_section table,
        #summary_section table thead,
        #summary_section table tbody,
        #summary_section table tr,
        #summary_section table td,
        #summary_section table th {
            background: transparent !important;
            border: none !important;
            color: #000;
            font-weight: 500;
        }

        /* Summary table header semi-transparent */
        #summary_section table thead tr {
            background: rgba(13, 110, 253, 0.2) !important;
            /* light transparent blue */
            color: #000;
        }

        /* Summary table rows semi-transparent */
        #summary_section table tbody tr {
            background: rgba(255, 255, 255, 0.2) !important;
            /* light transparent white */
            transition: background 0.2s ease;
        }

        /* Hover effect on summary table rows */
        #summary_section table tbody tr:hover {
            background: rgba(241, 245, 255, 0.3) !important;
        }

        /* Optional: inputs/selects inside summary table if any */
        #summary_section input.form-control,
        #summary_section select.form-select {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #000;
        }

        #sliderTitle table {
            width: 100%;
            border-collapse: collapse;
        }

        #sliderTitle table td,
        #sliderTitle table th {
            border: 1px solid #dee2e6;
            padding: 6px 8px;
        }

        #sliderTitle img {
            max-width: 100%;
            border-radius: 6px;
        }

        .task-detail-card {
            width: 380px;
            max-width: 420px;
        }

        /* Priority badge colors stay JS-driven */
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="v1/">
                <i class="bi bi-check2-square me-2"></i>CareComp Tasks
            </a>
            <div class="d-flex gap-2">
                <a href="index.php" class="btn btn-outline-secondary btn-sm">Taskflow</a>
                <a href="v1/" class="btn btn-outline-primary btn-sm">Go to v1</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row g-3">

            <!-- Left: Create & Table -->
            <div class="col-lg-8">
                <div class=" shadow-sm p-4 mb-4">
                    <h2 class="mb-4 text-center"><i class="bi bi-check2-square me-2"></i> Manage Tasks</h2>

                    <div class="d-flex justify-content-end mb-2 gap-3">
                        <a href="#" id="export_stats" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-text me-1"></i> Export Status
                        </a>
                        <button class="btn btn-sm btn-outline-success" id="openTaskSlider">
                            View In Slide
                        </button>
                        <button class="btn btn-sm btn-success" id="openCreateTask">
                            <i class="bi bi-plus-lg me-1"></i> Create Task
                        </button>

                    </div>


                    <!-- Tasks Table -->
                    <div id="tasks_table"></div>

                </div>
            </div>

            <!-- Right: Filters + Summary -->
            <div class="col-lg-4">
                <div class="rounded shadow-sm p-4">
                    <h5 class="text-primary mb-3"><i class="bi bi-funnel me-2"></i>Filters</h5>

                    <!-- Search Filter -->
                    <div class="justify-content-end mb-3">
                        <div class="input-group w-auto">
                            <span class="input-group-text"><i class="bi bi-search text-secondary"></i></span>
                            <input type="text" id="filter_search" class="form-control" placeholder="Search by title...">
                        </div>
                    </div>


                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="bi bi-filter-circle text-primary"></i></span>
                        <select id="filter_status" class="form-select">
                            <option value="all">All Status</option>
                            <option value="pending" selected>Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <div class="input-group mb-2">
                        <span class="input-group-text"><i class="bi bi-flag text-warning"></i></span>
                        <select id="filter_priority" class="form-select">
                            <option value="all" selected>All Priority</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>

                    <div class="input-group mb-4">
                        <span class="input-group-text"><i class="bi bi-globe text-success"></i></span>
                        <select id="filter_website" class="form-select">
                            <option value="all" selected>All Websites</option>
                        </select>
                    </div>

                    <h5 class="text-success mb-3"><i class="bi bi-graph-up-arrow me-2"></i>Summary</h5>
                    <div id="summary_section"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow">

                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-plus-circle me-2"></i>Create New Task
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Task Title</label>
                        <textarea id="create_title" class="form-control"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="text" id="create_website" class="form-control" value="General">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priority</label>
                            <select id="create_priority" class="form-select">
                                <option value="Low" selected>Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-primary rounded-pill" id="saveNewTask">
                        Create Task
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>Edit Task
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <textarea id="edit_title" class="form-control"></textarea>
                        <!-- <input type="text" id="edit_title" class="form-control"> -->
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" id="edit_website" class="form-control">
                    </div>
                    <div class="row">
                        <div class=" col-6 mb-3">
                            <label class="form-label">Priority</label>
                            <select id="edit_priority" class="form-select">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>

                        <div class="col-6 mb-3">
                            <label class="form-label">Status</label>
                            <select id="edit_status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-primary rounded-pill" id="save_task_changes">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Slider Modal -->
    <div class="modal fade" id="taskSliderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow">

                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Task Viewer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Top Meta -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span id="sliderCounter" class="text-muted small"></span>
                        <span id="sliderPriority" class="badge rounded-pill px-3"></span>
                    </div>

                    <!-- Title Preview -->
                    <div class="border rounded-3 p-3 mb-4 bg-light" style="min-height:140px;">
                        <div id="sliderTitle" class="task-title"></div>
                    </div>

                    <!-- Meta Badges -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-secondary">
                            🌐 <span id="sliderWebsite"></span>
                        </span>

                        <span id="sliderStatus" class="badge rounded-pill px-3">
                            📌 <span id="sliderStatus"></span>
                        </span>

                    </div>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-center gap-3 flex-wrap">

                        <button class="btn btn-outline-secondary px-4" id="sliderPrev">
                            ← Previous
                        </button>

                        <button class="btn btn-outline-success px-4" id="sliderMarkDone">
                            ✓ Mark as Done
                        </button>

                        <button class="btn btn-outline-primary px-4" id="sliderNext">
                            Next →
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            //slider initialization to open only one taskSliderModal
            let sliderAutoClosed = sessionStorage.getItem('taskSliderClosed') === '1';
            setTimeout(function () {
                if (!sliderAutoClosed) {
                    $('#openTaskSlider').trigger('click');
                }
            }, 600);


            //initialize the editor for create task 
            let createModal = new bootstrap.Modal(
                document.getElementById('createTaskModal')
            );

            let createEditor = null;
            ClassicEditor
                .create(document.querySelector('#create_title'))
                .then(editor => {
                    createEditor = editor;
                })
                .catch(error => {
                    console.error('Create CKEditor init failed:', error);
                });
            //open modal
            $('#openCreateTask').on('click', function () {
                if (!createEditor) {
                    alert('Editor is loading, please wait');
                    return;
                }
                createEditor.setData('');
                $('#create_website').val('General');
                $('#create_priority').val('Low');
                createModal.show();
            });


            //onsave click save task
            $('#saveNewTask').on('click', function () {

                if (!createEditor) return;

                const title = createEditor.getData().trim();
                const website = $('#create_website').val().trim() || 'General';
                const priority = $('#create_priority').val();

                if (!title) {
                    alert('Task title is required');
                    return;
                }

                $.post('tasks_ajax.php', {
                    action: 'create',
                    title,
                    website,
                    priority
                }, function () {
                    createModal.hide();
                    fetchTasks(1);
                    fetchSummary();
                });
            });


            /* =============================
               GLOBAL EDIT REFERENCES
            ============================= */
            let editModal;
            let titleEditor = null;

            /* =============================
               INIT BOOTSTRAP MODAL
            ============================= */
            editModal = new bootstrap.Modal(
                document.getElementById('editTaskModal')
            );

            /* =============================
               INIT CKEDITOR (ONCE)
            ============================= */
            ClassicEditor
                .create(document.querySelector('#edit_title'))
                .then(editor => {
                    titleEditor = editor;
                })
                .catch(error => {
                    console.error('CKEditor init failed:', error);
                });

            /* =============================
               HOVER DETAIL CARD
            ============================= */
            const detailCard = $('<div class="task-detail-card"></div>').appendTo('body');

            $(document)
                .on('mouseenter', '.edit_title', function () {
                    detailCard.html($(this).data('details')).fadeIn(150);
                })
                .on('mousemove', '.edit_title', function (e) {
                    detailCard.css({
                        top: e.pageY + 15,
                        left: e.pageX + 15
                    });
                })
                .on('mouseleave', '.edit_title', function () {
                    detailCard.hide();
                });

            /* =============================
               LOAD FILTER WEBSITES
            ============================= */
            $.get('tasks_ajax.php', {
                action: 'websites'
            }, function (data) {
                $('#filter_website').append(data);
            });

            /* =============================
               INITIAL LOAD
            ============================= */
            fetchTasks();
            fetchSummary();

            /* =============================
               FILTERS
            ============================= */
            $('#filter_status, #filter_priority, #filter_website').change(function () {
                fetchTasks(1);
                fetchSummary();
            });

            $('#filter_search').on('keyup', function () {
                fetchTasks(1);
            });

            /* =============================
               PAGINATION
            ============================= */
            $(document).on('click', '#tasks_table .page-link', function (e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) fetchTasks(page);
            });

            $(document).on('click', '#goto_page_btn', function () {
                const page = Math.max(1, parseInt($('#goto_page_input').val()) || 1);
                fetchTasks(page);
            });

            $(document).on('keypress', '#goto_page_input', function (e) {
                if (e.which === 13) $('#goto_page_btn').click();
            });

            /* =============================
               EDIT TASK (MODAL)
            ============================= */
            $(document).on('click', '.edit_task', function () {

                if (!titleEditor) {
                    alert('Editor is still loading. Please wait.');
                    return;
                }

                $('#edit_id').val($(this).data('id'));
                $('#edit_website').val($(this).data('website'));
                $('#edit_priority').val($(this).data('priority'));
                $('#edit_status').val($(this).data('status'));

                titleEditor.setData($(this).data('title'));

                editModal.show();
            });

            /* =============================
               SAVE EDIT
            ============================= */
            $('#save_task_changes').on('click', function () {

                if (!titleEditor) return;

                const id = $('#edit_id').val();
                const title = titleEditor.getData().trim();
                const website = $('#edit_website').val().trim();
                const priority = $('#edit_priority').val();
                const status = $('#edit_status').val();

                if (!title) {
                    alert('Title is required');
                    return;
                }

                $.post('tasks_ajax.php', {
                    action: 'edit',
                    id,
                    title,
                    website,
                    priority,
                    status
                }, function (res) {
                    if (res.trim() === 'success') {
                        editModal.hide();
                        fetchTasks();
                        fetchSummary();
                    } else {
                        alert('Failed to update task');
                    }
                });
            });

            /* =============================
               DELETE TASK
            ============================= */
            $('#tasks_table').on('click', '.delete_task', function () {
                if (!confirm('Delete task?')) return;
                const id = $(this).data('id');

                $.get('tasks_ajax.php', {
                    action: 'delete',
                    id
                }, function () {
                    fetchTasks();
                    fetchSummary();
                });
            });

            /* =============================
               STATUS TOGGLE
            ============================= */
            $(document).on('change', '.toggle-status', function () {
                const checkbox = $(this);
                const id = checkbox.data('id');
                const status = checkbox.is(':checked') ? 'completed' : 'pending';

                $.post('tasks_ajax.php', {
                    action: 'markcomplete',
                    id,
                    status
                }, function (res) {
                    if (res.trim() === 'success') {
                        fetchTasks();
                        fetchSummary();
                    } else {
                        checkbox.prop('checked', !checkbox.is(':checked'));
                        alert('Failed to update status');
                    }
                });
            });

            $('#sliderMarkDone').on('click', function () {

                if (!sliderTasks.length) return;

                // ✅ ALWAYS get task here
                const task = sliderTasks[sliderIndex];

                if (!task || task.status === 'completed') {
                    alert('Task already completed');
                    return;
                }

                $.post('tasks_ajax.php', {
                    action: 'markcomplete',
                    id: task.id,
                    status: 'completed'
                }, function (res) {

                    if (res.trim() !== 'success') {
                        alert('Failed to update task');
                        return;
                    }

                    // Update local status
                    task.status = 'completed';

                    // Remove completed task from slider
                    sliderTasks.splice(sliderIndex, 1);

                    // Fix index
                    if (sliderIndex >= sliderTasks.length) {
                        sliderIndex = sliderTasks.length - 1;
                    }

                    // Update UI
                    if (sliderTasks.length === 0) {
                        sliderModal.hide();
                    } else {
                        renderSliderTask();
                    }

                    fetchTasks();
                    fetchSummary();
                });
            });

            /* =============================
               EXPORT
            ============================= */
            $('#export_stats').click(function (e) {
                e.preventDefault();
                window.location.href = 'task_export.php?type=stats';
            });

            /* =============================
               HELPERS
            ============================= */
            function fetchTasks(page = 1) {
                $.get('tasks_ajax.php', {
                    action: 'fetch',
                    status: $('#filter_status').val(),
                    priority: $('#filter_priority').val(),
                    website: $('#filter_website').val(),
                    search: $('#filter_search').val().trim(),
                    page
                }, function (data) {
                    $('#tasks_table').html(data);
                });
            }

            function fetchSummary() {
                $.get('tasks_ajax.php', {
                    action: 'summary'
                }, function (data) {
                    $('#summary_section').html(data);
                });
            }

            // slider related code 
            let sliderTasks = [];
            let sliderIndex = 0;
            let sliderModal = new bootstrap.Modal(
                document.getElementById('taskSliderModal')
            );

            $('#openTaskSlider').on('click', function () {

                // manual open should ignore auto-close rule
                sliderAutoClosed = true;

                $.getJSON('tasks_ajax.php', { action: 'slider_tasks' }, function (data) {

                    if (!data.length) {
                        alert('No tasks found');
                        return;
                    }

                    sliderTasks = data;
                    sliderIndex = 0;
                    renderSliderTask();
                    sliderModal.show();
                });
            });

            $('#sliderNext').on('click', function () {
                if (sliderIndex < sliderTasks.length - 1) {
                    sliderIndex++;
                    renderSliderTask();
                }
            });

            $('#sliderPrev').on('click', function () {
                if (sliderIndex > 0) {
                    sliderIndex--;
                    renderSliderTask();
                }
            });

            $('#taskSliderModal').on('hidden.bs.modal', function () {

                // 🔒 remember user choice for this session
                sessionStorage.setItem('taskSliderClosed', '1');
                sliderAutoClosed = true;

                $('#sliderTitle').empty();
                $('#sliderWebsite').text('');
                $('#sliderStatus').text('');
                $('#sliderCounter').text('');
                $('#sliderPriority').text('');
            });

            function renderSliderTask() {

                if (!sliderTasks.length) return;

                const task = sliderTasks[sliderIndex]; // ✅ required

                $('#sliderTitle').html(task.title || '<i class="text-muted">No description</i>');
                $('#sliderWebsite').text(task.website || '—');

                $('#sliderStatus')
                    .text(task.status)
                    .removeClass('bg-success bg-warning bg-secondary')
                    .addClass(
                        task.status === 'completed'
                            ? 'bg-success'
                            : 'bg-warning text-dark'
                    );

                $('#sliderCounter').text(
                    `Task ${sliderIndex + 1} of ${sliderTasks.length}`
                );

                $('#sliderPriority')
                    .text(task.priority)
                    .removeClass('bg-danger bg-warning bg-success text-dark')
                    .addClass(
                        task.priority === 'High'
                            ? 'bg-danger'
                            : task.priority === 'Medium'
                                ? 'bg-warning text-dark'
                                : 'bg-success'
                    );

                $('#sliderPrev').prop('disabled', sliderIndex === 0);
                $('#sliderNext').prop('disabled', sliderIndex === sliderTasks.length - 1);

                // ✅ Disable mark-done button if already completed
                $('#sliderMarkDone').prop('disabled', task.status === 'completed');
            }

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>