@extends('layout.app')
@section('main')
    <div class="main">
        <section class="content-info">
            <div class="container paddings-mini">

                <div class="row text-center text-lg-left">
                    @foreach($images as $image)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ $image->image }}" target="_blank" class="d-block mb-4 h-100">
                                <img class="img-fluid img-thumbnail" src="{{ $image->image }}" alt="{{ $image->person }} - {{ \Illuminate\Support\Carbon::createFromTimestamp($image->date)->format('d.m.y') }}">
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    </div>
@endsection

@push('styles')

@endpush
