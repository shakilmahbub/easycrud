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
                <h4 class="mt-5 mb-5">Biographyudate1S</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('biographyudate1s.biographyudate1.create') }}" class="btn btn-success" title="Create New Biographyudate1">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($biographyudate1s) == 0)
            <div class="panel-body text-center">
                <h4>No Biographyudate1S Available.</h4>
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
                    @foreach($biographyudate1s as $biographyudate1)
                        <tr>
                            <td>{{ $biographyudate1->name }}</td>
                            <td>{{ $biographyudate1->age }}</td>
                            <td>{{ $biographyudate1->biography }}</td>
                            <td>{{ $biographyudate1->sport }}</td>
                            <td>{{ $biographyudate1->gender }}</td>
                            <td>{{ $biographyudate1->colors }}</td>
                            <td>{{ ($biographyudate1->is_retired) ? 'Yes' : 'No' }}</td>
                            <td>{{ $biographyudate1->range }}</td>
                            <td>{{ $biographyudate1->month }}</td>

                            <td>

                                <form method="POST" action="{!! route('biographyudate1s.biographyudate1.destroy', $biographyudate1->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('biographyudate1s.biographyudate1.show', $biographyudate1->id ) }}" class="btn btn-info" title="Show Biographyudate1">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('biographyudate1s.biographyudate1.edit', $biographyudate1->id ) }}" class="btn btn-primary" title="Edit Biographyudate1">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Biographyudate1" onclick="return confirm(&quot;Click Ok to delete Biographyudate1.&quot;)">
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
            {!! $biographyudate1s->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection