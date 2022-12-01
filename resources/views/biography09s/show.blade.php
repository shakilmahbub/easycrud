@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($biography09->name) ? $biography09->name : 'Biography09' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('biography09s.biography09.destroy', $biography09->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('biography09s.biography09.index') }}" class="btn btn-primary" title="Show All Biography09">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('biography09s.biography09.create') }}" class="btn btn-success" title="Create New Biography09">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('biography09s.biography09.edit', $biography09->id ) }}" class="btn btn-primary" title="Edit Biography09">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Biography09" onclick="return confirm(&quot;Click Ok to delete Biography09.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $biography09->name }}</dd>
            <dt>Age</dt>
            <dd>{{ $biography09->age }}</dd>
            <dt>Biography</dt>
            <dd>{{ $biography09->biography }}</dd>
            <dt>Sport</dt>
            <dd>{{ $biography09->sport }}</dd>
            <dt>Gender</dt>
            <dd>{{ $biography09->gender }}</dd>
            <dt>Colors</dt>
            <dd>{{ $biography09->colors }}</dd>
            <dt>Is Retired</dt>
            <dd>{{ ($biography09->is_retired) ? 'Yes' : 'No' }}</dd>
            <dt>Photo</dt>
            <dd>{{ asset('storage/' . $biography09->photo) }}</dd>
            <dt>Range</dt>
            <dd>{{ $biography09->range }}</dd>
            <dt>Month</dt>
            <dd>{{ $biography09->month }}</dd>

        </dl>

    </div>
</div>

@endsection