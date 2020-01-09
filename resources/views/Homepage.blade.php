<html>
    <body>
        <h1>Laravel Lumen API Demo</h1>

        <p>Welcome to the "Date Interval Calculator" API demo.</p>
        <p>Each section in the page below allows interaction with one of the endpoints described in the requirements document.</p>

        <hr>
        <h2>Days between two datetimes</h2>

        <form name="days-between-datetimes" method="POST" action="{{ route('days-between-dates')  }}">
            <label for="startdate">Start Datetime (ISO 8601 format)</label>
            <input type="text" id="startdate" name="startDateTime" value="">

            <label for="enddate">End Datetime (ISO 8601 format)</label>
            <input type="text" id="enddate" name="endDateTime" value="">

            <label for="outputunit">Output Units (optional)</label>

            <select id="outputunit" name="outputUnit">
                <option value="default" selected>Default (Decimal number of days)</option>
                <option value="seconds">Seconds</option>
                <option value="minutes">Minutes</option>
                <option value="hours">Hours</option>
                <option value="years">Years</option>
            </select>

            <input type="submit">

        </form>

        <hr>
        <h2>Week Days between two datetimes</h2>

        <hr>
        <h2>Complete Weeks between two datetimes</h2>


    </body>
</html>
