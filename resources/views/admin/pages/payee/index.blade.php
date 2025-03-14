@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Payee'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.payees.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            Payee
                        </h4>
                    </div>
                    <div class="widget-extra-full">
                        <span class="h2 text-primary animation-expandOpen">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    @endif
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-newspaper-o sidebar-nav-icon"></i>
                <strong>Payees</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable payee-empty {{$payees->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Payees found.
        </div>
        <div class="table-responsive {{$payees->count() == 0 ? 'johnCena' : '' }}">
            <table id="payees-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        First Name
                    </th>
                    <th class="text-left">
                        Last Name
                    </th>
                    <th class="text-left">
                        Email
                    </th>
                    <th class="text-center">
                        Date Created
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($payees as $payee)
                    <tr data-payee-id="{{$payee->payee_id}}">
                        <td class="text-center"><strong>{{ $payee->payee_id }}</strong></td>
                        <td class="text-center"><strong>{{ $payee->payee_name }}</strong></td>
                        <td class="text-center"><strong>{{ $payee->payee_last_name }}</strong></td>
                        <td class="text-center"><strong>{{ $payee->email }}</strong></td>
                        <td class="text-center">{{ $payee->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Update Payee'))
                                    <a href="{{ route('admin.payees.edit', $payee->payee_id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Payee'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-payee-btn"
                                       data-original-title="Delete"
                                       data-payee-id="{{ $payee->payee_id }}"
                                       data-payee-route="{{ route('admin.payees.delete', $payee->payee_id) }}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/payees.js') }}"></script>
@endpush