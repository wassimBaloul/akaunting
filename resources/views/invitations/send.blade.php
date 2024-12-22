<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Invitation</title>
</head>
<body>
    <h1>Send Invitation</h1>

    <!-- Show Success or Error Messages -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Invitation Form -->
    <form action="{{ route('send.invitation') }}" method="POST">
        @csrf
        <label for="email">Enter Email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send Invitation</button>
    </form>
</body>
</html>
