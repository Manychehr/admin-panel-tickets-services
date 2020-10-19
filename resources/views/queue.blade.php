@extends('layouts.app')

@section('content')
<div class="content">
    <h2 class="content-heading">Queue Status</h2>
    <!-- Default Elements -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Очередь импорта</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-striped table-vcenter">
                {{-- <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Name</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">Access</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead> --}}
                <tbody>
                    <tr>
                        <th scope="row">Всего в очереди задач</th>
                        <td>{{ $jobs }}</td>
                        <td class="d-none d-sm-table-cell"></td>
                    </tr>
                    <tr>
                        <th scope="row">Проваленные задачи</th>
                        <td>{{ $failed_jobs }}</td>
                        <td class="d-none d-sm-table-cell"></td>
                    </tr>
                    <tr>
                        <th scope="row">Последние добавления</th>
                        <td></td>
                        <td class="d-none d-sm-table-cell"></td>
                    </tr>
                    {{-- @foreach ($websites as $website)
                        <tr>
                            <th scope="row">Domain</th>
                            <td>[{{ $website->created_at->toW3CString() }}] <b>{{ $website->host }}</b></td>
                            <td class="d-none d-sm-table-cell">{{ $website->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                    @foreach ($subdomains as $subdomain)
                        <tr>
                            <th scope="row">SubDomain</th>
                            <td>[{{ $subdomain->created_at->toW3CString() }}] <b>{{ $subdomain->subdomain }}</b></td>
                            <td class="d-none d-sm-table-cell">{{ $subdomain->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                    @foreach ($urls as $url)
                        <tr>
                            <th scope="row">Url</th>
                            <td>[{{ $url->created_at->toW3CString() }}] <b>{{ $url->url }}</b></td>
                            <td class="d-none d-sm-table-cell">{{ $url->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Default Elements -->
    <!-- Default Elements -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Очередь обновления</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <table class="table table-striped table-vcenter">
                <tbody>
                    <tr>
                        <th scope="row">Всего в очереди доменов</th>
                        <td>{{ $cron_domains }}</td>
                        <td class="d-none d-sm-table-cell"></td>
                    </tr>

                    <tr>
                        <th scope="row">Всего доменов</th>
                        <td>{{ $cron_domains }}</td>
                        <td class="d-none d-sm-table-cell"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Default Elements -->
</div>
@endsection
