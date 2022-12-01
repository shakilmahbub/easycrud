@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($biographyudate1->name) ? $biographyudate1->name : 'Biographyudate1' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('biographyudate1s.biographyudate1.destroy', $biographyudate1->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('biographyudate1s.biographyudate1.index') }}" class="btn btn-primary" title="Show All Biographyudate1">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('biographyudate1s.biographyudate1.create') }}" class="btn btn-success" title="Create New Biographyudate1">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('biographyudate1s.biographyudate1.edit', $biographyudate1->id ) }}" class="btn btn-primary" title="Edit Biographyudate1">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Biographyudate1" onclick="return confirm(&quot;Click Ok to delete Biographyudate1.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $biographyudate1->name }}</dd>
            <dt>Age</dt>
            <dd>{{ $biographyudate1->age }}</dd>
            <dt>Biography</dt>
            <dd>{{ $biographyudate1->biography }}</dd>
            <dt>Sport</dt>
            <dd>{{ $biographyudate1->sport }}</dd>
            <dt>Gender</dt>
            <dd>{{ $biographyudate1->gender }}</dd>
            <dt>Colors</dt>
            <dd>{{ $biographyudate1->colors }}</dd>
            <dt>Is Retired</dt>
            <dd>{{ ($biographyudate1->is_retired) ? 'Yes' : 'No' }}</dd>
            <dt>Photo</dt>
            <dd>{{ asset('storage/' . $biographyudate1->photo) }}</dd>
            <dt>Range</dt>
            <dd>{{ $biographyudate1->range }}</dd>
            <dt>Month</dt>
            <dd>{{ $biographyudate1->month }}</dd>

        </dl>

    </div>
</div>

@endsection