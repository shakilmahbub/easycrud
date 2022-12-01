@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($testBiography->name) ? $testBiography->name : 'Test Biography' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('test_biographies.test_biography.destroy', $testBiography->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('test_biographies.test_biography.index') }}" class="btn btn-primary" title="Show All Test Biography">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('test_biographies.test_biography.create') }}" class="btn btn-success" title="Create New Test Biography">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('test_biographies.test_biography.edit', $testBiography->id ) }}" class="btn btn-primary" title="Edit Test Biography">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Test Biography" onclick="return confirm(&quot;Click Ok to delete Test Biography.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $testBiography->name }}</dd>
            <dt>Age</dt>
            <dd>{{ $testBiography->age }}</dd>
            <dt>Biography</dt>
            <dd>{{ $testBiography->biography }}</dd>
            <dt>Sport</dt>
            <dd>{{ $testBiography->sport }}</dd>
            <dt>Gender</dt>
            <dd>{{ $testBiography->gender }}</dd>
            <dt>Colors</dt>
            <dd>{{ $testBiography->colors }}</dd>
            <dt>Is Retired</dt>
            <dd>{{ ($testBiography->is_retired) ? 'Yes' : 'No' }}</dd>
            <dt>Photo</dt>
            <dd>{{ asset('storage/' . $testBiography->photo) }}</dd>
            <dt>Range</dt>
            <dd>{{ $testBiography->range }}</dd>
            <dt>Month</dt>
            <dd>{{ $testBiography->month }}</dd>

        </dl>

    </div>
</div>

@endsection