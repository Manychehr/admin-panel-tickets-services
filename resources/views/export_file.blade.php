
@foreach ($tickets as $ticket)
#{{ $ticket->api_id }} {{ $ticket->data['subject'] }} {{ $ticket->data['created_at'] }} {{ $ticket->data['updated_at'] }}

● Дополнительная информация:
● IP адреса
@forelse ($ticket->ip_addresses as $item)
{{ $item->ip }}
@empty
no ip_addresses detected
@endforelse

● Хосты с АлексаRank (domen;rank)
@forelse ($ticket->domains_order_rank() as $item)
{{ $item->host }};{{ $item->rank }}
@empty
no domains detected
@endforelse

● Прикрепленные файлы (линки на них)
@forelse ($ticket->comments_get_attachments() as $item)
{{ $item['content_url'] }}
@empty
no attachments
@endforelse

● Сообщения
@forelse ($ticket->comments as $comment)
{{ $comment->data['created_at'] }}
{{ $comment->data['plain_body'] }}
    @forelse ($comment->get_attachments() as $item)
    {{ $item['content_url'] }}
    @empty
    no attachments
    @endforelse

@empty
no attachments
@endforelse

@endforeach
