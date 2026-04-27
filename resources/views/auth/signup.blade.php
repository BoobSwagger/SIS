<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation - SIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reusing the exact same styling from login for consistency */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background: url('https://4kwallpapers.com/images/walls/thumbs_3t/25876.jpg') no-repeat center center/cover; color: #ffffff; }
        .login-card { background: rgba(20, 20, 30, 0.6); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 50px 40px; width: 100%; max-width: 400px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5); text-align: center; }
        .logo-circle { width: 60px; height: 60px; background: linear-gradient(135deg, rgba(255,255,255,0.4), rgba(255,255,255,0.1)); border-radius: 50%; border: 1px solid rgba(255,255,255,0.4); display: flex; justify-content: center; align-items: center; margin: 0 auto 20px; }
        .logo-circle svg { width: 30px; height: 30px; color: #fff; }
        h1 { font-size: 24px; font-weight: 600; margin-bottom: 5px; }
        p.subtitle { font-size: 14px; color: rgba(255,255,255,0.6); margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 12px; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input { width: 100%; padding: 14px 15px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-size: 14px; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: rgba(255,255,255,0.5); background: rgba(0,0,0,0.5); }
        .btn-submit { width: 100%; background: #ffffff; color: #1a1a2e; padding: 14px; border: none; border-radius: 12px; font-weight: 600; font-size: 15px; cursor: pointer; transition: 0.2s; margin-top: 10px; }
        .btn-submit:hover { background: rgba(255,255,255,0.8); transform: translateY(-2px); }
        .error-box { background: rgba(255, 71, 87, 0.1); border: 1px solid rgba(255, 71, 87, 0.4); color: #ff4757; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: left;}
        .auth-link { margin-top: 25px; font-size: 13px; color: rgba(255,255,255,0.6); }
        .auth-link a { color: #ffffff; text-decoration: none; font-weight: 500; transition: 0.2s; }
        .auth-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-circle">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </div>
        <h1>Account Activation</h1>
        <p class="subtitle">Enter your assigned Student ID to register</p>

        @if($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/signup">
            @csrf
            <div class="form-group">
                <label>Official Student ID</label>
                <input type="text" name="student_id" required placeholder="e.g. 20260001">
            </div>
            <div class="form-group">
                <label>Create Password</label>
                <input type="password" name="password" required placeholder="Min. 6 characters">
            </div>
            <button type="submit" class="btn-submit">Activate Account</button>
        </form>

        <div class="auth-link">
            Already activated? <a href="/login">Sign in here</a>
        </div>
    </div>
</body>
</html>