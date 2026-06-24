<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAYA RENTAL - Login</title>
    <style>
        :root {
            --bg-1: #07111f;
            --bg-2: #12306f;
            --panel: rgba(255, 255, 255, 0.08);
            --panel-border: rgba(255, 255, 255, 0.14);
            --text: #f8fbff;
            --muted: rgba(248, 251, 255, 0.76);
            --input-bg: rgba(255, 255, 255, 0.12);
            --primary: #5b8cff;
            --primary-strong: #2f66f2;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; }
        body {
            min-height: 100vh;
            font-family: Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(91, 140, 255, 0.35), transparent 28%),
                radial-gradient(circle at bottom right, rgba(101, 206, 255, 0.18), transparent 30%),
                linear-gradient(135deg, var(--bg-1) 0%, var(--bg-2) 72%);
            display: grid;
            place-items: center;
            padding: 24px;
        }
        .card {
            width: min(430px, 100%);
            background: var(--panel) !important;
            padding: 30px !important;
            border-radius: 28px !important;
            border: 1px solid var(--panel-border) !important;
            box-shadow: 0 24px 70px rgba(0,0,0,0.2) !important;
            box-sizing: border-box !important;
            backdrop-filter: blur(16px);
        }
        .logo-area { text-align: center !important; margin-bottom: 20px !important; }
        .logo-area h2 {
            color: #ffffff;
            margin: 0;
            font-size: clamp(26px, 4vw, 34px);
            letter-spacing: 0.08em;
            font-weight: 800;
        }
        .logo-area small { color: var(--muted); letter-spacing: 0.22em; font-size: 11px; display: block; margin-top: 8px; text-transform: uppercase; font-weight: 700; }
        .tab-container { display: flex !important; gap: 10px !important; margin-bottom: 22px !important; justify-content: center !important; }
        .tab-btn { flex: 1 !important; padding: 10px 15px !important; font-size: 13px !important; font-weight: 700 !important; border: 1px solid transparent !important; border-radius: 14px !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important; gap: 5px !important; text-decoration: none !important; transition: transform 0.2s ease, filter 0.2s ease; }
        .tab-login-active { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-strong) 100%) !important; color: #ffffff !important; box-shadow: 0 12px 24px rgba(47, 102, 242, 0.22); }
        .tab-register-passive { background-color: rgba(255,255,255,0.1) !important; color: #ffffff !important; border-color: rgba(255,255,255,0.14) !important; }
        .tab-btn:hover { transform: translateY(-1px); }
        .form-group { margin-bottom: 15px !important; }
        label { display: block !important; font-size: 13px !important; margin-bottom: 7px !important; color: #ffffff !important; font-weight: 700 !important; }
        input {
            width: 100% !important;
            padding: 12px 13px !important;
            background-color: var(--input-bg) !important;
            border: 1px solid rgba(255,255,255,0.12) !important;
            border-radius: 14px !important;
            color: #ffffff !important;
            box-sizing: border-box !important;
            font-size: 14px !important;
            outline: none;
        }
        input::placeholder { color: rgba(248, 251, 255, 0.55) !important; }
        input:focus { border-color: rgba(91, 140, 255, 0.8) !important; box-shadow: 0 0 0 4px rgba(91, 140, 255, 0.12); }
        .password-container { position: relative !important; display: flex !important; align-items: center !important; }
        .password-container input { padding-right: 42px !important; }
        .toggle-password { position: absolute !important; right: 12px !important; cursor: pointer !important; display: flex !important; align-items: center !important; color: rgba(248, 251, 255, 0.8) !important; }
        .toggle-password svg { width: 20px; height: 20px; }
        .btn-submit {
            width: 100% !important;
            padding: 13px !important;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-strong) 100%) !important;
            color: white !important;
            border: none !important;
            border-radius: 14px !important;
            font-weight: bold !important;
            font-size: 14px !important;
            cursor: pointer !important;
            margin-top: 16px !important;
            box-shadow: 0 14px 28px rgba(47, 102, 242, 0.28);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 18px 36px rgba(47, 102, 242, 0.34); filter: saturate(1.05); }
        .alert-error, .alert-success { padding: 12px 13px !important; border-radius: 14px !important; margin-bottom: 14px !important; font-size: 13px !important; border: 1px solid transparent !important; }
        .alert-error { background: rgba(254, 226, 226, 0.14) !important; color: #fecaca !important; border-color: rgba(248, 113, 113, 0.22) !important; }
        .alert-success { background: rgba(220, 252, 231, 0.12) !important; color: #bbf7d0 !important; border-color: rgba(74, 222, 128, 0.22) !important; }
        @media (max-width: 560px) {
            body { padding: 14px; }
            .card { padding: 22px !important; border-radius: 24px !important; }
            .tab-container { flex-direction: column; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>
    <div class="card">
        <div class="logo-area">
            <h2>JAYA RENTAL</h2>
            <small>YOUR JOURNEY STARTS</small>
        </div>

        <div class="tab-container">
            <a href="{{ route('login') }}" class="tab-btn tab-login-active">Login</a>
            <a href="{{ route('register') }}" class="tab-btn tab-register-passive">Register</a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Masukkan Email Anda" value="{{ old('email') }}">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" required placeholder="Masukkan Password">
                    <span class="toggle-password" onclick="togglePass()">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>
    </div>

    <script>
        const eyeOpenPath = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
        const eyeClosePath = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88" />`;

        function togglePass() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = eyeOpenPath;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = eyeClosePath;
            }
        }
    </script>
</body>
</html>
