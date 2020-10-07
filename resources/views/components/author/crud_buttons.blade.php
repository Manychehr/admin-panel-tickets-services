
    <div class="btn-group">
        @if ($model->show_tickets)
        <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hide tickets for the user">
            <button 
                type="button" 
                class="btn btn-sm btn-danger eventItem" 
                data-id="{{ $model->id }}" 
                data-metod="hide-ticket"
                data-confirm="Are you sure you want to hide this user's tickets?"
            >
                <i class="fa fa-eye-slash"></i>
            </button>
        </span>
        @else
        <span class="js-tooltip-enabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show tickets for the user">
            <button 
                type="button" 
                class="btn btn-sm btn-success eventItem" 
                data-id="{{ $model->id }}" 
                data-metod="show-ticket"
                data-confirm="Are you sure you want to show this user's tickets?"
            >
                <i class="fa fa-user-times"></i>
            </button>
        </span>
        @endif
    </div>
