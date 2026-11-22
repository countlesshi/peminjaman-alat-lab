<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <h1>Pinjam Alat Lab</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        @error('email')
            <p style="color:red">{{ $message }}</p>
        @enderror

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Masuk</button>
    </form>
</body>
</html>