@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.gigs.index') }}">Gigs</a></li>
        <li><span href="javascript:void(0)">View Gig# {{$gig->gig_cryptic}}</span></li>
    </ul>
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-phone"></i> <strong>Gig</strong> Information</h2>
                </div>

                @php
                    // Decode JSON from database columns
                    $gig_resolution = json_decode($gig->resolution)[0];
                    $parts_used = json_decode($gig_resolution->partsUsed);
                    $gig_images = json_decode($gig->gig_report_images);
                    $machine = $gig->machine;

                    // Decode common_repairs and solution
                    // $common_repairs = json_decode($machine->common_repairs, true);
                    $common_repairs = json_decode($gig->top_recommended_repairs, true);
                    $addtl_common_repairs = json_decode($gig->addtl_recommended_repairs, true);
                    $solution_ids = json_decode($gig_resolution->solution, true);

                    // Filter repairs that match the solution IDs
                    $matched_repairs = array_filter($common_repairs, function ($repair) use ($solution_ids) {
                        return in_array($repair['id'], $solution_ids);
                    });
                @endphp

                <table class="table table-borderless table-striped table-vcenter">
                    <tbody>
                        <tr>
                            <td style="width: 30%" class="text-right"><strong>Diagnosis</strong></td>
                            <td style="width: 70%">{{$gig_resolution->jobCompletion}}</td>
                        </tr>

                        <tr>
                            <td style="width: 30%" class="text-right"><strong>Parts Used</strong></td>
                            <td style="width: 70%">
                                @if($gig_resolution->jobCompletion == "full-repair")
                                <ul>
                                    @foreach($parts_used ?? [] as $value)
                                        <li>{{$value}}</li>
                                    @endforeach
                                </ul>
                                @else 
                                    <p>N/A</p>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 30%" class="text-right"><strong>Common Repairs</strong></td>
                            <td style="width: 70%">
                                <ul>
                                    @foreach($matched_repairs ?? [] as $repair)
                                        <li>
                                            <strong>{{ $repair['title'] }}</strong><br>
                                            <em>Symptoms:</em> {{ $repair['symptoms'] }}<br>
                                            <em>Solution:</em> {{ $repair['solution'] }}<br>
                                            <em>Parts:</em> {{ implode(', ', $repair['parts']) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 30%" class="text-right"><strong>Gig Report Images</strong></td>
                            <td style="width: 70%">
                                <ul style="list-style-type:none;">
                                    @foreach($gig_images ?? [] as $value)
                                        <li>
                                            <a href="{{config('app.frontend_url')}}{{$value}}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">
                                                <img src="{{config('app.frontend_url')}}{{$value}}" alt="" class="img-responsive center-block" style="max-width: 100px;">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 30%" class="text-right"><strong>Additional Recommended Repairs</strong></td>
                            <td style="width: 70%">
                                <ul style="list-style-type:none;">
                                    @foreach($addtl_common_repairs ?? [] as $field)
                                    
                                        <li>
                                            
                                            <p style="margin-bottom:unset;"><strong>Content:</strong> {!! $field['content'] !!}</p>

                                            @foreach($field['images'] ?? [] as $img)
                                                    <a href="{{config('app.frontend_url')}}{{$img['url']}}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">
                                                        <img src="{{config('app.frontend_url')}}{{$img['url']}}" alt="" class="img-responsive center-block" alt="{{$img['filename']}}" style="max-width: 100px;">
                                                    </a>
                                            @endforeach
                                        
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>




                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/contacts.js') }}"></script>
@endpush