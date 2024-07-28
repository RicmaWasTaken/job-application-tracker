@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="/test" method="POST">
    @csrf

    <div>
        <label for="company_name">Company Name</label>
        <input type="text" name="company_name" required maxlength="255">
    </div>

    <div>
        <label for="location">Location</label>
        <input type="text" name="location" required maxlength="255">
    </div>

    <div>
        <label for="sector">Sector</label>
        <input type="text" name="sector" required maxlength="255">
    </div>

    <div>
        <label for="discovered_on">Discovered On</label>
        <input type="date" name="discovered_on" required>
    </div>

    <div>
        <label for="first_contact">First Contact</label>
        <input type="date" name="first_contact" required>
    </div>

    <div>
        <label for="last_contact">Last Contact</label>
        <input type="date" name="last_contact" required>
    </div>

    <div>
        <label for="via">Via</label>
        <input type="text" name="via" required maxlength="255">
    </div>

    <div>
        <label for="interview_true">Interview Yes</label>
        <input type="radio" id="interview_true" name="interview" value="1" required>
        <label for="interview_false">Interview No</label>
        <input type="radio" id="interview_false" name="interview" value="0" required>
    </div>

    <div>
        <label for="status">Status</label>
        <input type="number" name="status" required>
    </div>

    <div>
        <label for="link">Link</label>
        <input type="text" name="link" required>
    </div>

    <div>
        <label for="comments">Comments</label>
        <textarea name="comments" required></textarea>
    </div>

    <button type="submit">Submit</button>
</form>
<br><br><br><br><br>
