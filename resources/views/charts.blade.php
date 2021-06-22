@extends('layout.app')
@section('main')

    <div id="app" class="main">

        <section class="content-info">
            <chart :collection="{{ $graphData }}" :days="{{ $days }}"></chart>
        </section>
    </div>

@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>

    <script src="{{ asset('js/charts.js') }}"></script>

@endpush
