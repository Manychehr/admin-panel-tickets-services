
        {{ $model->subdomain }}
        @if (empty($model->import_at))
        <button 
            type="button" 
            class="btn btn-sm btn-danger eventItem" 
            data-id="{{ $model->id }}" 
            data-metod="send-import"
            data-confirm="Are You sure want to Import Tickets !"
        >
            <i class="fa fa-database"></i> Import
        </button>
        @endif
