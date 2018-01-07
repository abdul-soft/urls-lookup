@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body" id="app">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                        <url-lookup-form
                                v-on:urlsent="checkUrls"
                                :user="{{ Auth::user() }}"
                        ></url-lookup-form>

                    <div class="">
                        <url-titles :titles="titles"></url-titles>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@endsection
