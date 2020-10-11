<div class="block">
    <div class="block-content block-header-default">
        <h4 class="block-title">Comments Body</h4>
        <hr>
        <div style="white-space: break-spaces;" class="big-table">
            {!! $model->data['html_body'] !!}
        </div>
        <hr>
        <h4 class="block-title">Attachments</h4>
        <hr>
        <table class="table table-striped table-vcenter">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Name</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Type</th>
                    <th class="text-center" style="width: 100px;">Size</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($model->get_attachments() as $item)
                <tr>
                    <th class="text-center" scope="row">{{ $item['id'] }}</th>
                    <td>
                        <a href="{{ $item['content_url']?? '' }}" target="_blank" rel="noopener noreferrer">{{ $item['file_name'] }}</a>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        {{ $item['content_type'] }}
                    </td>
                    <td class="text-center">
                        {{ $item['size'] }}
                    </td>
                </tr>
                @empty
                    no attachments
                @endforelse
            </tbody>
        </table>
    </div>
</div>