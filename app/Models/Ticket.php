<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Атрибуты, которые должны быть преобразованы к базовым типам.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the domains.
     */
    public function domains()
    {
        return $this->hasMany(Domain::class, 'ticket_id', 'api_id');
    }

    public function domains_count()
    {
        return $this->domains()->count();
    }

    public function domains_order_rank()
    {
        return $this->domains()->orderBy('rank')->get();
    }

    /**
     * Get the IP addresses.
     */
    public function ip_addresses()
    {
        return $this->hasMany(IpAddress::class, 'ticket_id', 'api_id');
    }

    public function ip_addresses_count()
    {
        return $this->ip_addresses()->count();
    }

    /**
     * Get the comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'api_id');
    }

    public function comments_get_attachments($attachments=[])
    {
        if (!empty($comments = $this->comments()->where('data->attachments', '!=', '[]')->get())) {
            foreach ($comments as $comment) {
                foreach ($comment->get_attachments() as $attachment) {
                    $attachments[] = $attachment;
                }
            }
        }
        return $attachments;
    }

    /**
     * Get the authorthat owns the ticket.
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'api_id');
    }

    public function getNotes()
    {
        if ($this->service === 'zendesk') {
            return $this->zendeskNotes();
        }

        return $this->kayakoNotes();
    }

    public function zendeskNotes()
    {
        if (!empty($this->data['custom_fields']) && !empty($this->data['custom_fields']['notes'])) {
            return $this->data['custom_fields']['notes'];
        }
        return [];
    }

    public function kayakoNotes($notes = [])
    {
        if (!empty($this->data['note'])) {
            foreach ($this->data['note'] as $note) {
                if (!empty($note['_attributes']['creationdate'])) {
                    $date = (int)$note['_attributes']['creationdate'];
                } else {
                    $date = (int)$note['_attributes']['billdate'];
                }
                
                $notes[] = [
                    'user' => $note['_attributes']['creatorstaffname'],
                    'date' => (new Carbon((int)$date?? null))->format('Y-m-d H:m'),
                    'contents' => $note['_contents'],    
                ];
            }
        }
        return $notes;
    }

    public static function hasHide()
    {
        return self::where('show', false)->count() > 0;
    }
}
