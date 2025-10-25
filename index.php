<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CareComp Tasks</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <div class="row g-3">

            <!-- Left: Create & Table -->
            <div class="col-lg-8">
                <div class=" shadow-sm p-4 mb-4">
                    <h2 class="mb-4 text-center"><i class="bi bi-check2-square me-2"></i> Todo</h2>

                    <!-- Create Task -->
                    <div class="row g-2 mb-3 align-items-center">
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-pencil-square text-primary"></i></span>
                                <input type="text" id="new_title" class="form-control" placeholder="Task & press Enter" autofocus>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-globe2 text-success"></i></span>
                                <input type="text" id="new_website" class="form-control" placeholder="Website" value="General">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-flag text-warning"></i></span>
                                <select id="new_priority" class="form-select">
                                    <option value="Low" selected>Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mb-2">
                        <a href="#" id="export_stats" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-text me-1"></i> Export Status
                        </a>
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

    <script>
        $(document).ready(function() {
            // Create hover detail card element once
            const detailCard = $('<div class="task-detail-card"></div>').appendTo('body');

            // Handle hover on title input
            $(document).on('mouseenter', '.edit_title', function(e) {
                const details = $(this).data('details');
                detailCard.html(details).fadeIn(150);
            }).on('mousemove', '.edit_title', function(e) {
                detailCard.css({
                    top: e.pageY + 15,
                    left: e.pageX + 15
                });
            }).on('mouseleave', '.edit_title', function() {
                detailCard.hide();
            });

            // Load websites list for filters
            $.get('tasks_ajax.php', {
                action: 'websites'
            }, function(data) {
                $('#filter_website').append(data);
            });

            // Fetch tasks and summary initially
            fetchTasks();
            fetchSummary();

            // ============================
            // Create new task (Enter key)
            // ============================
            $('#new_title').keypress(function(e) {
                if (e.which == 13) {
                    const title = $('#new_title').val().trim();
                    const website = $('#new_website').val().trim() || 'General';
                    const priority = $('#new_priority').val();
                    if (title != '') {
                        $.post('tasks_ajax.php', {
                            action: 'create',
                            title,
                            website,
                            priority
                        }, function() {
                            $('#new_title').val('');
                            fetchTasks(1);
                            fetchSummary();
                        });
                    }
                    e.preventDefault();
                }
            });

            // ============================
            // Filters auto-refresh
            // ============================
            $('#filter_status, #filter_priority, #filter_website').change(function() {
                fetchTasks(1);
                fetchSummary();
            });

            // ============================
            // Search input filter
            // ============================
            $('#filter_search').on('keyup', function() {
                fetchTasks(1); // always start from page 1 when searching
            });

            // ============================
            // Pagination buttons
            // ============================
            $(document).on('click', '#tasks_table .page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (!page) return; // skip disabled
                fetchTasks(page);
            });

            // ============================
            // Go-to-page input
            // ============================
            $(document).on('click', '#goto_page_btn', function() {
                let page = parseInt($('#goto_page_input').val());
                if (!page || page < 1) page = 1;
                fetchTasks(page);
            });

            $(document).on('keypress', '#goto_page_input', function(e) {
                if (e.which == 13) $('#goto_page_btn').click();
            });

            // ============================
            // Edit task inline
            // ============================
            // Inline edit task
            $('#tasks_table').on('keypress', '.edit_title, .edit_website, .edit_priority', function(e) {
                if (e.which !== 13) return; // Only Enter key triggers

                const row = $(this).closest('tr');
                const id = row.data('id');
                const title = row.find('.edit_title').val().trim();
                const priority = row.find('.edit_priority').val();
                const website = row.find('.edit_website').val().trim();
                const status = row.find('.toggle-status').is(':checked') ? 'completed' : 'pending';

                $.post('tasks_ajax.php', {
                    action: 'edit',
                    id,
                    title,
                    priority,
                    website,
                    status
                }, function(res) {
                    if (res.trim() === 'success') {
                        // Update status text and details without full reload
                        row.find('.status-text').text(status.charAt(0).toUpperCase() + status.slice(1));
                        row.removeClass('priority-High priority-Medium priority-Low')
                            .addClass('priority-' + priority);
                    } else {
                        alert('Failed to update task');
                    }
                });
            });


            // ============================
            // Delete task
            // ============================
            $('#tasks_table').on('click', '.delete_task', function() {
                if (!confirm('Delete task?')) return;
                const id = $(this).data('id');
                $.get('tasks_ajax.php', {
                    action: 'delete',
                    id
                }, function() {
                    fetchTasks();
                    fetchSummary();
                });
            });

            // ============================
            // Functions
            // ============================
            function fetchTasks(page = 1) {
                const status = $('#filter_status').val();
                const priority = $('#filter_priority').val();
                const website = $('#filter_website').val();
                const search = $('#filter_search').val().trim();

                $.get('tasks_ajax.php', {
                    action: 'fetch',
                    status,
                    priority,
                    website,
                    search,
                    page
                }, function(data) {
                    $('#tasks_table').html(data);
                });
            }

            function fetchSummary() {
                $.get('tasks_ajax.php', {
                    action: 'summary'
                }, function(data) {
                    $('#summary_section').html(data);
                });
            }

            $(document).ready(function() {
                $('#export_stats').click(function(e) {
                    e.preventDefault();
                    window.location.href = 'task_export.php?type=stats';
                });
            });

            // Toggle task status
            $(document).on('change', '.toggle-status', function() {
                const checkbox = $(this);
                const id = checkbox.data('id');
                const newStatus = checkbox.is(':checked') ? 'completed' : 'pending';

                $.ajax({
                    url: 'tasks_ajax.php',
                    type: 'POST',
                    data: {
                        action: 'markcomplete',
                        id: id,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.trim() === 'success') {
                            // Refresh the table after status update
                            fetchTasks(); // Your existing function to reload tasks
                            fetchSummary(); // Update summary counts
                        } else {
                            alert('Failed to update task status.');
                            checkbox.prop('checked', !checkbox.is(':checked'));
                        }
                    },
                    error: function() {
                        alert('Failed to update task status.');
                        checkbox.prop('checked', !checkbox.is(':checked'));
                    }
                });
            });

        });
    </script>


</body>

</html>