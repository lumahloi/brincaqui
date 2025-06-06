<?php
session_start();

function check_permission($expected_types)
{
    if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], (array)$expected_types)) {
        response_format(403, "Acesso negado.");
        exit;
    }
}
