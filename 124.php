<?php
$host = 'localhost';
$username = 'username_database';
$password = 'password_database';
$database = 'crud_api';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
