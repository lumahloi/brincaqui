<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_permission($expected_types, $cookie)
{
    if (!$cookie) {
        response_format(404, "Cookie não encontrado.");
    }

    if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], (array) $expected_types)) {
        response_format(403, "Acesso negado.");
    }
}
