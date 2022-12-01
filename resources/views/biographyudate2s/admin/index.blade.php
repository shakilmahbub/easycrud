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
                <h4 class="mt-5 mb-5">Biographyudate2S</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('biographyudate2s.biographyudate2.create') }}" class="btn btn-success" title="Create New Biographyudate2">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($biographyudate2s) == 0)
            <div class="panel-body text-center">
                <h4>No Biographyudate2S Available.</h4>
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
                    @foreach($biographyudate2s as $biographyudate2)
                        <tr>
                            <td>{{ $biographyudate2->name }}</td>
                            <td>{{ $biographyudate2->age }}</td>
                            <td>{{ $biographyudate2->biography }}</td>
                            <td>{{ $biographyudate2->sport }}</td>
                            <td>{{ $biographyudate2->gender }}</td>
                            <td>{{ $biographyudate2->colors }}</td>
                            <td>{{ ($biographyudate2->is_retired) ? 'Yes' : 'No' }}</td>
                            <td>{{ $biographyudate2->range }}</td>
                            <td>{{ $biographyudate2->month }}</td>

                            <td>

                                <form method="POST" action="{!! route('biographyudate2s.biographyudate2.destroy', $biographyudate2->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('biographyudate2s.biographyudate2.show', $biographyudate2->id ) }}" class="btn btn-info" title="Show Biographyudate2">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('biographyudate2s.biographyudate2.edit', $biographyudate2->id ) }}" class="btn btn-primary" title="Edit Biographyudate2">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Biographyudate2" onclick="return confirm(&quot;Click Ok to delete Biographyudate2.&quot;)">
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
            {!! $biographyudate2s->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection