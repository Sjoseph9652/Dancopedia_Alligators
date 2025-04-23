<?php
require 'db_configuration.php';

if ($db->connect_errno) {
    echo "Connection failed: " . $db->connect_error;
} else {
    echo "Connected to Railway DB!";
}
?>
