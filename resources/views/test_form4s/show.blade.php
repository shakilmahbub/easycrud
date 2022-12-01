@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Test Form4' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('test_form4s.test_form4.destroy', $testForm4->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('test_form4s.test_form4.index') }}" class="btn btn-primary" title="Show All Test Form4">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('test_form4s.test_form4.create') }}" class="btn btn-success" title="Create New Test Form4">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('test_form4s.test_form4.edit', $testForm4->id ) }}" class="btn btn-primary" title="Edit Test Form4">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Test Form4" onclick="return confirm(&quot;Click Ok to delete Test Form4.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Colors</dt>
            <dd>{{ $testForm4->colors }}</dd>

        </dl>

    </div>
</div>

@endsection