<?php

function check_permission($expected_types)
{
    if (!isset($_SESSION['user_type']) || !in_array($_SESSION['user_type'], (array)$expected_types)) {
        response_format(403, "Acesso negado.");
        echo $_SESSION['user_type'];
        exit;
    }
}
