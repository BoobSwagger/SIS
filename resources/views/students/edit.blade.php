<h2>Edit Student</h2>
<form method="POST" action="/students/{{ $student->id }}">
    @csrf
    @method('PUT')

    <label>First Name:</label>
    <input type="text" name="first_name" value="{{ $student->first_name }}"><br><br>
    
    <label>Last Name:</label>
    <input type="text" name="last_name" value="{{ $student->last_name }}"><br><br>
    
    <label>Age:</label>
    <input type="number" name="age" value="{{ $student->age }}"><br><br>
    
    <label>Course:</label>
    <input type="text" name="course" value="{{ $student->course }}"><br><br>
    
    <label>Gender:</label>
    <select name="gender" required>
        <option value="Male" @if($student->gender == 'Male') selected @endif>Male</option>
        <option value="Female" @if($student->gender == 'Female') selected @endif>Female</option>
        <option value="Other" @if($student->gender == 'Other') selected @endif>Other</option>
    </select><br><br>
    
    <button type="submit">Update</button>
</form>