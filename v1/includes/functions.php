<?php
/**
 * XSS Protection: Escapes output for HTML
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Format timestamps for the UI
 */
function formatDate($date) {
    if (!$date) return '';
    return date('M d, Y', strtotime($date));
}

/**
 * Get Priority CSS Class
 */
function getPriorityClass($priority) {
    return match($priority) {
        'High'   => 'priority-High',
        'Medium' => 'priority-Medium',
        'Low'    => 'priority-Low',
        default  => ''
    };
}

/**
 * Check if task is overdue (if we had due dates)
 */
function isOverdue($date) {
    return strtotime($date) < time();
}