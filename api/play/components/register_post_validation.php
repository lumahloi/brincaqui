<?php
require_once "../base_dir.php";
require_once BASE_DIR . "/utils/validate_infos.php";

if($input_description){
    valid_description($input_description);
}

if($input_name){
    valid_play_name($input_name);
}

if($input_cnpj){
    valid_cnpj($input_cnpj);
}

if($input_pictures){
    valid_array($input_pictures, 'pictures');
    valid_json_data($input_pictures, ['picture_name']); 
    json_field_non_empty($input_pictures, 'picture_name');
    $input_pictures = json_encode($input_pictures);
}

if($input_socials){
    valid_array($input_socials, 'socials');
    valid_json_data($input_socials, ['socials_name', 'socials_url']);
    json_field_non_empty($input_socials, 'socials_name');
    json_field_non_empty($input_socials, 'socials_url');
    $input_socials = json_encode($input_socials);
}

if($input_prices){
    valid_array($input_prices, 'prices');
    valid_json_data($input_prices, ['prices_title', 'prices_price']);
    json_field_non_empty($input_prices, 'prices_title');
    json_field_non_empty($input_prices, 'prices_price');
    foreach ($input_prices as $price_item) {
        valid_number($price_item['prices_price']);
    }
    $input_prices = json_encode($input_prices);
}

if($input_times){
    valid_array($input_times, 'times');
    valid_times($input_times);
    $input_times = json_encode($input_times);
}

if($input_commodities){
    valid_array($input_commodities, 'commodities');
    array_contains_numbers($input_commodities);
    $input_commodities = json_encode($input_commodities);
}

if($input_discounts){
    valid_array($input_discounts, 'discounts');
    array_contains_numbers($input_discounts);
    $input_discounts = json_encode($input_discounts);
}

if($input_telephone){
    valid_telephone($input_telephone);
}

if($input_email){
    valid_email($input_email);
}

if($input_ages){
    valid_array($input_ages, 'ages');
    array_contains_numbers($input_ages);
    $input_ages = json_encode($input_ages);
}
