<html>
    <body>
        <h1>Laravel Lumen API Demo</h1>

        <p>Welcome to the "Date Interval Calculator" API demo.</p>
        <p>Each section in the page below allows interaction with one of the endpoints described in the requirements document.</p>

        <hr>
        <h2>Days between two datetimes</h2>

        <form id="days-between-datetimes" name="days-between-datetimes" method="POST" action="{{ route('days-between-dates')  }}">
            <label for="startdate">Start Datetime</label>
            <input type="text" id="startdate" name="startDateTime" value="">

            <label for="enddate">End Datetime</label>
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

        <p>Output:</p>
        <div id="days-between-datetimes-output"></div>

        <hr>
        <h2>Week Days between two datetimes</h2>

        <hr>
        <h2>Complete Weeks between two datetimes</h2>


    <script>

        const formToJSON = elements => [].reduce.call(elements, (data, element) => {
            data[element.name] = element.value;
            return data;
        }, {});

        function sendData(form, endpoint, outputEl) {

            const formdata = formToJSON( form.elements );

            fetch(endpoint, {
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formdata),
            })
                .then((response) => response.json())
                .then((data) => {
                    outputEl.innerText = JSON.stringify(data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        let form_daysBetweenDatetimes =  document.getElementById('days-between-datetimes');

        form_daysBetweenDatetimes.addEventListener( "submit", function ( event ) {
            event.preventDefault();
            let outputEl = document.getElementById("days-between-datetimes-output");
            sendData(form_daysBetweenDatetimes, form_daysBetweenDatetimes.action, outputEl );
        } );
    </script>

    </body>
</html>
