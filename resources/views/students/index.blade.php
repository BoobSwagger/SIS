<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body { 
            background: url('https://4kwallpapers.com/images/walls/thumbs_3t/25876.jpg') no-repeat center center/cover;
            color: #ffffff; height: 100vh; overflow: hidden; padding: 40px 50px; 
        }

        .app-container { display: flex; flex-direction: column; gap: 25px; height: 100%; max-width: 1600px; margin: 0 auto; }

        .glass {
            background: rgba(20, 20, 30, 0.55); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 20px; 
        }

        /* --- TOP BAR --- */
        .topbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 35px; height: 80px; flex-shrink: 0; position: relative; z-index: 50;}
        .topbar-left { display: flex; align-items: center; gap: 40px; }
        
        .logo { display: flex; align-items: center; gap: 10px; font-size: 24px; font-weight: 800; letter-spacing: 2px; color: #ffffff; }
        .logo-icon { 
            width: 40px; height: 40px; background: linear-gradient(135deg, #a29bfe, #6c5ce7);
            border-radius: 12px; display: flex; justify-content: center; align-items: center;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }

        .welcome-text h2 { font-size: 16px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;}
        .welcome-text .datetime { font-size: 13px; color: rgba(255,255,255,0.6); }

        .topbar-right { display: flex; align-items: center; gap: 15px; }
        .header-box { 
            width: 45px; height: 45px; border: 1px solid rgba(255,255,255,0.2); border-radius: 12px;
            display: flex; justify-content: center; align-items: center; background: rgba(255,255,255,0.05); transition: 0.2s; cursor: pointer; position: relative;
        }
        .header-box svg { width: 20px; height: 20px; color: rgba(255,255,255,0.8); }
        .header-box:hover { background: rgba(255,255,255,0.1); transform: translateY(-2px); }
        
        .badge { position: absolute; top: -5px; right: -5px; background: #ff4757; color: white; font-size: 10px; font-weight: bold; width: 18px; height: 18px; border-radius: 50%; display: flex; justify-content: center; align-items: center; border: 2px solid #1a1a2e; }

        .logout-btn { background: transparent; border: none; cursor: pointer; }
        .logout-btn .header-box:hover { background: rgba(255, 71, 87, 0.2); border-color: rgba(255, 71, 87, 0.5); color: #ff4757; }
        .logout-btn .header-box:hover svg { color: #ff4757; }

        .profile-img-preview { width: 100%; height: 100%; border-radius: 10px; object-fit: cover; }

        /* --- DROPDOWN PANEL STYLES --- */
        .dropdown-wrapper { position: relative; }
        .dropdown-panel {
            position: absolute; top: 60px; right: 0; width: 320px;
            background: rgba(25, 25, 35, 0.95); backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.6); z-index: 1000;
            opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .dropdown-panel.active { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-header { padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .dropdown-header h3 { font-size: 14px; font-weight: 600; }
        .dropdown-body { max-height: 320px; overflow-y: auto; }
        .dropdown-body::-webkit-scrollbar { width: 4px; }
        .dropdown-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

        .notif-item { padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: flex-start; gap: 15px; transition: background 0.2s; cursor: pointer; }
        .notif-item:hover { background: rgba(255,255,255,0.03); }
        .notif-item:last-child { border-bottom: none; }
        .notif-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; justify-content: center; align-items: center; flex-shrink: 0; }
        .notif-icon.success { background: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .notif-icon.update { background: rgba(52, 152, 219, 0.2); color: #3498db; }
        .notif-text { font-size: 12px; line-height: 1.4; color: rgba(255,255,255,0.9); }
        .notif-time { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 5px; }

        /* --- MAIN DASHBOARD GRID --- */
        .dashboard-grid { display: grid; grid-template-columns: 2.8fr 1fr; gap: 25px; flex: 1; overflow: hidden; }

        /* Left Side: Student's Data */
        .list-view { padding: 35px; display: flex; flex-direction: column; overflow: hidden; }
        .list-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .list-title { font-size: 18px; font-weight: 600; color: #ffffff; letter-spacing: 1px; display: flex; align-items: center; gap: 10px;}
        
        .btn-add { background: #a29bfe; color: #ffffff; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 13px; border: none; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 8px; }
        .btn-add:hover { background: #8c82fc; transform: translateY(-2px); }

        .toolbar { display: flex; gap: 15px; margin-bottom: 20px; }
        .search-bar { flex: 1; display: flex; align-items: center; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 0 15px; }
        .search-bar input { background: transparent; border: none; color: white; padding: 12px; width: 100%; outline: none; }
        .filter-box { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 12px 15px; border-radius: 10px; outline: none; cursor: pointer; }
        .filter-box option { background: #1a1a2e; }

        .table-container { flex: 1; overflow-y: auto; padding-right: 15px; }
        .table-container::-webkit-scrollbar { width: 6px; }
        .table-container::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead th { position: sticky; top: 0; background: rgba(25, 25, 35, 0.95); backdrop-filter: blur(10px); padding: 15px; font-size: 11px; text-transform: uppercase; color: rgba(255,255,255,0.5); border-bottom: 2px solid rgba(255,255,255,0.1); font-weight: 600; letter-spacing: 0.5px; z-index: 10; }
        td { padding: 15px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tr:hover td { background: rgba(255,255,255,0.04); }

        .status-active { background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;}
        .status-pending { background: rgba(241, 196, 15, 0.2); color: #f1c40f; padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;}
        
        .action-btns { display: flex; gap: 8px; }
        .btn-edit, .btn-delete { padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 500; border: none; cursor: pointer; transition: 0.2s;}
        .btn-edit { background: rgba(255, 255, 255, 0.1); color: white; }
        .btn-delete { background: rgba(255, 71, 87, 0.15); color: #ff4757; }
        .btn-delete:hover { background: #ff4757; color: white; }

        /* --- Right Side: Stats Panel --- */
        .stats-panel { display: flex; flex-direction: column; gap: 20px; overflow-y: auto; padding-right: 5px;}
        .stats-panel::-webkit-scrollbar { width: 4px; }
        .stat-card { padding: 25px; display: flex; flex-direction: column; justify-content: center; text-align: center; }
        .stat-value { font-size: 42px; font-weight: 700; background: linear-gradient(135deg, #fff, #a29bfe); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1;}
        .stat-label { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.5); margin-top: 10px; text-transform: uppercase; letter-spacing: 1px; }

        .stat-split { display: flex; gap: 20px; justify-content: space-around; margin-top: 10px;}
        .stat-split-item { display: flex; flex-direction: column; align-items: center;}
        .stat-split-val { font-size: 24px; font-weight: 700; color: white;}

        .chart-container { position: relative; height: 180px; width: 100%; display: flex; justify-content: center; margin-top: 15px;}
        .pie-cards-wrapper { display: flex; gap: 20px; width: 100%; }
        .pie-card { flex: 1; padding: 15px; display: flex; flex-direction: column; align-items: center; }
        .pie-chart-container { position: relative; height: 120px; width: 100%; display: flex; justify-content: center; margin-top: 10px; }

        /* --- MODAL STYLES (UPDATED FOR SILKY SMOOTH TRANSITIONS) --- */
        .modal-overlay { 
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; 
            background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(5px); 
            z-index: 9999; /* Max Z-index so it covers everything */
            display: flex; justify-content: center; align-items: center; 
            opacity: 0; visibility: hidden; transition: all 0.3s ease; 
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-content { 
            background: rgba(20, 20, 30, 0.95); border: 1px solid rgba(255, 255, 255, 0.15); 
            border-radius: 20px; width: 100%; max-width: 500px; padding: 30px; 
            transform: translateY(20px); transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); 
        }
        .modal-overlay.active .modal-content { transform: translateY(0); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;}
        .close-modal { background: none; border: none; color: white; font-size: 24px; cursor: pointer; transition: 0.2s; }
        .close-modal:hover { color: #ff4757; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 12px; color: rgba(255,255,255,0.6); margin-bottom: 5px; text-transform: uppercase; }
        .form-control { width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white; outline: none; transition: 0.3s; }
        .form-control:focus { border-color: #a29bfe; }
        .radio-group { display: flex; gap: 20px; align-items: center; padding: 10px 0;}
        .radio-item { display: flex; align-items: center; gap: 5px; font-size: 14px; cursor: pointer;}
    </style>
</head>
<body>

    <div class="app-container">
        <header class="glass topbar">
            <div class="topbar-left">
                <div class="logo">
                    <div class="logo-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" style="width: 22px; height: 22px;">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                    </div>
                    SIS
                </div>
                <div class="welcome-text">
                    <h2 id="welcomeAdminText">WELCOME {{ strtoupper(auth()->user()->name ?? 'ADMIN') }}</h2>
                    <div class="datetime" id="live-clock">Loading Time...</div>
                </div>
            </div>
            
            <div class="topbar-right">
                
                @php
    // Fetch live data directly in the view
    $unreadCount = \App\Models\SystemNotification::where('is_read', false)->count();
    $notifications = \App\Models\SystemNotification::latest()->take(10)->get();
@endphp

<div class="dropdown-wrapper">
    <div class="header-box" onclick="toggleDropdown('notifDropdown')" title="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        <div class="badge" style="display: {{ $unreadCount > 0 ? 'flex' : 'none' }}">{{ $unreadCount }}</div>
    </div>
    <div class="dropdown-panel" id="notifDropdown">
        <div class="dropdown-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h3>Activity Notifications</h3>
    
    @if($notifications->count() > 0)
        <form action="{{ route('admin.notifications.clear') }}" method="POST" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: transparent; border: none; color: #ff4757; font-size: 11px; font-weight: 600; cursor: pointer; text-decoration: underline;">
                Clear All
            </button>
        </form>
    @endif
</div>
        <div class="dropdown-body">
            
            @forelse($notifications as $notif)
                <div class="notif-item">
                    @if($notif->type === 'activation')
                        <div class="notif-icon success"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px;"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                    @elseif($notif->type === 'update')
                        <div class="notif-icon update"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px;"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></div>
                    @else
                        <div class="notif-icon" style="background: rgba(162, 155, 254, 0.2); color: #a29bfe;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px;"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg></div>
                    @endif

                    <div>
                        <div class="notif-text">{!! $notif->message !!}</div>
                        <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div style="padding: 20px; text-align: center; color: rgba(255,255,255,0.5); font-size: 12px;">No recent activity.</div>
            @endforelse

        </div>
    </div>
</div>

                <div class="header-box" onclick="openModal('settingsModal')" title="System Settings">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                </div>

                <div class="header-box" onclick="openModal('profileModal')" title="Admin Profile" id="profileBtn">
                    @if(auth()->check() && auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="profile-img-preview">
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    @endif
                </div>

                <form method="POST" action="{{ route('logout') }}" class="logout-btn">
                    @csrf
                    <button type="submit" class="header-box logout-btn" title="Log Out">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    </button>
                </form>
            </div>
        </header>

        <main class="dashboard-grid">
            
            <section class="glass list-view">
                <div class="list-header-row">
                    <div class="list-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#a29bfe" stroke-width="2" style="width: 20px; height: 20px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        STUDENT'S DATA
                    </div>
                    <button class="btn-add" onclick="openModal('studentModal')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Add Student
                    </button>
                </div>

                <div class="toolbar">
                    <div class="search-bar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2" style="width: 18px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" id="searchInput" placeholder="Search by ID, Name..." onkeyup="filterTable()">
                    </div>
                    <select class="filter-box" id="courseFilter" onchange="filterTable()">
                        <option value="all">All Courses</option>
                        <option value="BSIT">BSIT</option>
                        <option value="BSCS">BSCS</option>
                        <option value="BLIS">BLIS</option>
                        <option value="BSIS">BSIS</option>
                        <option value="MIS">MIS</option>
                    </select>
                    <select class="filter-box" id="statusFilter" onchange="filterTable()">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                
                <div class="table-container">
                    <table id="studentsTable">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr class="student-row">
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->last_name }}, {{ $student->first_name }}</td>
                                <td class="course-col">{{ $student->course }}</td>
                                <td class="status-col">
                                    @if(App\Models\User::where('username', $student->student_id)->exists())
                                        <span class="status-active">Active</span>
                                    @else
                                        <span class="status-pending">Pending</span>
                                    @endif
                                </td>
                                <td style="color: rgba(255,255,255,0.5);">
                                    {{ $student->account && $student->account->last_login_at ? $student->account->last_login_at->diffForHumans() : 'Never' }}
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-edit" onclick="openModal('studentModal')">Edit</button>
                                        <form action="/students/{{ $student->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you absolutely sure you want to delete this student record? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="stats-panel">
                <div class="glass stat-card" style="padding: 20px;">
                    <div class="stat-label" style="margin-bottom: 5px;">Total Students Enrolled</div>
                    <div class="stat-value">{{ $students->count() }}</div>
                </div>
                <div class="glass stat-card" style="padding: 20px;">
                    <div class="stat-label">Course Enrollment</div>
                    <div class="chart-container"><canvas id="courseChart"></canvas></div>
                </div>
                <div class="glass stat-card" style="padding: 20px;">
                    <div class="stat-label">Account Status</div>
                    <div class="stat-split">
                        <div class="stat-split-item">
                            <div class="stat-split-val" style="color: #2ecc71;">{{ App\Models\User::whereIn('username', $students->pluck('student_id'))->count() }}</div>
                            <div class="stat-label" style="font-size: 10px;">Active</div>
                        </div>
                        <div class="stat-split-item">
                            <div class="stat-split-val" style="color: #f1c40f;">{{ $students->count() - App\Models\User::whereIn('username', $students->pluck('student_id'))->count() }}</div>
                            <div class="stat-label" style="font-size: 10px;">Pending</div>
                        </div>
                    </div>
                </div>
                <div class="pie-cards-wrapper">
                    <div class="glass pie-card">
                        <div class="stat-label" style="font-size: 10px; margin-top: 0;">Gender</div>
                        <div class="pie-chart-container"><canvas id="genderChart"></canvas></div>
                    </div>
                    <div class="glass pie-card">
                        <div class="stat-label" style="font-size: 10px; margin-top: 0;">Age Spread</div>
                        <div class="pie-chart-container"><canvas id="ageChart"></canvas></div>
                    </div>
                </div>
            </aside>
        </main>
    </div> <div class="modal-overlay" id="studentModal">
        <div class="modal-content glass">
            <div class="modal-header">
                <h3 style="font-weight: 600;">Student Form</h3>
                <button class="close-modal" onclick="closeModal('studentModal')">&times;</button>
            </div>
            <form action="/students" method="POST">
                @csrf
                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;"><label>First Name</label><input type="text" name="first_name" class="form-control" required></div>
                    <div class="form-group" style="flex: 1;"><label>Last Name</label><input type="text" name="last_name" class="form-control" required></div>
                </div>
                <div class="form-group">
                    <label>CCS Course</label>
                    <select name="course" class="form-control" required>
                        <option value="" disabled selected>Select a program</option>
                        <option value="BSIT">BSIT - Information Technology</option>
                        <option value="BSCS">BSCS - Computer Science</option>
                        <option value="BLIS">BLIS - Library & Info Science</option>
                        <option value="BSIS">BSIS - Information Systems</option>
                        <option value="MIS">MIS - Management Info Systems</option>
                    </select>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <div class="form-group" style="flex: 1;"><label>Age</label><input type="number" name="age" class="form-control" required min="16"></div>
                    <div class="form-group" style="flex: 2;">
                        <label>Gender</label>
                        <div class="radio-group">
                            <label class="radio-item"><input type="radio" name="gender" value="Male" required> Male</label>
                            <label class="radio-item"><input type="radio" name="gender" value="Female"> Female</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-add" style="width: 100%; justify-content: center; margin-top: 10px; padding: 15px;">Save Record</button>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="settingsModal">
        <div class="modal-content glass" style="max-width: 400px;">
            <div class="modal-header">
                <h3 style="font-weight: 600; font-size: 16px; color: #ff4757;">Danger Zone</h3>
                <button class="close-modal" onclick="closeModal('settingsModal')">&times;</button>
            </div>
            <p style="font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 20px;">Wiping the database will delete all student records and deactivate their portal access permanently.</p>
            <form action="{{ route('admin.database.wipe') ?? '#' }}" method="POST" onsubmit="return confirm('FINAL WARNING: This will permanently destroy all records in the database. Proceed?');">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <label>Admin Password Required</label>
                    <input type="password" name="admin_password" class="form-control" placeholder="Enter password to confirm" required>
                </div>
                <button type="submit" class="btn-add" style="width: 100%; justify-content: center; background: #ff4757; color: white;">Delete All Students Data</button>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="profileModal">
        <div class="modal-content glass" style="max-width: 400px;">
            <div class="modal-header">
                <h3 style="font-weight: 600; font-size: 16px;">Admin Profile</h3>
                <button class="close-modal" onclick="closeModal('profileModal')">&times;</button>
            </div>
            <form action="{{ route('admin.profile.update') ?? '#' }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; border: 2px dashed rgba(255,255,255,0.3); display: flex; justify-content: center; align-items: center; cursor: pointer; position: relative; overflow: hidden;" onclick="document.getElementById('fileUpload').click()">
                        <img id="modalProfileImg" src="{{ auth()->check() && auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : '' }}" style="display: {{ auth()->check() && auth()->user()->profile_photo ? 'block' : 'none' }}; width: 100%; height: 100%; object-fit: cover; position: absolute; top:0; left:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" style="width: 24px; position: relative; z-index: -1;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <input type="file" name="profile_photo" id="fileUpload" style="display: none;" accept="image/*" onchange="previewProfileImage(event)">
                </div>
                <div class="form-group">
                    <label>Display Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name ?? 'Admin' }}" required>
                </div>
                <div class="form-group">
                    <label>Admin Email / Username</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->username ?? 'admin' }}" disabled>
                </div>
                <button type="submit" class="btn-add" style="width: 100%; justify-content: center; margin-top: 10px;">Update Profile</button>
            </form>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('live-clock').textContent = now.toLocaleDateString('en-US', options);
        }
        setInterval(updateClock, 1000); updateClock(); 

        function filterTable() {
            let search = document.getElementById('searchInput').value.toLowerCase();
            let courseFilter = document.getElementById('courseFilter').value.toLowerCase();
            let statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            let rows = document.querySelectorAll('.student-row');

            rows.forEach(row => {
                let idText = row.children[0].innerText.toLowerCase();
                let nameText = row.children[1].innerText.toLowerCase();
                let course = row.querySelector('.course-col').innerText.toLowerCase();
                let status = row.querySelector('.status-col').innerText.toLowerCase().trim();

                let matchesSearch = idText.includes(search) || nameText.includes(search);
                let matchesCourse = courseFilter === 'all' || course === courseFilter;
                let matchesStatus = statusFilter === 'all' || status === statusFilter;

                row.style.display = (matchesSearch && matchesCourse && matchesStatus) ? '' : 'none';
            });
        }

        function toggleDropdown(id) { document.getElementById(id).classList.toggle('active'); }
        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
        
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) { event.target.classList.remove('active'); }
            if (!event.target.closest('.dropdown-wrapper')) {
                document.querySelectorAll('.dropdown-panel').forEach(dd => dd.classList.remove('active'));
            }
        }

        function previewProfileImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const modalImg = document.getElementById('modalProfileImg');
                modalImg.src = reader.result;
                modalImg.style.display = 'block';
            }
            if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
        }

        Chart.defaults.color = 'rgba(255, 255, 255, 0.6)'; Chart.defaults.font.family = 'Inter';
        const courseLabels = {!! json_encode($students->groupBy('course')->keys()) !!};
        const courseData = {!! json_encode($students->groupBy('course')->map->count()->values()) !!};
        new Chart(document.getElementById('courseChart'), { type: 'bar', data: { labels: courseLabels, datasets: [{ label: 'Enrolled', data: courseData, backgroundColor: '#a29bfe', borderRadius: 5 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { stepSize: 1 } }, x: { grid: { display: false } } } } });

        new Chart(document.getElementById('genderChart'), { type: 'doughnut', data: { labels: ['Male', 'Female'], datasets: [{ data: [ {{ $students->where('gender', 'Male')->count() }}, {{ $students->where('gender', 'Female')->count() }} ], backgroundColor: ['#74b9ff', '#ff7675'], borderWidth: 0, hoverOffset: 4 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, cutout: '70%' } });

        const ageLabels = {!! json_encode($students->groupBy('age')->keys()) !!};
        const ageData = {!! json_encode($students->groupBy('age')->map->count()->values()) !!};
        new Chart(document.getElementById('ageChart'), { type: 'pie', data: { labels: ageLabels.map(age => age + ' yrs'), datasets: [{ data: ageData, backgroundColor: ['#a29bfe', '#00b894', '#fdcb6e', '#e17055', '#6c5ce7'], borderWidth: 0 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } } });
    </script>
</body>
</html>