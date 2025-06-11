<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Facebook Page/Group</title>
    {{-- Basic styling for better presentation --}}
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #555; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        select, input[type="text"] { width: 100%; padding: 10px; margin-top: 5px; border-radius: 4px; border: 1px solid #ddd; box-sizing: border-box; }
        button { background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 20px; }
        button:hover { background-color: #0056b3; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .form-group { margin-bottom: 1rem; }
        .current-selection { padding: 10px; background-color: #e9ecef; border-radius: 4px; margin-bottom:20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Select Facebook Page and/or Group</h1>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('facebook.save_selection') }}" method="POST">
            @csrf

            @if($connection->page_id || $connection->group_id)
            <div class="current-selection">
                <h4>Current Selection:</h4>
                @if($connection->page_name)
                    <p><strong>Page:</strong> {{ $connection->page_name }} (ID: {{ $connection->page_id }})</p>
                @endif
                @if($connection->group_name)
                    <p><strong>Group:</strong> {{ $connection->group_name }} (ID: {{ $connection->group_id }})</p>
                @endif
            </div>
            @endif

            <div class="form-group">
                <label for="selected_page_id">Select a Facebook Page (Optional)</label>
                <select name="selected_page_id" id="selected_page_id">
                    <option value="">-- None --</option>
                    @foreach($pages as $page)
                        <option value="{{ $page['id'] }}__SEP__{{ $page['name'] }}" {{ ($connection->page_id ?? old('selected_page_id')) == $page['id'] ? 'selected' : '' }}>
                            {{ $page['name'] }} (ID: {{ $page['id'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="selected_group_id">Select a Facebook Group (Optional)</label>
                <select name="selected_group_id" id="selected_group_id">
                    <option value="">-- None --</option>
                    @foreach($groups as $group)
                        <option value="{{ $group['id'] }}__SEP__{{ $group['name'] }}" {{ ($connection->group_id ?? old('selected_group_id')) == $group['id'] ? 'selected' : '' }}>
                            {{ $group['name'] }} (ID: {{ $group['id'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            <p><small>You can select a Page, a Group, both, or neither (to clear previous selections).</small></p>

            <button type="submit">Save Selection</button>
        </form>
    </div>
</body>
</html>
