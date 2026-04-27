<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Base Reset & Background */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { 
            display: flex; align-items: center; justify-content: center; height: 100vh; 
            background: url('https://4kwallpapers.com/images/walls/thumbs_3t/25876.jpg') no-repeat center center/cover;
            color: #ffffff; overflow: hidden;
        }

        /* The Main Glass Container */
        .glass-container {
            width: 95%; max-width: 1400px; height: 90vh;
            background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 24px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            display: flex; overflow: hidden;
        }

        /* Sidebar */
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
            display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 12px; cursor: pointer; color: rgba(255,255,255,0.6); 
            font-size: 14px; font-weight: 500; transition: 0.3s; text-decoration: none; border: 1px solid transparent;
        }
        .nav-btn svg { width: 20px; height: 20px; }
        .nav-btn:hover { color: #fff; background: rgba(255,255,255,0.05); }
        .nav-btn.active { background: rgba(255,255,255,0.1); color: #ffffff; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        /* Logout Button Styling */
        .sidebar-footer { margin-top: auto; } /* This pushes the button to the very bottom */
        .logout-btn { width: 100%; text-align: left; background: transparent; border: none; font-family: 'Inter', sans-serif; }
        .logout-btn:hover { color: #ff4757 !important; background: rgba(255, 71, 87, 0.1) !important; }

        /* Main Content */
        .main-content { flex-grow: 1; padding: 40px; display: flex; flex-direction: column; overflow: hidden; }
        
        .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header-titles p { font-size: 14px; font-weight: 300; opacity: 0.7; letter-spacing: 1px; margin-bottom: 5px; text-transform: uppercase; }
        .header-titles h1 { font-size: 32px; font-weight: 600; }
        .add-btn { background: #ffffff; color: #1a1a2e; border: none; padding: 10px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 15px rgba(255,255,255,0.2); }
        .add-btn:hover { background: rgba(255,255,255,0.9); transform: translateY(-2px); }

        /* Grid Layout */
        .dashboard-layout { display: flex; gap: 30px; height: calc(100% - 80px); }
        
        /* Table Area with Inline Filters */
        .table-wrapper { flex: 2; background: rgba(0, 0, 0, 0.2); border-radius: 20px; padding: 25px; border: 1px solid rgba(255, 255, 255, 0.05); overflow-y: auto; display: flex; flex-direction: column; }
        
        .inline-filters { display: flex; gap: 15px; margin-bottom: 20px; background: rgba(255,255,255,0.02); padding: 15px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); }
        .filter-input { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white; padding: 8px 15px; font-size: 13px; outline: none; transition: 0.3s; cursor: pointer;}
        .filter-input:focus { border-color: rgba(255,255,255,0.4); }
        .filter-input option { background: #1a1a2e; color: white; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px 10px; font-size: 12px; text-transform: uppercase; color: rgba(255,255,255,0.5); font-weight: 500; border-bottom: 1px solid rgba(255,255,255,0.1); }
        td { padding: 18px 10px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 14px; font-weight: 300; }
        tr:hover td { background: rgba(255,255,255,0.03); }

        /* Analytics Panel */
        .analytics-panel { flex: 1; max-width: 320px; display: flex; flex-direction: column; gap: 20px; overflow-y: auto; padding-right: 10px; }
        .glass-card { background: rgba(0, 0, 0, 0.2); border-radius: 20px; padding: 25px; border: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card h3 { font-size: 13px; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 15px; font-weight: 500; }
        .stat-huge { font-size: 48px; font-weight: 300; line-height: 1; margin-bottom: 5px; }
        .chart-container { position: relative; height: 180px; width: 100%; }

        /* Buttons */
        .action-btns { display: flex; gap: 8px; }
        .btn-glass { background: rgba(255, 255, 255, 0.1); color: #fff; border: 1px solid rgba(255, 255, 255, 0.2); padding: 6px 12px; border-radius: 8px; font-size: 12px; cursor: pointer; transition: 0.3s; }
        .btn-glass:hover { background: rgba(255, 255, 255, 0.2); }
        .btn-danger { background: rgba(255, 59, 48, 0.2); border-color: rgba(255, 59, 48, 0.3); }
        .btn-danger:hover { background: rgba(255, 59, 48, 0.4); }

        /* Modals */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(10px); align-items: center; justify-content: center; }
        .modal-content { background: rgba(20, 20, 30, 0.85); border: 1px solid rgba(255, 255, 255, 0.1); padding: 40px; border-radius: 24px; width: 100%; max-width: 400px; box-shadow: 0 25px 50px rgba(0,0,0,0.5); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .modal-header h2 { font-size: 20px; font-weight: 500; }
        .close-btn { color: rgba(255,255,255,0.5); font-size: 24px; cursor: pointer; background: none; border: none; transition: 0.2s; }
        .close-btn:hover { color: white; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; }
        .form-group input, .form-group select { width: 100%; padding: 12px 15px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-size: 14px; outline: none; transition: 0.3s; }
        .form-group select option { background: #1a1a2e; color: white; }
        .form-group input:focus, .form-group select:focus { border-color: rgba(255,255,255,0.5); }
        .btn-submit { width: 100%; background: #ffffff; color: #1a1a2e; padding: 14px; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; transition: 0.2s; }
    </style>
</head>
<body>

    <div class="glass-container">
        <div class="sidebar">
            <div class="brand-header">
                <div class="logo-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                </div>
                <div class="brand-name">Student<br>Information<br>System</div>
            </div>

            <div class="nav-menu">
                <a href="#" class="nav-btn active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Dashboard
                </a>
                <a href="#" class="nav-btn" onclick="openSettingsModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    System Settings
                </a>
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
            <div class="top-header">
                <div class="header-titles">
                    <p id="live-time">Loading date...</p>
                    <h1>Welcome, Admin!</h1>
                </div>
                <button class="add-btn" onclick="openAddModal()">↑ Add New Student</button>
            </div>

            <div class="dashboard-layout">
                <div class="table-wrapper">
                    
                    <div class="inline-filters">
                        <input type="text" id="filterSearch" class="filter-input" style="flex: 2;" onkeyup="updateTable()" placeholder="Search names or courses...">
                        
                        <select id="filterGender" class="filter-input" style="flex: 1;" onchange="updateTable()">
                            <option value="none">Filter: All Genders</option>
                            <option value="Male">Male Only</option>
                            <option value="Female">Female Only</option>
                            <option value="Other">Other</option>
                        </select>

                        <select id="sortTable" class="filter-input" style="flex: 1;" onchange="updateTable()">
                            <option value="none">Sort: Default</option>
                            <option value="fname">First Name (A-Z)</option>
                            <option value="lname">Last Name (A-Z)</option>
                            <option value="ageAsc">Age (Youngest First)</option>
                            <option value="ageDesc">Age (Oldest First)</option>
                        </select>
                    </div>

                    <table id="studentTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Age</th>
                                <th>Course</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr class="student-row">
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->first_name }}</td>
                                <td>{{ $student->last_name }}</td>
                                <td>{{ $student->age }}</td>
                                <td><strong>{{ $student->course }}</strong></td>
                                <td>{{ $student->gender }}</td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-glass" 
                                            data-id="{{ $student->id }}" data-fname="{{ $student->first_name }}"
                                            data-lname="{{ $student->last_name }}" data-age="{{ $student->age }}"
                                            data-course="{{ $student->course }}" data-gender="{{ $student->gender }}"
                                            onclick="openEditModal(this)">Edit</button>
                                        <form action="/students/{{ $student->id }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-glass btn-danger" onclick="return confirm('Delete this record?')">Drop</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="analytics-panel">
                    <div class="glass-card">
                        <h3>Total Enrolled</h3>
                        <div class="stat-huge">{{ $students->count() }}</div>
                    </div>
                    <div class="glass-card">
                        <h3>Age Distribution</h3>
                        <div class="chart-container"><canvas id="ageChart"></canvas></div>
                    </div>
                    <div class="glass-card">
                        <h3>Gender Diversity</h3>
                        <div class="chart-container"><canvas id="genderChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h2>Add Student</h2><button class="close-btn" onclick="closeAddModal()">×</button></div>
            <form method="POST" action="/students">
                @csrf
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex:1;"><label>First Name</label><input type="text" name="first_name" required></div>
                    <div class="form-group" style="flex:1;"><label>Last Name</label><input type="text" name="last_name" required></div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex:1;"><label>Age</label><input type="number" name="age" required></div>
                    <div class="form-group" style="flex:1;"><label>Gender</label>
                        <select name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-group"><label>Course</label><input type="text" name="course" required></div>
                <button type="submit" class="btn-submit">Save Record</button>
            </form>
        </div>
    </div>

    <div id="editStudentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h2>Edit Record</h2><button class="close-btn" onclick="closeEditModal()">×</button></div>
            <form id="editForm" method="POST" action="">
                @csrf @method('PUT')
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex:1;"><label>First Name</label><input type="text" name="first_name" id="edit_first_name" required></div>
                    <div class="form-group" style="flex:1;"><label>Last Name</label><input type="text" name="last_name" id="edit_last_name" required></div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex:1;"><label>Age</label><input type="number" name="age" id="edit_age" required></div>
                    <div class="form-group" style="flex:1;"><label>Gender</label>
                        <select name="gender" id="edit_gender" required>
                            <option value="Male">Male</option><option value="Female">Female</option><option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-group"><label>Course</label><input type="text" name="course" id="edit_course" required></div>
                <button type="submit" class="btn-submit">Update Record</button>
            </form>
        </div>
    </div>

    <div id="settingsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h2>System Settings</h2><button class="close-btn" onclick="closeSettingsModal()">×</button></div>
            <h3 style="color: #ff4757; font-size: 14px; margin-bottom: 10px; text-transform: uppercase;">Danger Zone</h3>
            <p style="font-size: 13px; color: rgba(255,255,255,0.6); margin-bottom: 20px;">This action will permanently erase all student records from the database. It cannot be undone.</p>
            <form action="/students/truncate" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to delete ALL student data?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn-submit" style="background: rgba(255, 71, 87, 0.1); color: #ff4757; border: 1px solid rgba(255, 71, 87, 0.4);">Remove All Database Records</button>
            </form>
        </div>
    </div>

    <script>
        function updateClock() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit' };
            document.getElementById('live-time').innerText = new Date().toLocaleString('en-US', options);
        } setInterval(updateClock, 1000); updateClock();

        const addModal = document.getElementById('addStudentModal');
        const editModal = document.getElementById('editStudentModal');
        const settingsModal = document.getElementById('settingsModal');

        function openAddModal() { addModal.style.display = 'flex'; }
        function closeAddModal() { addModal.style.display = 'none'; }
        function openSettingsModal() { settingsModal.style.display = 'flex'; }
        function closeSettingsModal() { settingsModal.style.display = 'none'; }

        function openEditModal(btn) {
            document.getElementById('editForm').action = '/students/' + btn.getAttribute('data-id');
            document.getElementById('edit_first_name').value = btn.getAttribute('data-fname');
            document.getElementById('edit_last_name').value = btn.getAttribute('data-lname');
            document.getElementById('edit_age').value = btn.getAttribute('data-age');
            document.getElementById('edit_course').value = btn.getAttribute('data-course');
            document.getElementById('edit_gender').value = btn.getAttribute('data-gender');
            editModal.style.display = 'flex';
        }
        function closeEditModal() { editModal.style.display = 'none'; }

        window.onclick = function(e) { if(e.target == addModal) closeAddModal(); if(e.target == editModal) closeEditModal(); if(e.target == settingsModal) closeSettingsModal(); }

        // Combined Sorting and Filtering Logic
        function updateTable() {
            let search = document.getElementById('filterSearch').value.toLowerCase();
            let gender = document.getElementById('filterGender').value;
            let sortMode = document.getElementById('sortTable').value;
            
            let tbody = document.querySelector('#studentTable tbody');
            let rows = Array.from(tbody.querySelectorAll('.student-row'));

            // Sort the array of rows
            rows.sort((a, b) => {
                if (sortMode === 'none') return 0; 
                if (sortMode === 'fname') return a.cells[0].innerText.localeCompare(b.cells[0].innerText);
                if (sortMode === 'lname') return a.cells[1].innerText.localeCompare(b.cells[1].innerText);
                if (sortMode === 'ageAsc') return parseInt(a.cells[2].innerText) - parseInt(b.cells[2].innerText);
                if (sortMode === 'ageDesc') return parseInt(b.cells[2].innerText) - parseInt(a.cells[2].innerText);
                return 0;
            });

            // Re-append rows and apply filters
            rows.forEach(row => {
                tbody.appendChild(row); 

                let fname = row.cells[0].innerText.toLowerCase();
                let lname = row.cells[1].innerText.toLowerCase();
                let course = row.cells[3].innerText.toLowerCase();
                let rowGender = row.cells[4].innerText;

                let matchSearch = fname.includes(search) || lname.includes(search) || course.includes(search);
                let matchGender = gender === "none" || rowGender === gender;

                row.style.display = (matchSearch && matchGender) ? "" : "none";
            });
        }

        // Live Chart.js Data processing
        @php
            $ageGroups = $students->groupBy('age');
            $genderGroups = $students->groupBy('gender');
            
            $maleCount = $genderGroups->has('Male') ? $genderGroups['Male']->count() : 0;
            $femaleCount = $genderGroups->has('Female') ? $genderGroups['Female']->count() : 0;
            $otherCount = $genderGroups->has('Other') ? $genderGroups['Other']->count() : 0;
        @endphp

        const ageLabels = []; const ageData = [];
        @foreach($ageGroups as $age => $group)
            ageLabels.push("Age {{ $age }}"); ageData.push({{ $group->count() }});
        @endforeach

        Chart.defaults.color = 'rgba(255, 255, 255, 0.7)';
        Chart.defaults.font.family = 'Inter';

        new Chart(document.getElementById('ageChart'), {
            type: 'doughnut',
            data: { labels: ageLabels, datasets: [{ data: ageData, backgroundColor: ['#a29bfe', '#74b9ff', '#55efc4', '#ffeaa7', '#fab1a0'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { boxWidth: 10 } } }, cutout: '75%' }
        });

        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: { labels: ['Male', 'Female', 'Other'], datasets: [{ data: [{{ $maleCount }}, {{ $femaleCount }}, {{ $otherCount }}], backgroundColor: ['#74b9ff', '#fd79a8', '#dfe6e9'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { boxWidth: 10 } } }, cutout: '75%' }
        });
    </script>
</body>
</html>