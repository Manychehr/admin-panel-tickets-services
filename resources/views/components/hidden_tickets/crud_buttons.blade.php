
    <div class="btn-group">
        <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
            <button 
                type="button" 
                class="btn btn-sm btn-info showItem" 
                data-toggle="modal" 
                data-target="#modal_show_item"
                data-id="{{ $model->id }}"
            > 
                <i class="fa fa-info-circle"></i>
            </button>
        </span>
        <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show">
            <button 
                type="button" 
                class="btn btn-sm btn-success eventItem" 
                data-id="{{ $model->id }}" 
                data-metod="show-ticket"
                data-confirm="Are you sure you want to show this ticket?"
            >
                <i class="fa fa-eye-slash"></i>
            </button>
        </span>
    </div>
