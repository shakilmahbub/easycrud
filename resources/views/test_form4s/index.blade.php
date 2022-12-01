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
                <h4 class="mt-5 mb-5">Test Form4S</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('test_form4s.test_form4.create') }}" class="btn btn-success" title="Create New Test Form4">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($testForm4s) == 0)
            <div class="panel-body text-center">
                <h4>No Test Form4S Available.</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Colors</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($testForm4s as $testForm4)
                        <tr>
                            <td>{{ $testForm4->colors }}</td>

                            <td>

                                <form method="POST" action="{!! route('test_form4s.test_form4.destroy', $testForm4->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('test_form4s.test_form4.show', $testForm4->id ) }}" class="btn btn-info" title="Show Test Form4">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('test_form4s.test_form4.edit', $testForm4->id ) }}" class="btn btn-primary" title="Edit Test Form4">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Test Form4" onclick="return confirm(&quot;Click Ok to delete Test Form4.&quot;)">
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
            {!! $testForm4s->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection