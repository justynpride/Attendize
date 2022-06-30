<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Event::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'location' => $faker->word,
        'bg_type' => $faker->word,
        'bg_color' => $faker->word,
        'bg_image_path' => $faker->word,
        'description' => $faker->text,
        'start_date' => $faker->dateTime(),
        'end_date' => $faker->dateTime(),
        'on_sale_date' => $faker->dateTime(),
        'account_id' => factory(App\Models\Account::class),
        'user_id' => $faker->randomNumber(),
        'currency_id' => factory(App\Models\Currency::class),
        'organiser_fee_fixed' => $faker->randomFloat(),
        'organiser_fee_percentage' => $faker->randomFloat(),
        'organiser_id' => factory(App\Models\Organiser::class),
        'venue_name' => $faker->word,
        'venue_name_full' => $faker->word,
        'location_address' => $faker->word,
        'location_address_line_1' => $faker->word,
        'location_address_line_2' => $faker->word,
        'location_country' => $faker->word,
        'location_country_code' => $faker->word,
        'location_state' => $faker->word,
        'location_post_code' => $faker->word,
        'location_street_number' => $faker->word,
        'location_lat' => $faker->word,
        'location_long' => $faker->word,
        'location_google_place_id' => $faker->word,
        'pre_order_display_message' => $faker->text,
        'post_order_display_message' => $faker->text,
        'social_share_text' => $faker->text,
        'social_show_facebook' => $faker->boolean,
        'social_show_linkedin' => $faker->boolean,
        'social_show_twitter' => $faker->boolean,
        'social_show_email' => $faker->boolean,
        'location_is_manual' => $faker->randomNumber(),
        'is_live' => $faker->boolean,
        'barcode_type' => $faker->word,
        'ticket_border_color' => $faker->word,
        'ticket_bg_color' => $faker->word,
        'ticket_text_color' => $faker->word,
        'ticket_sub_text_color' => $faker->word,
        'google_tag_manager_code' => $faker->word,
        'social_show_whatsapp' => $faker->boolean,
        'questions_collection_type' => $faker->word,
        'checkout_timeout_after' => $faker->randomNumber(),
        'is_1d_barcode_enabled' => $faker->boolean,
        'enable_offline_payments' => $faker->boolean,
        'offline_payment_instructions' => $faker->text,
        'event_image_position' => $faker->word,
    ];
});
