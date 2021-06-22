@extends('layout.app')
@section('main')
    <div class="main">
        <section class="content-info">
            <div class="container paddings-mini">
                <div class="row">
                    <div class="col-lg-4">
                        A Total of {{ \App\LaufClient::formatStepKm($ranking->sum('steps')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <table class="table-striped table-hover result-point">
                            <thead class="point-table-head">
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Name</th>
                                <th class="text-center">Schritte</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @foreach($ranking as $rank)
                                <tr>
                                    <td class="text-left number">
                                        {{ $rank->nr }}
                                        @if($rank->nr < $rank->lastNr)
                                            <i class="fa fa-caret-up text-success" title="Last rank was {{ $rank->lastNr }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i>
                                        @elseif($rank->nr > $rank->lastNr)
                                            <i class="fa fa-caret-down text-danger" title="Last rank was {{ $rank->lastNr }}" data-toggle="tooltip" data-placement="top" aria-hidden="true"></i>
                                        @elseif(null == $rank->lastNr)
                                            <i class="fa fa-plus text-primary" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-minus text-secondary" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    <td class="text-left">
                                        <img src="https://www.gravatar.com/avatar/{{ \App\LaufClient::formatAvatar($rank->person) }}?d={{ config('lauf.gravatar_icon') }}" alt="" />
                                        <span>
                                    {{ $rank->person }}
                                    </span>
                                    </td>
                                    <td>
                                        {{ \App\LaufClient::formatStepKm($rank->steps) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
