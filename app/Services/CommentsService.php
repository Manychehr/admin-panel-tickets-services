<?php 

namespace App\Services;

use App\Models\Comment;

class CommentsService
{

    /**
     * service_id = ApiTicket $apiTicket->id
     */
    public static function updateOrCreate(\stdClass $comment, $ticket_id, $service_id)
    {
        return Comment::updateOrCreate(
            ['api_id' => $comment->id, 'ticket_id' => $ticket_id, 'author_id' => $comment->author_id, 'service_id' => $service_id],
            ['data' => (array)$comment]
        );
    }

    public static function findApiId($api_id, $service_id)
    {
        return Comment::where('api_id', $api_id)->where('service_id', $service_id)->first();
    }

    public static function updateOrCreateNew($api_id, $ticket_id, $author_id, $service_id, $data)
    {
        return Comment::updateOrCreate(
            ['api_id' => $api_id, 'ticket_id' => $ticket_id, 'author_id' => $author_id, 'service_id' => $service_id],
            ['data' => (array)$data]
        );
    }
}
