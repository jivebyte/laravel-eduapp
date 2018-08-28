@extends('layouts.app')

@section('content')
        {!! $map['js'] !!}
    <body>
        <h1>Laucala Campus Map</h1>
        <div class="container">{!! $map['html'] !!}</div>
    </body>
@endsection
