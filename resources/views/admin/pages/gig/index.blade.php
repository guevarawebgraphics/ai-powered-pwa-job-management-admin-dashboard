@extends('admin.layouts.base')

@section('content')

    @if (auth()->user()->can('Create Gig'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.gigs.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            Gig
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
                @if(!$client)
                    <strong>Gigs</strong>
                @else 
                    <strong>{{ $client ? $client->client_name . ' ' .$client->client_last_name: '' }}'s Gig History</strong>
                @endif
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable gig-empty {{$gigs->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Gigs found.
        </div>
        <div class="table-responsive {{$gigs->count() == 0 ? 'johnCena' : '' }}">
            <table id="gigs-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        GIG Cryptic
                    </th>
                    <th class="text-center">
                        Machine Brand
                    </th>
                    <th class="text-center">
                        Type
                    </th>
                    <th class="text-center">
                        Status
                    </th>
                    <th class="text-center">
                        Model Number
                    </th>
                    <th class="text-center">
                        Serial Number
                    </th>
                    <th class="text-center">
                        Price
                    </th>
                    <th class="text-center">
                        Client
                    </th>
                    <th class="text-center">
                        Assigned Technician
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
                @foreach($gigs as $gig)
                    <tr data-gig-id="{{$gig->gig_id}}">
                        <td class="text-center"><strong>{{ $gig->gig_id }}</strong></td>
                        <td class="text-center"><strong>{{ $gig->gig_cryptic }}</strong></td>
                        <td class="text-center"><strong>{{ $gig->machine->brand_name }}</strong></td>
                        <td class="text-center"><strong>{{ $gig->machine->machine_type }}</strong></td>

                        <td class="text-center">
                            <span class="badge 
                                @if($gig->gig_complete == 0) badge-warning
                                @elseif($gig->gig_complete == 1) badge-primary
                                @elseif($gig->gig_complete == 2) badge-success
                                @elseif($gig->gig_complete == 3) badge-info
                                @endif">
                                @if($gig->gig_complete == 0) Pending
                                @elseif($gig->gig_complete == 1) Started
                                @elseif($gig->gig_complete == 2) Ended
                                @elseif($gig->gig_complete == 3) Submitted Report
                                @endif
                            </span>

                        </td>
                        <td class="text-center"><a href="{{url('admin/machines/' .$gig->machine->machine_id. '/edit')}}">
                                <i class="fa fa-pencil"></i> {{ $gig->machine->model_number }}</a></td>
                        <td class="text-center"><strong>{{ $gig->serial_number }}</strong></td>
                        <td class="text-center">
                            <strong class="text-success">${{ $gig->gig_price }}</strong>
                        </td>
                        <td class="text-center">
                            <a href="{{url('admin/clients/'.$gig->client->client_id.'/edit')}}">
                                <i class="fa fa-pencil"></i>
                                {{ $gig->client->client_name }} {{ $gig->client->client_last_name}}<br>
                                (<small><em>{{$gig->client->email}}</em></small>)
                            </a>
                        </td>
                        <td class="text-center">
                            @if($gig->technician)
                            <a href="{{url('admin/users/'.$gig->technician->id.'/edit')}}">
                                <i class="fa fa-pencil"></i>
                                {{ $gig->technician->name }} {{ $gig->technician->name}}<br>
                                (<small><em>{{$gig->technician->email}}</em></small>)
                            </a>
                            @endif
                        </td>
                        <td class="text-center">{{ $gig->created_at->format('F d, Y') }}</td>
                        <td class="text-center">

                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Read Gig'))
                                    <a href="{{ route('admin.gigs.show', $gig->gig_id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="View"><i class="fa fa-eye"></i> View Report</a>
                                @endif
                                @if (auth()->user()->can('Update Gig'))
                                    <a href="{{ route('admin.gigs.edit', $gig->gig_id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Gig'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-gig-btn"
                                       data-original-title="Delete"
                                       data-gig-id="{{ $gig->gig_id }}"
                                       data-gig-route="{{ route('admin.gigs.delete', $gig->gig_id) }}">
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/gigs.js') }}"></script>
@endpush