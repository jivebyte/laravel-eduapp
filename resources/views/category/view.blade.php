@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <a href="/categories/create" class="btn btn-success">CREATE NEW</a>
    </div>
    <div class="row">
            <table class ="table table-striped table-border table-hover text-center">
                <thead>
                    <tr>
                        <th> Category Name</th>
                        <th> </th>
                    </tr>
                </thead>
                <body>
                @if(count($category) > 0)
                    @foreach($category as $c)
                    <tr>
                        <td>
                                <div class="input-group">
                                    <li class="form-control">{{$c->cat_name}}</li>
                                    <span class="input-group-addon"><a href="/categories/{{$c->cat_id}}/edit" class="btn"><i class="fa fa-pencil fa-lg"></i></a></span>
                                    {!!Form::open(['action'=>['CategorysController@destroy', $c->cat_id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{-- {{Form::submit('Delete',['class'=> 'fa fa-trash-o fa-lg'])}} --}}
                                        {!! Form::button( '<i class="fa fa-trash-o fa-lg" style="color:#FF0000;"></i>', ['type' => 'submit'] ) !!}
                                    {!!Form::close()!!}
                                </div>
                        </td>
                        <td>
                            <a href="/levels/{{$c->cat_id}}" class="btn btn-info">DETAILS</a>
                            <a href="/map/{{$c->cat_id}}" class="btn btn-info">MAP</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Create your first category</td>
                    </tr>
                @endif
                </body>
            </table>
        </div>
@endsection
