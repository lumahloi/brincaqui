<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/validate_infos.php";

if (isset($data['description'])) {
    $input_description = filter_var($data['description'], FILTER_SANITIZE_STRING);
    valid_description($input_description);
}

if (isset($data['name'])) {
    $input_name = filter_var($data['name'], FILTER_SANITIZE_STRING);
    valid_play_name($input_name);
}

if (isset($data['cnpj'])) {
    $input_cnpj = filter_var($data['cnpj'], FILTER_SANITIZE_STRING);
    valid_cnpj($input_cnpj);
}

if (isset($data['telephone'])) {
    $input_telephone = filter_var($data['telephone'], FILTER_SANITIZE_STRING);
    valid_telephone_from_play($input_telephone);
}

if (isset($data['email'])) {
    $input_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    valid_email_from_play($input_email);
}

if (isset($data['pictures'])) {
    $input_pictures = $data['pictures'];
    valid_array($input_pictures, 'pictures');
    valid_json_data($input_pictures, ['picture_name']);
    json_field_non_empty($input_pictures, 'picture_name');
    $input_pictures = json_encode($input_pictures);
}

if (isset($data['socials'])) {
    $input_socials = $data['socials'];
    valid_array($input_socials, 'socials');
    valid_json_data($input_socials, ['socials_name', 'socials_url']);
    json_field_non_empty($input_socials, 'socials_name');
    json_field_non_empty($input_socials, 'socials_url');
    $input_socials = json_encode($input_socials);
}

if (isset($data['prices'])) {
    $input_prices = $data['prices'];
    valid_array($input_prices, 'prices');
    valid_json_data($input_prices, ['prices_title', 'prices_price']);
    json_field_non_empty($input_prices, 'prices_title');
    json_field_non_empty($input_prices, 'prices_price');
    foreach ($input_prices as $price_item) {
        valid_number($price_item['prices_price']);
    }
    $input_prices = json_encode($input_prices);
}

if (isset($data['times'])) {
    $input_times = $data['times'];
    valid_array($input_times, 'times');
    valid_times($input_times);
    $input_times = json_encode($input_times);
}

if (isset($data['commodities'])) {
    $input_commodities = $data['commodities'];
    valid_array($input_commodities, 'commodities');
    array_contains_numbers($input_commodities);
    $input_commodities = json_encode($input_commodities);
}

if (isset($data['discounts'])) {
    $input_discounts = $data['discounts'];
    valid_array($input_discounts, 'discounts');
    array_contains_numbers($input_discounts);
    $input_discounts = json_encode($input_discounts);
}

if (isset($data['ages'])) {
    $input_ages = $data['ages'];
    valid_array($input_ages, 'ages');
    array_contains_numbers($input_ages);
    $input_ages = json_encode($input_ages);
}

if (isset($data['cep'])) {
    $input_cep = filter_var($data['cep'], FILTER_SANITIZE_STRING);
    $input_cep = valid_cep($input_cep);
}

if (isset($data['streetnum'])) {
    $input_streetnum = filter_var($data['streetnum'], FILTER_SANITIZE_STRING);
    valid_characters(10,60,$input_streetnum);
}

if (isset($data['city'])) {
    $input_city = filter_var($data['city'], FILTER_SANITIZE_STRING);
    valid_characters(5,58,$input_city);
}

if (isset($data['neighborhood'])) {
    $input_neighborhood = filter_var($data['neighborhood'], FILTER_SANITIZE_STRING);
    valid_characters(5,58,$input_neighborhood);
}

if (isset($data['plus'])) {
    $input_plus = filter_var($data['plus'], FILTER_SANITIZE_STRING);
    valid_characters(0,40,$input_plus);
}

if (isset($data['state'])) {
    $input_state = filter_var($data['state'], FILTER_SANITIZE_STRING);
    valid_characters(4,25,$input_state);
}

if (isset($data['country'])) {
    $input_country = filter_var($data['country'], FILTER_SANITIZE_STRING);
    valid_characters(1,41,$input_country);
}
