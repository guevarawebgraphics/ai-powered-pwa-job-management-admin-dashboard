@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.machines.index') }}">Machines</a></li>
        <li><span href="javascript:void(0)">View Machine</span></li>
    </ul>
    <div class="content-header">
        <div class="header-section">
            <h1>{{ $machine->name }}</h1>
            <h5>{{ $machine->slug }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="block block-alt-noborder">
                <article>
                    <h3 class="sub-header text-center"><strong> {{ $machine->created_at->format('F d, Y') }} </strong>
                        <div class="btn-group btn-group-xs pull-right">
                            @if (auth()->user()->can('Update Machine'))
                                <a href="{{ route('admin.machines.edit', $machine->id) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                            @endif
                            @if (auth()->user()->can('Delete Machine'))
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-machine-btn"
                                   data-original-title="Delete"
                                   data-machine-id="{{ $machine->id }}"
                                   data-machine-route="{{ route('admin.machines.delete', $machine->id) }}">
                                    <i class="fa fa-times"> Delete</i>
                                </a>
                            @endif
                        </div>
                    </h3>

                    <img src="{{ asset($machine->banner_image) }}" alt="{{ $machine->banner_image }}" class="img-responsive center-block" style="max-width: 100px;">

                    <p>{!! $machine->content !!}</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/machines.js') }}"></script>
@endpush