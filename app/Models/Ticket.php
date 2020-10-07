<?php

namespace App\Models;

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
        if (!empty($this->data['custom_fields']) && !empty($this->data['custom_fields']['notes'])) {
            return (string)$this->data['custom_fields']['notes'];
        }
        return 'no notes';
    }

    public static function hasHide()
    {
        return self::where('show', false)->count() > 0;
    }
}
