
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Forex Rates</h1>
    <button id="load-rates">Load Forex Rates</button>
    <table id="forex-rates" border="1" style="display:none;">
        <thead>
            <tr>
                <th>Currency</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <h2>Convert Currency</h2>
    <input type="text" id="amount" placeholder="Amount">
    <select id="currency"></select>
    <button id="convert">Convert</button>
    <p id="conversion-result"></p>

    <script>
        $(document).ready(function(){
            // Load Forex Rates
            $('#load-rates').click(function(){
                $.ajax({
                    url: '/api/forex-rates',
                    method: 'GET',
                    success: function(data) {
                        var tbody = $('#forex-rates tbody');
                        tbody.empty();
                        for(var currency in data.rates) {
                            var rate = data.rates[currency];
                            tbody.append('<tr><td>' + currency + '</td><td>' + rate + '</td></tr>');
                        }
                        $('#forex-rates').show();

                        // Log
                        var forexRates = data.rates;
                        for (var currency in forexRates) {
                            var rate = forexRates[currency];
                            console.log(currency + ": " + rate);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Load currencies into the dropdown
            $.ajax({
                url: '/api/forex-rates',
                method: 'GET',
                success: function(data) {
                    var currencyDropdown = $('#currency');
                    currencyDropdown.empty(); // Clear previous options
                    for(var currency in data.rates) {
                        currencyDropdown.append('<option value="' + currency + '">' + currency + '</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

            // Convert currency
            $('#convert').click(function(){
                var amount = $('#amount').val();
                var currency = $('#currency').val();
                var token = $('meta[name="csrf-token"]').attr('content'); // Fetch CSRF token from meta tag

                console.log("Sending amount: " + amount + ", currency: " + currency);

                $.ajax({
                    url: '/api/convert',
                    method: 'POST',
                    data: {
                        amount: amount,
                        currency: currency,
                        _token: token // Include CSRF token in the data
                    },
                    success: function(result) {
                        console.log(result); // Log the entire response object to the console
                        if (result.converted) {
                            $('#conversion-result').text('Converted Amount: ' + result.converted);
                        } else {
                            $('#conversion-result').text('Error: ' + result.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>
