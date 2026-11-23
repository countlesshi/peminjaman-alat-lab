<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body>
<div class="auth">
    <section class="auth-hero">
        @include('partials.brand')

        <div>
            <h1>Pinjam alat lab, tanpa tabrakan jadwal.</h1>
            <p class="lead">Pilih alat, tentukan jam, dan sistem langsung mengecek apakah slot itu masih kosong.</p>
        </div>

        <div class="demo" aria-hidden="true">
            <div class="demo-head"><span>Laptop #01</span><span>KOM-001 · Senin</span></div>
            <div class="demo-bar">
                <div class="demo-slot demo-a">Budi · 09–12</div>
                <div class="demo-slot demo-b">Sari · 12–14</div>
                <div class="demo-free">Kosong</div>
            </div>
            <div class="demo-hours"><span>08:00</span><span>10:00</span><span>12:00</span><span>14:00</span><span>16:00</span></div>
            <p class="demo-note">Sari mulai tepat saat Budi selesai, jadi pesanannya diterima.</p>
        </div>
    </section>

    <section class="auth-form-wrap">
        <form class="auth-form" method="POST" action="{{ route('login') }}" data-once>
            @csrf

            <div>
                <h2>Masuk</h2>
                <p class="muted" style="margin-top: 6px">Gunakan akun yang diberikan petugas lab.</p>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="input @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus autocomplete="username"
                       @error('email') aria-describedby="email-error" aria-invalid="true" @enderror>
                @error('email')
                    <span id="email-error" class="field-error" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="input" required autocomplete="current-password">
            </div>

            <div class="check">
                <input id="remember" name="remember" type="checkbox" value="1">
                <label for="remember">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="min-height: 48px; font-size: 16px">Masuk</button>

            @if (app()->environment('local'))
                <div class="demo-accounts">
                    <strong>Akun demo (hanya tampil di lokal)</strong><br>
                    <span>admin@lab.test</span><br>
                    <span>mahasiswa@lab.test</span>
                </div>
            @endif
        </form>
    </section>
</div>
</body>
</html>
