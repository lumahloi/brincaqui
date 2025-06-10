<?php
session_start();

function check_permission($expected_types, $cookie)
{
    if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], (array) $expected_types)) {
        echo $_SESSION['user_type'];
        response_format(403, "Acesso negado.");
    }
    if (!$cookie) {
        response_format(400, "Cookie não encontrado.");

    }
}
