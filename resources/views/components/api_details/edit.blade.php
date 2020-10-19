<form id="ajaxUpdateForm" method="patch" action="{{ route('api_tickets.update', $apiTicket->id) }}">
    <input id="model-id" type="hidden" name="id" value="{{ $apiTicket->id }}">
    <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
            <h3 class="block-title">Edit Api Details</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                    <i class="si si-close"></i>
                </button>
            </div>
        </div>

        <div class="block-content">
    
            <div class="form-group row">
                <label class="col-12" for="name">Name</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name..." value="{{ $apiTicket->name }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="service">Service</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="service" name="service" placeholder="service..." value="{{ $apiTicket->service }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="subdomain">SubDomain</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="subdomain" name="subdomain" placeholder="SubDomain.." value="{{ $apiTicket->subdomain }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="api_key">Api Token</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Api Token..." value="{{ $apiTicket->api_key }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="secret_key">User Name / Secret Key</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="secret_key" name="secret_key" placeholder="User Name / Secret Key..." value="{{ $apiTicket->secret_key }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="url">Url</label>
                <div class="col-md-12">
                    <input type="text" class="form-control" id="url" name="url" placeholder="Url..." value="{{ $apiTicket->url }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="limit_time">Update Limit Time (-1 day)</label>
                <div class="col-md-12">
                    <input type="text" class="form-control" id="limit_time" name="limit_time" placeholder="limit_time..."  value="{{ $apiTicket->limit_time }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="limit_import">All Import Limit</label>
                <div class="col-md-12">
                    <input type="text" class="form-control" id="limit_import" name="limit_import" placeholder="limit_import..." value="{{ $apiTicket->limit_import }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="current_page">Current Import Page</label>
                <div class="col-md-12">
                    <input type="text" class="form-control" id="current_page" name="current_page" placeholder="current_page..." value="{{ $apiTicket->current_page }}" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="Cron">Cron</label>
                <div class="col-md-12">
                    <select class="form-control" id="cron" name="cron">
                        <option value="0" {{ empty($apiTicket->cron) ? 'selected' : '' }}>...</option>
                        <option value="1" {{ $apiTicket->cron === '1' ? 'selected' : '' }}>Update once a day</option>
                        <option value="2" {{ $apiTicket->cron === '2' ? 'selected' : '' }}>Update twice a day</option>
                        <option value="3" {{ $apiTicket->cron === '3' ? 'selected' : '' }}>Import once a day</option>
                        <option value="4" {{ $apiTicket->cron === '4' ? 'selected' : '' }}>To import two times a day</option>
                        <option value="5" {{ $apiTicket->cron === '5' ? 'selected' : '' }}>Import and update once a day</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-alt-success">
            <i class="fa fa-check"></i> Update 
        </button>
    </div>
</form>

