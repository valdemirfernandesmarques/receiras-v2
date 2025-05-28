<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "receitas_retro";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>