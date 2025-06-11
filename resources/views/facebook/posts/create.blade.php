@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container">
    <h2>Create Facebook Post</h2>

    {{-- Basic styling if no layout/CSS framework is assumed --}}
    <style>
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .mb-3 { margin-bottom: 1rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-control { display: block; width: 100%; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; box-sizing: border-box; }
        .form-control.is-invalid { border-color: #dc3545; }
        .invalid-feedback { display: none; width: 100%; margin-top: 0.25rem; font-size: 80%; color: #dc3545; }
        .form-control.is-invalid ~ .invalid-feedback { display: block; }
        .form-check { margin-bottom: 0.5rem; }
        .form-check-input { margin-right: 0.5em; }
        .text-danger { color: #dc3545; }
        .small { font-size: 0.875em; }
        .mt-1 { margin-top: 0.25rem !important; }
        .mt-3 { margin-top: 1rem !important; }
        .btn { display: inline-block; font-weight: 400; text-align: center; white-space: nowrap; vertical-align: middle; user-select: none; border: 1px solid transparent; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; border-radius: 0.25rem; transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
        .btn-primary { color: #fff; background-color: #007bff; border-color: #007bff; }
    </style>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('facebook.post.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="post_content" class="form-label">Post Content</label>
            <textarea class="form-control @error('post_content') is-invalid @enderror" id="post_content" name="post_content" rows="5" required>{{ old('post_content') }}</textarea>
            @error('post_content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($connection && ($connection->page_id || $connection->group_id))
            <p><strong>Post to:</strong></p>
            @if ($connection->page_id && $connection->group_id)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="target_type" id="target_page" value="page" {{ old('target_type', 'page') == 'page' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="target_page">
                        Page: {{ $connection->page_name ?? 'N/A' }} (ID: {{ $connection->page_id }})
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="target_type" id="target_group" value="group" {{ old('target_type') == 'group' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="target_group">
                        Group: {{ $connection->group_name ?? 'N/A' }} (ID: {{ $connection->group_id }})
                    </label>
                </div>
            @elseif ($connection->page_id)
                <p>Page: {{ $connection->page_name ?? 'N/A' }} (ID: {{ $connection->page_id }})</p>
                <input type="hidden" name="target_type" value="page">
            @elseif ($connection->group_id)
                <p>Group: {{ $connection->group_name ?? 'N/A' }} (ID: {{ $connection->group_id }})</p>
                <input type="hidden" name="target_type" value="group">
            @endif
            @error('target_type')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        @else
            <p class="text-danger">No Facebook Page or Group selected/available. Please <a href="{{ route('facebook.select') }}">select one here</a>.</p>
        @endif

        @if ($connection && ($connection->page_id || $connection->group_id))
        <button type="submit" class="btn btn-primary mt-3">Prepare Post (Test)</button>
        @endif
    </form>
</div>
@endsection
