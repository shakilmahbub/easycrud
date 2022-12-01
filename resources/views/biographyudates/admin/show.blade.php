@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($biographyudate->name) ? $biographyudate->name : 'Biographyudate' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('biographyudates.biographyudate.destroy', $biographyudate->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('biographyudates.biographyudate.index') }}" class="btn btn-primary" title="Show All Biographyudate">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('biographyudates.biographyudate.create') }}" class="btn btn-success" title="Create New Biographyudate">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('biographyudates.biographyudate.edit', $biographyudate->id ) }}" class="btn btn-primary" title="Edit Biographyudate">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Biographyudate" onclick="return confirm(&quot;Click Ok to delete Biographyudate.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $biographyudate->name }}</dd>
            <dt>Age</dt>
            <dd>{{ $biographyudate->age }}</dd>
            <dt>Biography</dt>
            <dd>{{ $biographyudate->biography }}</dd>
            <dt>Sport</dt>
            <dd>{{ $biographyudate->sport }}</dd>
            <dt>Gender</dt>
            <dd>{{ $biographyudate->gender }}</dd>
            <dt>Colors</dt>
            <dd>{{ $biographyudate->colors }}</dd>
            <dt>Is Retired</dt>
            <dd>{{ ($biographyudate->is_retired) ? 'Yes' : 'No' }}</dd>
            <dt>Photo</dt>
            <dd>{{ asset('storage/' . $biographyudate->photo) }}</dd>
            <dt>Range</dt>
            <dd>{{ $biographyudate->range }}</dd>
            <dt>Month</dt>
            <dd>{{ $biographyudate->month }}</dd>

        </dl>

    </div>
</div>

@endsection