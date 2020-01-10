<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Laravel Lumen API Demo</title>
    <meta name="description" content="Laravel Lumen API Demo">
    <meta name="author" content="Brendan Hart">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/pure.css">

    <style>
        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 900px 1fr;
        }

        .form-input-wrapper {
            margin-bottom: 1em;
        }

        li {
            margin-bottom: 1em;
        }

        .output {
            min-width: 600px;
            min-height: 100px;
            padding: 15px;
            border: 1px solid black;
        }
    </style>

</head>

<body>
<div class="content-wrapper">
    <div></div>
    <div>
        <h1>Laravel Lumen API Demo</h1>

        <p>
            Welcome to the "Date Interval Calculator" API demo.
        </p>
        <p>
            Each section in the page below allows interaction with one of the endpoints described in the requirements
            document.
        </p>

        <h3>Notes:</h3>
        <ul>
            <li>
                No authentication/authorisation, rate limiting or other API secondary requirements have been
                implemented.
            </li>
            <li>
                API endpoints accept both basic url-encoded HTML form and JSON formatted requests
            </li>
            <li>
                The requirements were interpreted to mean that only "complete" time periods would be counted; for
                example, a start datetime with a time component is rounded up to the start of the next day.
            </li>
            <li>
                The requirements were interpreted to mean that only "complete" time periods between the endpoints would
                be counted; for example, a start datetime with a time component is rounded up to the start of the next
                day.
            </li>
            <li>
                The "complete weeks" endpoint assumes the weeks to be counted begin on Mondays.
            </li>
        </ul>

        <hr>

        <div>
            <h2>Days between two datetimes</h2>

            <p>
                Endpoint address: <em>/api/days-between-dates</em>
            </p>

            <form id="days-between-datetimes" name="days-between-datetimes" class="pure-form pure-form-stacked"
                  method="POST"
                  action="{{ route('days-between-dates')  }}">
                <fieldset>

                    <div class="form-input-wrapper">
                        <label for="startdate">Start Datetime</label>
                        <input type="text" id="startdate" name="startDateTime" value="">
                    </div>

                    <div class="form-input-wrapper">
                        <label for="enddate">End Datetime</label>
                        <input type="text" id="enddate" name="endDateTime" value="">
                    </div>

                    <div class="form-input-wrapper">
                        <label for="outputunit">Output Units (optional)</label>
                        <select id="outputunit" name="outputUnit">
                            <option value="default" selected>Default (Decimal number of days)</option>
                            <option value="seconds">Seconds</option>
                            <option value="minutes">Minutes</option>
                            <option value="hours">Hours</option>
                            <option value="years">Years</option>
                        </select>
                    </div>

                    <input type="submit" class="pure-button pure-button-primary">
                </fieldset>

            </form>

            <p>Output:</p>
            <div id="days-between-datetimes-output" class="output"></div>
        </div>

        <hr>

        <div>
            <h2>Week Days between two datetimes</h2>

            <p>Endpoint address: <em>/api/weekdays-between-dates</em></p>

            <form id="weekdays-between-datetimes" name="weekdays-between-datetimes" class="pure-form pure-form-stacked"
                  method="POST"
                  action="{{ route('weekdays-between-dates')  }}">
                <fieldset>

                    <div class="form-input-wrapper">
                        <label for="startDateTime">Start Datetime</label>
                        <input type="text" id="startdate" name="startDateTime" value="">
                    </div>

                    <div class="form-input-wrapper">
                        <label for="enddate">End Datetime</label>
                        <input type="text" id="enddate" name="endDateTime" value="">
                    </div>

                    <div class="form-input-wrapper">
                        <label for="outputunit">Output Units (optional)</label>
                        <select id="outputunit" name="outputUnit">
                            <option value="default" selected>Default (Decimal number of days)</option>
                            <option value="seconds">Seconds</option>
                            <option value="minutes">Minutes</option>
                            <option value="hours">Hours</option>
                            <option value="years">Years</option>
                        </select>
                    </div>

                    <input type="submit" class="pure-button pure-button-primary">
                </fieldset>

            </form>

            <p>Output:</p>
            <div id="weekdays-between-datetimes-output" class="output"></div>

        </div>

        <hr>

        <div>
            <h2>Complete Weeks between two datetimes</h2>

            <p>Endpoint address: <em>/api/complete-weeks-between-dates</em></p>

            <form id="complete-weeks-between-datetimes" name="complete-weeks-between-datetimes"
                  class="pure-form pure-form-stacked"
                  method="POST"
                  action="{{ route('complete-weeks-between-dates')  }}">
                <fieldset>

                    <div class="form-input-wrapper">
                        <label for="startDateTime">Start Datetime</label>
                        <input type="text" id="startdate" name="startDateTime" value="">
                    </div>

                    <div class="form-input-wrapper">
                        <label for="enddate">End Datetime</label>
                        <input type="text" id="enddate" name="endDateTime" value="">
                    </div>

                    <div class="form-input-wrapper">
                        <label for="outputunit">Output Units (optional)</label>
                        <select id="outputunit" name="outputUnit">
                            <option value="default" selected>Default (Decimal number of weeks)</option>
                            <option value="seconds">Seconds</option>
                            <option value="minutes">Minutes</option>
                            <option value="hours">Hours</option>
                            <option value="years">Years</option>
                        </select>
                    </div>

                    <input type="submit" class="pure-button pure-button-primary">
                </fieldset>

            </form>

            <p>Output:</p>
            <div id="complete-weeks-between-datetimes-output" class="output"></div>

        </div>

    </div>
    <div></div>
</div>

<script>

    const formToJSON = elements => [].reduce.call(elements, (data, element) => {
        data[element.name] = element.value;
        return data;
    }, {});

    function sendData(form, endpoint, outputEl) {

        const formdata = formToJSON(form.elements);

        fetch(endpoint, {
            method: 'POST',
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

    let form_daysBetweenDatetimes = document.getElementById('days-between-datetimes');

    form_daysBetweenDatetimes.addEventListener("submit", function (event) {
        event.preventDefault();
        let outputEl = document.getElementById("days-between-datetimes-output");
        sendData(form_daysBetweenDatetimes, form_daysBetweenDatetimes.action, outputEl);
    });

    let form_weekdaysBetweenDatetimes = document.getElementById('weekdays-between-datetimes');

    form_weekdaysBetweenDatetimes.addEventListener("submit", function (event) {
        event.preventDefault();
        let outputEl = document.getElementById("weekdays-between-datetimes-output");
        sendData(form_weekdaysBetweenDatetimes, form_weekdaysBetweenDatetimes.action, outputEl);
    });

    let form_completeWeeksBetweenDatetimes = document.getElementById('complete-weeks-between-datetimes');

    form_completeWeeksBetweenDatetimes.addEventListener("submit", function (event) {
        event.preventDefault();
        let outputEl = document.getElementById("complete-weeks-between-datetimes-output");
        sendData(form_completeWeeksBetweenDatetimes, form_completeWeeksBetweenDatetimes.action, outputEl);
    });
</script>

</body>
</html>
