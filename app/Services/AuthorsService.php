<?php 

namespace App\Services;

use App\Models\Author;

class AuthorsService
{
    public static function updateOrCreate(\stdClass $author, $service_id)
    {
        return Author::updateOrCreate(
            ['api_id' => $author->id, 'service_id' => $service_id],
            ['name' => $author->name, 'email' => $author->email, 'data' => (array)$author]
        );
    }

    public static function findApiId($api_id, $service_id)
    {
        return Author::where('api_id', $api_id)->where('service_id', $service_id)->first();
    }
}
