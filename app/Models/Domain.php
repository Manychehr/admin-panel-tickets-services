<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    
    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the service that owns the Author.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'api_id');
    }

    public function getHostAllTickets($tickets=[])
    {
        $domains = Domain::where('host', $this->host)->get();
        foreach ($domains as $domain) {
            $tickets[] = $domain->ticket;
        }
        return $tickets;
    }
}
