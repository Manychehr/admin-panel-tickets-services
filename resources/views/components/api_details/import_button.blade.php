
        @if (empty($model->page))
        <button 
            type="button" 
            class="btn btn-sm btn-danger eventItem" 
            data-id="{{ $model->id }}" 
            data-metod="send-import"
            data-confirm="Are You sure want to Import Tickets !"
        >
            <i class="fa fa-database"></i> All
        </button>
        @endif

        <button 
            type="button" 
            class="btn btn-sm btn-success eventItem" 
            data-id="{{ $model->id }}" 
            data-metod="send-update"
            data-confirm="Are You sure want to Update Tickets !"
        >
            <i class="fa fa-database"></i> Update
        </button>

