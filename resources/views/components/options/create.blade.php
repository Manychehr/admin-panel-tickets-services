<form id="ajaxUpdateForm" method="post" action="{{ route('options.store') }}">
    <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
            <h3 class="block-title">Create Option</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                    <i class="si si-close"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            {{-- <div class="form-group row">
                <label class="col-12" for="type_options">Type Options</label>
                <div class="col-md-12">
                    <select class="form-control" id="type_options" name="type">
                        <option value="value">value</option>
                        <option value="zendesk_api">Zendesk Api</option>
                        <option value="kayako_api">Kayako Api</option>
                    </select>
                </div>
            </div> --}}
            <div class="form-group row">
                <label class="col-12" for="name">Options name (key)</label>
                <div class="col-12">
                    <input type="text" class="form-control" id="name" name="key" placeholder="Key.." value="" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12" for="value">Value</label>
                <div class="col-md-12">
                    <input type="text" class="form-control" id="value" name="value" placeholder="Value.." required>
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
