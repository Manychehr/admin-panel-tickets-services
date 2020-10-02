
<div class="block-header bg-primary-dark">
    <h3 class="block-title">Show Option</h3>
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
                <tr>
                    <td class="font-w600">Key:</td>
                    <td>{{ $option->key }}</td>
                </tr>
                <tr>
                    <td class="font-w600">Value:</td>
                    <td>{{ $option->value }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
