<h2>Add Student</h2>
<form method="POST" action="/students">
    @csrf
    <label>First Name:</label>
    <input type="text" name="first_name"><br><br>

    <label>Last Name:</label>
    <input type="text" name="last_name"><br><br>

    <label>Age:</label>
    <input type="number" name="age"><br><br>

    <label>Course:</label>
    <input type="text" name="course"><br><br>

    <label>Gender:</label>
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br><br>

    <button type="submit">Save</button>
</form>