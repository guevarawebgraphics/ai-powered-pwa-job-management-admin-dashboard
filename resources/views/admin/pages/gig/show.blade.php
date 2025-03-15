@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.gigs.index') }}">Gigs</a></li>
        <li><span href="javascript:void(0)">View Gig</span></li>
    </ul>
    <div class="content-header">
        <div class="header-section">
            <h1>{{ $gig->name }}</h1>
            <h5>{{ $gig->slug }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="block block-alt-noborder">
                <article>
                    <h3 class="sub-header text-center"><strong> {{ $gig->created_at->format('F d, Y') }} </strong>
                        <div class="btn-group btn-group-xs pull-right">
                            @if (auth()->user()->can('Update Gig'))
                                <a href="{{ route('admin.gigs.edit', $gig->id) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                            @endif
                            @if (auth()->user()->can('Delete Gig'))
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-gig-btn"
                                   data-original-title="Delete"
                                   data-gig-id="{{ $gig->id }}"
                                   data-gig-route="{{ route('admin.gigs.delete', $gig->id) }}">
                                    <i class="fa fa-times"> Delete</i>
                                </a>
                            @endif
                        </div>
                    </h3>

                    <img src="{{ asset($gig->banner_image) }}" alt="{{ $gig->banner_image }}" class="img-responsive center-block" style="max-width: 100px;">

                    <p>{!! $gig->content !!}</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/gigs.js') }}"></script>
@endpush