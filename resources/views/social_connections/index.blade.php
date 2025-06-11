@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container">
    <h2>Manage Social Connections</h2>

    {{-- Basic styling if no layout/CSS framework is assumed --}}
    <style>
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .list-group { margin-bottom: 1rem; }
        .list-group-item { position: relative; display: block; padding: 0.75rem 1.25rem; background-color: #fff; border: 1px solid rgba(0,0,0,.125); }
        .list-group-item.d-flex { display: flex !important; }
        .justify-content-between { justify-content: space-between !important; }
        .align-items-center { align-items: center !important; }
        .mb-4 { margin-bottom: 1.5rem !important; }
        .text-muted { color: #6c757d !important; }
        .btn { display: inline-block; font-weight: 400; text-align: center; white-space: nowrap; vertical-align: middle; user-select: none; border: 1px solid transparent; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; border-radius: 0.25rem; }
        .btn-danger { color: #fff; background-color: #dc3545; border-color: #dc3545; }
        .btn-sm { padding: 0.25rem 0.5rem; font-size: .875rem; line-height: 1.5; border-radius: 0.2rem; }
        .list-group-item-action { width: 100%; color: #495057; text-align: inherit; }
        .list-group-item-action:hover, .list-group-item-action:focus { z-index: 1; color: #495057; text-decoration: none; background-color: #f8f9fa; }
    </style>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h4>Connected Accounts:</h4>
    @if($connections->isNotEmpty())
        <ul class="list-group mb-4">
            @foreach($connections as $connection)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        {{-- $connection->platform might be an object if cast to Enum, or string if not cast/PHP<8.1 --}}
                        <strong>{{ ucfirst(is_object($connection->platform) ? $connection->platform->value : $connection->platform) }}</strong>
                        <small class="text-muted">(User ID: {{ $connection->platform_user_id }})</small>

                        @if((is_object($connection->platform) ? $connection->platform->value : $connection->platform) === 'facebook' && isset($connection->metadata['page_name']))
                            <br><small>Page: {{ $connection->metadata['page_name'] }} (ID: {{ $connection->metadata['page_id'] ?? 'N/A' }})</small>
                        @endif
                        @if((is_object($connection->platform) ? $connection->platform->value : $connection->platform) === 'facebook' && isset($connection->metadata['group_name']))
                            <br><small>Group: {{ $connection->metadata['group_name'] }} (ID: {{ $connection->metadata['group_id'] ?? 'N/A' }})</small>
                        @endif
                    </div>
                    <form action="{{ route('social_connections.destroy', $connection->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to disconnect this account?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Disconnect</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No social accounts connected yet.</p>
    @endif

    <h4>Available Platforms to Connect:</h4>
    @if(!empty($availablePlatforms))
        <div class="list-group">
            {{-- $platformEnum is an object with a 'value' property from our custom cases() method --}}
            @foreach($availablePlatforms as $platformEnum)
                <a href="{{ route('social.redirect', ['platform' => $platformEnum->value]) }}" class="list-group-item list-group-item-action">
                    Connect {{ ucfirst($platformEnum->value) }}
                </a>
            @endforeach
        </div>
    @else
        <p>All available platforms are connected, or no platforms are configured for connection.</p>
    @endif
</div>
@endsection
