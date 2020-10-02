
<div class="block-header bg-primary-dark">
    <h3 class="block-title">Show Api Details</h3>
    <div class="block-options">
        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
            <i class="si si-close"></i>
        </button>
    </div>
</div>
<div class="block-content">
    <div class="table-responsive">
        <table class="table table-striped table-vcenter">
            <tbody>
                @foreach (['name', 'service', 'subdomain', 'api_key', 'secret_key', 'url'] as $key)
                <tr>
                    <td class="font-w600">{{ ucfirst($key) }}:</td>
                    <td>{{ $apiTicket->{$key} }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
