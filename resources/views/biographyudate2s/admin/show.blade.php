@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($biographyudate2->name) ? $biographyudate2->name : 'Biographyudate2' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('biographyudate2s.biographyudate2.destroy', $biographyudate2->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('biographyudate2s.biographyudate2.index') }}" class="btn btn-primary" title="Show All Biographyudate2">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('biographyudate2s.biographyudate2.create') }}" class="btn btn-success" title="Create New Biographyudate2">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('biographyudate2s.biographyudate2.edit', $biographyudate2->id ) }}" class="btn btn-primary" title="Edit Biographyudate2">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Biographyudate2" onclick="return confirm(&quot;Click Ok to delete Biographyudate2.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $biographyudate2->name }}</dd>
            <dt>Age</dt>
            <dd>{{ $biographyudate2->age }}</dd>
            <dt>Biography</dt>
            <dd>{{ $biographyudate2->biography }}</dd>
            <dt>Sport</dt>
            <dd>{{ $biographyudate2->sport }}</dd>
            <dt>Gender</dt>
            <dd>{{ $biographyudate2->gender }}</dd>
            <dt>Colors</dt>
            <dd>{{ $biographyudate2->colors }}</dd>
            <dt>Is Retired</dt>
            <dd>{{ ($biographyudate2->is_retired) ? 'Yes' : 'No' }}</dd>
            <dt>Photo</dt>
            <dd>{{ asset('storage/' . $biographyudate2->photo) }}</dd>
            <dt>Range</dt>
            <dd>{{ $biographyudate2->range }}</dd>
            <dt>Month</dt>
            <dd>{{ $biographyudate2->month }}</dd>

        </dl>

    </div>
</div>

@endsection