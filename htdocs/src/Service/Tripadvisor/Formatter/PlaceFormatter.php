<?php

namespace App\Service\Tripadvisor\Formatter;

class PlaceFormatter
{
    public static function format(array $details, int $day): array
    {
        return [
            'name' => $details['name'] ?? '',
            'day' => $day ?? '',	
            'description' => $details['description'] ?? '',
            'website_url' => $details['website'] ?? '',
            'tripadvisor_url' => $details['web_url'] ?? '',
            'price_level' => isset($details['price_level']) ? $details['price_level'] : '',
            'rating' => isset($details['rating']) ? (float)$details['rating'] : 0.0,
            'rating_image_url' => $details['rating_image_url'] ?? '',
            'num_reviews' => isset($details['num_reviews']) ? (int)$details['num_reviews'] : 0,
            'address' => isset($details['address_obj']['address_string']) ? $details['address_obj']['address_string'] : '',
            'latitude' => isset($details['latitude']) ? (float)$details['latitude'] : 0.0,
            'longitude' => isset($details['longitude']) ? (float)$details['longitude'] : 0.0,
            'amenities' => isset($details['features']) ? $details['features'] : [],
            'photo_url' => $details['photo_url'] ?? '',
            'category' => $details['category'] ?? '',
            'place_id' => $details['location_id'] ?? '',
        ];
    }
    
}
