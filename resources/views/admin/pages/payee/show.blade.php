@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.payees.index') }}">Payees</a></li>
        <li><span href="javascript:void(0)">View Payee</span></li>
    </ul>
    <div class="content-header">
        <div class="header-section">
            <h1>{{ $payee->name }}</h1>
            <h5>{{ $payee->slug }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <div class="block block-alt-noborder">
                <article>
                    <h3 class="sub-header text-center"><strong> {{ $payee->created_at->format('F d, Y') }} </strong>
                        <div class="btn-group btn-group-xs pull-right">
                            @if (auth()->user()->can('Update Payee'))
                                <a href="{{ route('admin.payees.edit', $payee->id) }}"
                                   data-toggle="tooltip"
                                   title=""
                                   class="btn btn-default"
                                   data-original-title="Edit"><i class="fa fa-pencil"></i> Edit</a>
                            @endif
                            @if (auth()->user()->can('Delete Payee'))
                                <a href="javascript:void(0)" data-toggle="tooltip"
                                   title=""
                                   class="btn btn-xs btn-danger delete-payee-btn"
                                   data-original-title="Delete"
                                   data-payee-id="{{ $payee->id }}"
                                   data-payee-route="{{ route('admin.payees.delete', $payee->id) }}">
                                    <i class="fa fa-times"> Delete</i>
                                </a>
                            @endif
                        </div>
                    </h3>

                    <img src="{{ asset($payee->banner_image) }}" alt="{{ $payee->banner_image }}" class="img-responsive center-block" style="max-width: 100px;">

                    <p>{!! $payee->content !!}</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/payees.js') }}"></script>
@endpush