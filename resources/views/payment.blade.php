<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment</title>
        <!-- Include Midtrans Snap.js with data-client-key -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env("MIDTRANS_CLIENT_KEY") }}">
        </script>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            form {
                max-width: 400px;
                margin: auto;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            input[type="text"],
            input[type="email"],
            input[type="tel"],
            button {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            button {
                background-color: #4CAF50;
                color: white;
                cursor: pointer;
            }

            button:hover {
                background-color: #45a049;
            }
        </style>
    </head>

    <body>
        <h1>Payment Form</h1>
        <form id="payment-form">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first_name" required>

            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last_name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="amount">Amount (IDR)</label>
            <input type="text" id="amount" name="amount" required>

            <button type="button" id="pay-button">Pay Now</button>
        </form>

        <script>
            document.getElementById('pay-button').addEventListener('click', function() {
                // Prepare data for transaction
                var firstName = document.getElementById('first-name').value;
                var lastName = document.getElementById('last-name').value;
                var email = document.getElementById('email').value;
                var phone = document.getElementById('phone').value;
                var amount = document.getElementById('amount').value;

                // Ensure the amount is a valid number
                if (isNaN(amount) || amount <= 0) {
                    alert('Please enter a valid amount.');
                    return;
                }

                // Prepare data for the server to create a transaction
                fetch('/create-transaction', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure to include CSRF token for security
                        },
                        body: JSON.stringify({
                            first_name: firstName,
                            last_name: lastName,
                            email: email,
                            phone: phone,
                            amount: amount
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.snapToken) {
                            // If the server responds with a snap token, proceed to payment
                            snap.pay(data.snapToken, {
                                onSuccess: function(result) {
                                    alert('Payment successful!');
                                    console.log(result);
                                },
                                onPending: function(result) {
                                    alert('Waiting for your payment!');
                                    console.log(result);
                                },
                                onError: function(result) {
                                    alert('Payment failed!');
                                    console.log(result);
                                },
                                onClose: function() {
                                    alert('You closed the popup without finishing the payment');
                                }
                            });
                        } else {
                            alert('Error creating transaction: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while processing your payment.');
                    });
            });
        </script>
    </body>

</html>
