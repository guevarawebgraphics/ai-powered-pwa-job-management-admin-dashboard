@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.clients.index') }}">Clients</a></li>
        <li><span href="javascript:void(0)">View Client</span></li>
    </ul>
    <div class="content-header">
        <div class="header-section">
            <h1>{{ $client->name }}</h1>
            <h5>{{ $client->slug }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="block block-alt-noborder">
                <article>
                    <h3 class="sub-header text-center"><strong> {{ $client->created_at->format('F d, Y') }} </strong>
                        <div class="btn-group btn-group-xs pull-right">
                            @if (auth()->user()->can('Update Client'))
                                <a href="{{ route('admin.clients.edit', $client->id) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                            @endif
                            @if (auth()->user()->can('Delete Client'))
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-client-btn"
                                   data-original-title="Delete"
                                   data-client-id="{{ $client->id }}"
                                   data-client-route="{{ route('admin.clients.delete', $client->id) }}">
                                    <i class="fa fa-times"> Delete</i>
                                </a>
                            @endif
                        </div>
                    </h3>

                    <img src="{{ asset($client->banner_image) }}" alt="{{ $client->banner_image }}" class="img-responsive center-block" style="max-width: 100px;">

                    <p>{!! $client->content !!}</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/clients.js') }}"></script>
@endpush