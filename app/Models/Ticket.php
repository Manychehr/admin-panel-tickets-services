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

    /**
     * Get the comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'api_id');
    }

    /**
     * Get the authorthat owns the ticket.
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'api_id');
    }
}
