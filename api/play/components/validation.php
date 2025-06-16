<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/validate_infos.php";

if (isset($data['description'])) {
    $input_description = trim($data['description']);
    valid_description($input_description);
}

if (isset($data['name'])) {
    $input_name = trim($data['name']);
    valid_play_name($input_name);
}

if (isset($data['cnpj'])) {
    $input_cnpj = trim($data['cnpj']);
    valid_cnpj($input_cnpj);
}

if (isset($data['telephone'])) {
    $input_telephone = trim($data['telephone']);
    valid_telephone($input_telephone);
}

if (isset($data['email'])) {
    $input_email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    valid_email($input_email);
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
    $input_cep = trim($data['cep']);
    $input_cep = valid_cep($input_cep);
}

if (isset($data['streetnum'])) {
    $input_streetnum = trim($data['streetnum']);
    valid_characters(10,60,$input_streetnum, 'Endereço');
}

if (isset($data['city'])) {
    $input_city = trim($data['city']);
    valid_characters(5,58,$input_city, 'Cidade');
}

if (isset($data['neighborhood'])) {
    $input_neighborhood = trim($data['neighborhood']);
    valid_characters(5,58,$input_neighborhood, 'Bairro');
}

if (isset($data['plus'])) {
    $input_plus = trim($data['plus']);
    valid_characters(0,40,$input_plus, 'Complemento');
}

if (isset($data['state'])) {
    $input_state = trim($data['state']);
    valid_characters(4,25,$input_state, 'Estado');
}

if (isset($data['country'])) {
    $input_country = trim($data['country']);
    valid_characters(1,41,$input_country, 'País');
}
