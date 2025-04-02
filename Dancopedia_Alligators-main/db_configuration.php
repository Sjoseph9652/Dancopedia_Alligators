<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('run_sql')) {

    // Database configuration for Dancopedia AI on localhost
    DEFINE('DATABASE_HOST', 'localhost');
    DEFINE('DATABASE_DATABASE', 'gatorz_db');
    DEFINE('DATABASE_USER', 'root');
    DEFINE('DATABASE_PASSWORD', '');

    // Create database connection ***CHANGE PORT BACK 3306*** 
    $db = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
    $db->set_charset("utf8");

    // Function to execute SQL queries
    function run_sql($sql_script) {
        global $db;

        // Check connection
        if ($db->connect_error) {
            trigger_error(
                'Database connection failed: ' . $db->connect_error, 
                E_USER_ERROR
            );
        } else {
            $result = $db->query($sql_script);

            if ($result === false) {
                trigger_error(
                    'Invalid SQL: ' . $sql_script . '; Error: ' . $db->error, 
                    E_USER_ERROR
                );
            } elseif (strpos($sql_script, "INSERT") !== false) {
                return $db->insert_id; // Return last inserted ID
            } else {
                return $result; // Return query result
            }
        }
    }
}
?>
