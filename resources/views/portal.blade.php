<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portal - Student Information System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { 
            display: flex; align-items: center; justify-content: center; height: 100vh; 
            background: url('https://4kwallpapers.com/images/walls/thumbs_3t/25876.jpg') no-repeat center center/cover;
            color: #ffffff; overflow: hidden;
        }

        .glass-container {
            width: 95%; max-width: 1400px; height: 90vh;
            background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 24px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            display: flex; overflow: hidden;
        }

        .sidebar {
            width: 260px; background: rgba(0, 0, 0, 0.2); border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex; flex-direction: column; padding: 30px 20px; gap: 40px;
        }
        
        .brand-header { display: flex; align-items: center; gap: 15px; }
        .logo-circle { 
            width: 45px; height: 45px; background: linear-gradient(135deg, rgba(255,255,255,0.4), rgba(255,255,255,0.1)); 
            border-radius: 50%; border: 1px solid rgba(255,255,255,0.4); display: flex; justify-content: center; align-items: center;
        }
        .logo-circle svg { width: 24px; height: 24px; color: #fff; }
        .brand-name { font-size: 15px; font-weight: 600; line-height: 1.2; }

        .nav-menu { display: flex; flex-direction: column; gap: 10px; }
        .nav-btn { 
            display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 12px; 
            color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 500; text-decoration: none; border: 1px solid transparent;
        }
        .nav-btn svg { width: 20px; height: 20px; }
        .nav-btn.active { background: rgba(255,255,255,0.1); color: #ffffff; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        .sidebar-footer { margin-top: auto; }
        .logout-btn { width: 100%; text-align: left; background: transparent; border: none; cursor: pointer; font-family: 'Inter', sans-serif;}
        .logout-btn:hover { color: #ff4757 !important; background: rgba(255, 71, 87, 0.1) !important; border-radius: 12px; }

        .main-content { flex-grow: 1; padding: 60px; display: flex; flex-direction: column; overflow-y: auto; align-items: center; justify-content: center; }
        
        .header-titles { text-align: center; margin-bottom: 40px; }
        .header-titles h1 { font-size: 36px; font-weight: 600; letter-spacing: -0.5px; }

        /* The Digital ID Card */
        .id-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 24px;
            padding: 50px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
        }

        .id-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 10px; height: 100%; background: #6c5ce7;
        }

        .data-group { margin-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;}
        .data-label { font-size: 12px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .data-value { font-size: 22px; font-weight: 500; color: #ffffff; }
        
        .flex-row { display: flex; gap: 40px; }
        .flex-row .data-group { flex: 1; }
        
        .status-badge {
            position: absolute; top: 40px; right: 40px;
            background: rgba(46, 204, 113, 0.2); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.4);
            padding: 8px 16px; border-radius: 50px; font-size: 12px; font-weight: 600; letter-spacing: 1px;
        }

    </style>
</head>
<body>

    <div class="glass-container">
        
        <div class="sidebar">
            <div class="brand-header">
                <div class="logo-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                </div>
                <div class="brand-name">Student<br>Portal</div>
            </div>

            <div class="nav-menu">
                <div class="nav-btn active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    My Profile
                </div>
            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-btn logout-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <div class="main-content">
            <div class="header-titles">
                <h1>Welcome, {{ $student->first_name }}!</h1>
            </div>

            <div class="id-card">
                <div class="status-badge">ENROLLED</div>

                <div class="data-group">
                    <div class="data-label">Official Student ID</div>
                    <div class="data-value" style="font-size: 32px; font-weight: 700; color: #a29bfe;">{{ $student->student_id }}</div>
                </div>

                <div class="data-group">
                    <div class="data-label">Full Legal Name</div>
                    <div class="data-value">{{ $student->first_name }} {{ $student->last_name }}</div>
                </div>

                <div class="flex-row">
                    <div class="data-group">
                        <div class="data-label">Degree Program</div>
                        <div class="data-value">{{ $student->course }}</div>
                    </div>
                    
                    <div class="data-group">
                        <div class="data-label">Gender</div>
                        <div class="data-value">{{ $student->gender }}</div>
                    </div>

                    <div class="data-group">
                        <div class="data-label">Age</div>
                        <div class="data-value">{{ $student->age }}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>