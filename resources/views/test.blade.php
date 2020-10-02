@extends('layouts.app')

@section('content')
<div class="content">
    <h2 class="content-heading">Test</h2>
    <!-- Default Elements -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Test pars</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            @include('components.alert')
            <form action="{{ route('test.test') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-12" for="import_text">Text</label>
                    <div class="col-12">
                    <textarea class="form-control" id="import_text" name="test_text" rows="6" placeholder="Text" required>{{ $test_text?? '' }}</textarea>
                    </div>
                </div>
     
                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" style="float: right;" class="btn btn-alt-primary">Test</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- END Default Elements -->
    @if (!empty($result))
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Result pars</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            @foreach ($result as $item)
            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;">
                            {{ $item['name' ]}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($item['pars'] as $pars)
                    <tr>
                        <td class="font-w600">{{ $pars }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="font-w600">no {{ $item['name' ]}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
