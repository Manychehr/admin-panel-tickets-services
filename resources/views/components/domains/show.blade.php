
<div class="block-header bg-primary-dark">
    <h3 class="block-title">Show Domain Ticket</h3>
    <div class="block-options">
        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
            <i class="si si-close"></i>
        </button>
    </div>
</div>
<div class="block-content">
    <table class="table table-striped table-vcenter">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Created</th>
                <th>Subject</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($domain->getHostAllTickets() as $item)
            <tr>
                <th class="text-center" scope="row">{{ $item->id }}</th>
                <td>
                    {{ $item->created_at->format('Y-m-d H:m') }}
                </td>
                <td>
                    <a href="{{ route('tickets.full-show', $item->id) }}" target="_blank">{{ Str::limit($item->data['subject'], 20, ' (...)') }}</a>
                </td>
            </tr>
            @empty
                no attachments
            @endforelse
        </tbody>
    </table>
</div>
