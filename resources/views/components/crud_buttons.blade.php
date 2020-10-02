
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
                class="btn btn-sm btn-success editItem" 
                data-toggle="modal" 
                data-target="#modal_form"
                data-id="{{ $model->id }}" 
                data-metod="edit"
                data-confirm="Are you sure you want to add to the whitelist !"
            >
                <i class="fa fa-pencil"></i>
            </button>
        </span>
        <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remote">
            <button 
                type="button" 
                class="btn btn-sm btn-danger deleteItem" 
                data-id="{{ $model->id }}" 
                data-metod="destroy"
                data-confirm="Are You sure want to delete !"
            >
                <i class="fa fa-times"></i>
            </button>
        </span>
    </div>
