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
                <h4 class="mt-5 mb-5">Biographyudates</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('biographyudates.biographyudate.create') }}" class="btn btn-success" title="Create New Biographyudate">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($biographyudates) == 0)
            <div class="panel-body text-center">
                <h4>No Biographyudates Available.</h4>
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
                    @foreach($biographyudates as $biographyudate)
                        <tr>
                            <td>{{ $biographyudate->name }}</td>
                            <td>{{ $biographyudate->age }}</td>
                            <td>{{ $biographyudate->biography }}</td>
                            <td>{{ $biographyudate->sport }}</td>
                            <td>{{ $biographyudate->gender }}</td>
                            <td>{{ $biographyudate->colors }}</td>
                            <td>{{ ($biographyudate->is_retired) ? 'Yes' : 'No' }}</td>
                            <td>{{ $biographyudate->range }}</td>
                            <td>{{ $biographyudate->month }}</td>

                            <td>

                                <form method="POST" action="{!! route('biographyudates.biographyudate.destroy', $biographyudate->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('biographyudates.biographyudate.show', $biographyudate->id ) }}" class="btn btn-info" title="Show Biographyudate">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('biographyudates.biographyudate.edit', $biographyudate->id ) }}" class="btn btn-primary" title="Edit Biographyudate">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Biographyudate" onclick="return confirm(&quot;Click Ok to delete Biographyudate.&quot;)">
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
            {!! $biographyudates->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection