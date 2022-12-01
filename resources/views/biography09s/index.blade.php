@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Biography09S</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('biography09s.biography09.create') }}" class="btn btn-success" title="Create New Biography09">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($biography09s) == 0)
            <div class="panel-body text-center">
                <h4>No Biography09S Available.</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Biography</th>
                            <th>Sport</th>
                            <th>Gender</th>
                            <th>Colors</th>
                            <th>Is Retired</th>
                            <th>Range</th>
                            <th>Month</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($biography09s as $biography09)
                        <tr>
                            <td>{{ $biography09->name }}</td>
                            <td>{{ $biography09->age }}</td>
                            <td>{{ $biography09->biography }}</td>
                            <td>{{ $biography09->sport }}</td>
                            <td>{{ $biography09->gender }}</td>
                            <td>{{ $biography09->colors }}</td>
                            <td>{{ ($biography09->is_retired) ? 'Yes' : 'No' }}</td>
                            <td>{{ $biography09->range }}</td>
                            <td>{{ $biography09->month }}</td>

                            <td>

                                <form method="POST" action="{!! route('biography09s.biography09.destroy', $biography09->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('biography09s.biography09.show', $biography09->id ) }}" class="btn btn-info" title="Show Biography09">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('biography09s.biography09.edit', $biography09->id ) }}" class="btn btn-primary" title="Edit Biography09">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Biography09" onclick="return confirm(&quot;Click Ok to delete Biography09.&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $biography09s->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection