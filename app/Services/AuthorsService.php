<?php 

namespace App\Services;

use App\Models\Author;

class AuthorsService
{
    public static function updateOrCreate(\stdClass $author, $service_id)
    {
        return Author::updateOrCreate(
            ['api_id' => $author->id, 'service_id' => $service_id],
            [
                'name' => $author->name, 
                'email' => $author->email, 
                'role' => $author->role,
                'data' => (array)$author
            ]
        );
    }

    public static function findApiId($api_id, $service_id)
    {
        return Author::where('api_id', $api_id)->where('service_id', $service_id)->first();
    }

    public static function findEmail($email, $service_id)
    {
        return Author::where('email', $email)->where('service_id', $service_id)->first();
    }

    public static function updateOrCreateNew($api_id, $service_id, $name, $email, $data, $role = 'user')
    {
        return Author::updateOrCreate(
            ['api_id' => $api_id, 'service_id' => $service_id],
            [
                'name' => $name, 
                'email' => $email, 
                'role' => $role, 
                'data' => (array)$data
            ]
        );
    }

}
