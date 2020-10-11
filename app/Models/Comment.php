<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
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
     * Get the author that owns the comment.
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'api_id');
    }

    public function hasAuthor()
    {
        return $this->author()->count() > 0;
    }

    public function get_attachments()
    {
        if (!empty($this->data['ticketpostid'])) {
            return $this->kayakoAttachments();
        }
        return $this->zendeskAttachments();
    }

    public function kayakoAttachments($attachments = [])
    {
        if (!empty($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $attachment) {
                $attachment['content_url'] = route('export.file.attachment', ['comment' => $this->id, 'attachment_id' => $attachment['id']]);
                $attachments[] = $attachment;
            }
        }
        return $attachments;
    }

    public function zendeskAttachments()
    {
        if (!empty($this->data['attachments'])) {
            return $this->data['attachments'];
        }
        return [];
    }

    public function get_attachment($attachment_id)
    {
        if (!empty($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $attachment) {
                if ((int)$attachment_id === (int)$attachment['id']) {
                    return $attachment;
                }
            }
        }
        return false;
    }
}
