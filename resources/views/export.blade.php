@extends('layouts.app')

@push('css_after')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush

@section('content')
<div class="content">
    <h2 class="content-heading">Export</h2>
    <!-- Default Elements -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Экспорт</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            @include('components.alert')
            <form action="{{ route('export.file') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-12">Экспортируем</label>
                </div>
                        <div class="form-group row">
                            <label class="col-12" for="example-daterange1">По дате парсинга</label>
                            <div class="col-12">
                                <div class="input-daterange input-group js-datepicker-enabled" data-date-format="mm-dd-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <input type="text" class="form-control" id="example-daterange1" name="start_parsing" placeholder="Начало" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                    <div class="input-group-prepend input-group-append">
                                        <span class="input-group-text font-w600">to</span>
                                    </div>
                                    <input type="text" class="form-control" id="example-daterange2" name="end_parsing" placeholder="Конец" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12" for="example-text-input">Отправителю</label>
                            <div class="col-12">
                                <input type="Text" class="form-control" id="count_line" name="user_name" placeholder="User Name ...">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12" for="select_author">Отправителю (role: admin)</label>
                            <div class="col-12">
                                <select class="form-control" id="select_author" name="select_author" style="width: 100%;" data-placeholder="Choose one..">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12" for="select_domain">По хосту</label>
                            <div class="col-12">
                                <select class="form-control" id="select_domain" name="select_domain" style="width: 100%;" data-placeholder="Choose one..">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12" for="select_ip">По ИП адресу</label>
                            <div class="col-12">
                                <select class="form-control" id="select_ip" name="select_ip" style="width: 100%;" data-placeholder="Choose one..">
                                    <option></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox custom-control-inline mb-5">
                                <input class="custom-control-input" type="checkbox" name="select_all" id="all" value="1">
                                <label class="custom-control-label" for="all">ВСЕ</label>
                            </div>
                        </div>
                    
                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" style="float: right;" class="btn btn-alt-primary">Экспортировать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Default Elements -->
</div>

@endsection
@push('js_after')
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {  
        
        $('.input-daterange input').each(function() {
            $(this).datepicker('clearDates');
        })

        $( "#select_author" ).select2({
            ajax: {
                url: '{{ route('export.autocomplete-author') }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }
                    return query;
                }
            }
        })

        $( "#select_domain" ).select2({
            ajax: {
                url: '{{ route('export.autocomplete-domain') }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }
                    return query;
                }
            }
        })

        $( "#select_ip" ).select2({
            ajax: {
                url: '{{ route('export.autocomplete-ip') }}',
                data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }
                    return query;
                }
            }
        })
    })
</script>
@endpush
