@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Machine'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="{{ route('admin.machines.create') }}" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            <strong>Add New</strong>
                            Machine
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
                <strong>Machines</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable machine-empty {{$machines->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Machines found.
        </div>
        <div class="table-responsive {{$machines->count() == 0 ? 'johnCena' : '' }}">
            <table id="machines-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        Model Number
                    </th>
                    <th class="text-left">
                        Brand
                    </th>
                    <th class="text-left">
                        Type
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
                @foreach($machines as $machine)
                    <tr data-machine-id="{{$machine->machine_id}}">
                        <td class="text-center"><strong>{{ $machine->machine_id }}</strong></td>
                        <td class="text-center"><strong>{{ $machine->model_number }}</strong></td>
                        <td class="text-center"><strong>{{ $machine->brand_name }}</strong></td>
                        <td class="text-center"><strong>{{ $machine->machine_type }}</strong></td>
                        <td class="text-center">{{ $machine->created_at->format('F d, Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                @if (auth()->user()->can('Update Machine'))
                                    <a href="{{ route('admin.machines.edit', $machine->machine_id) }}"
                                       data-toggle="tooltip"
                                       title=""
                                       class="btn btn-default"
                                       data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                @endif
                                @if (auth()->user()->can('Delete Machine'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-machine-btn"
                                       data-original-title="Delete"
                                       data-machine-id="{{ $machine->machine_id }}"
                                       data-machine-route="{{ route('admin.machines.delete', $machine->machine_id) }}">
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/machines.js') }}"></script>
@endpush