<form id="ajaxUpdateForm" method="post" action="{{ route('api_tickets.store') }}">
    
    <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
            <h3 class="block-title">Create Api Details</h3>
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
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name..." value="" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="service">Service</label>
                <div class="col-md-12">
                    <select class="form-control" id="service" name="service">
                        <option value="zendesk">Zendesk Api</option>
                        <option value="kayako">Kayako Api</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-12" for="subdomain">SubDomain</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="subdomain" name="subdomain" placeholder="SubDomain.." value="" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="api_key">Api Token</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Api Token..." value="" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="secret_key">User Name / Secret Key</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="secret_key" name="secret_key" placeholder="User Name / Secret Key..." value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="url">Url</label>
                <div class="col-md-12">
                    <input type="text" class="form-control" id="url" name="url" placeholder="Url..." required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-alt-success">
            <i class="fa fa-check"></i> Store 
        </button>
    </div>
</form>
