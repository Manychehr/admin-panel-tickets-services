@if (\App\Models\Ticket::hasHide())
<a href="{{ route('hidden_tickets.index') }}" class="btn btn-alt-danger mr-5 mb-5">
    <i class="fa fa-eye-slash mr-5"></i>Hidden tickets
</a>
@endif

@if (\App\Models\Author::hasHide())
<a href="{{ route('authors.index', ['show_tickets' => true]) }}" class="btn btn-alt-danger mr-5 mb-5">
    <i class="fa fa-user-times mr-5"></i>Hidden user tickets
</a>
@endif