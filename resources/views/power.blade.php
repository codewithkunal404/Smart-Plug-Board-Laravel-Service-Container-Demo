<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Plug Board Demo</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
        select, button { padding: 8px 15px; font-size: 16px; }
        .message { margin-top: 30px; font-size: 22px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>⚙️ Laravel Smart Plug Board (Service Container)</h1>

    <form method="GET" action="{{ route('power') }}">
        <label for="device">Select a device:</label>
        <select name="device" id="device">
            <option value="fan" {{ request('device') == 'fan' ? 'selected' : '' }}>🌀 Fan</option>
            <option value="light" {{ request('device') == 'light' ? 'selected' : '' }}>💡 Light</option>
            <option value="tv" {{ request('device') == 'tv' ? 'selected' : '' }}>📺 TV</option>
        </select>
        <button type="submit">Turn On</button>
    </form>

    @if(isset($message))
        <div class="message">{{ $message }}</div>
    @endif
</body>
</html>
