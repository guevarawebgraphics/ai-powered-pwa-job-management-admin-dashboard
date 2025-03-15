@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Client'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.clients.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            Client
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
                <strong>Clients</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable client-empty {{$clients->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Clients found.
        </div>
        <div class="table-responsive {{$clients->count() == 0 ? 'johnCena' : '' }}">
            <table id="clients-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        First Name
                    </th>
                    <th class="text-center">
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
                @foreach($clients as $client)
                    <tr data-client-id="{{$client->client_id}}">
                        <td class="text-center"><strong>{{ $client->client_id }}</strong></td>
                        <td class="text-center"><strong>{{ $client->client_name }}</strong></td>
                        <td class="text-center"><strong>{{ $client->client_last_name }}</strong></td>
                        <td class="text-left">{{ $client->email}}</td>
                        <td class="text-center">{{ $client->created_at ? $client->created_at->format('F d, Y') : NULL }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Read Gig'))
                                    <a href="{{ url('admin/gigs/client/'.$client->client_id.'/history') }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-pending"
                                       data-original-title="View"><i class="fa fa-eye"></i>  View Gigs</a>
                                @endif
                                @if (auth()->user()->can('Update Client'))
                                    <a href="{{ route('admin.clients.edit', $client->client_id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Client'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-client-btn"
                                       data-original-title="Delete"
                                       data-client-id="{{ $client->client_id }}"
                                       data-client-route="{{ route('admin.clients.delete', $client->client_id) }}">
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/clients.js') }}"></script>
@endpush