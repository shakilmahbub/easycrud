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
                <h4 class="mt-5 mb-5">Test Biographies</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('test_biographies.test_biography.create') }}" class="btn btn-success" title="Create New Test Biography">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($testBiographies) == 0)
            <div class="panel-body text-center">
                <h4>No Test Biographies Available.</h4>
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
                    @foreach($testBiographies as $testBiography)
                        <tr>
                            <td>{{ $testBiography->name }}</td>
                            <td>{{ $testBiography->age }}</td>
                            <td>{{ $testBiography->biography }}</td>
                            <td>{{ $testBiography->sport }}</td>
                            <td>{{ $testBiography->gender }}</td>
                            <td>{{ $testBiography->colors }}</td>
                            <td>{{ ($testBiography->is_retired) ? 'Yes' : 'No' }}</td>
                            <td>{{ $testBiography->range }}</td>
                            <td>{{ $testBiography->month }}</td>

                            <td>

                                <form method="POST" action="{!! route('test_biographies.test_biography.destroy', $testBiography->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('test_biographies.test_biography.show', $testBiography->id ) }}" class="btn btn-info" title="Show Test Biography">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('test_biographies.test_biography.edit', $testBiography->id ) }}" class="btn btn-primary" title="Edit Test Biography">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Test Biography" onclick="return confirm(&quot;Click Ok to delete Test Biography.&quot;)">
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
            {!! $testBiographies->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection