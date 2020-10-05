
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
        <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
            <button 
                type="button" 
                class="btn btn-sm btn-success eventItem" 
                data-toggle="modal" 
                data-target="#modal_form"
                data-id="{{ $model->id }}" 
                data-metod="hide-ticket"
                data-confirm="Are you sure you want to hide this ticket?"
            >
                <i class="fa fa-eye-slash"></i>
            </button>
        </span>
        <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remote">
            <button 
                type="button" 
                class="btn btn-sm btn-danger eventItem" 
                data-id="{{ $model->id }}" 
                data-metod="hide-user-tickets"
                data-confirm="Are you sure you want to hide this user's tickets?"
            >
                <i class="fa fa-user-times"></i>
            </button>
        </span>
    </div>
