<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Checkout</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <script src="https://js.stripe.com/v3/"></script>

        <style>
            .payments-box {
                display: flex;
                justify-content: center;
                align-items: center;
                height: calc(100vh - 50px);
            }
            #payment-form {
                margin-top: 50px;
                width: 500px;
                max-width: 500px;
                margin: auto;
            }
            #submit {
                margin-top: 15px;
                background-color: #008CBA; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                border-radius: 12px;
                cursor: pointer;
            }
            .error {
                color: red;
            }
            #error-message {
                visibility: hidden;
            }
        </style>
    </head>
    <body class="antialiased">
        @if (request()->has('client_secret'))
            <div class="payments-box">
                <form id="payment-form">
                    <div id="payment-element">
                    <!-- Elements will create form elements here -->
                    </div>
                    <button id="submit">Submit</button>
                    <div id="error-message">
                    <!-- Display error message to your customers here -->
                    </div>
                </form>
            </div>
        @else
            <div class="error">
                <p>Payment Intent Client Secret is required</p>
            </div>
        @endif
        
    </body>
    @if (request()->has('client_secret'))
        <script>
            const stripe = Stripe('{{ env("STRIPE_KEY") }}');

            const options = {
                clientSecret: '{{ $client_secret }}',
                // Fully customizable with appearance API.
                appearance: {/*...*/},
            };

            // Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 3
            const elements = stripe.elements(options);

            // Create and mount the Payment Element
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');

            const form = document.getElementById('payment-form');

            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const {error} = await stripe.confirmPayment({
                    //`Elements` instance that was used to create the Payment Element
                    elements,
                    confirmParams: {
                        return_url: 'https://example.com/order/123/complete',
                    },
                });

                if (error) {
                    // This point will only be reached if there is an immediate error when
                    // confirming the payment. Show error to your customer (for example, payment
                    // details incomplete)
                    const messageContainer = document.querySelector('#error-message');
                    messageContainer.textContent = error.message;
                } else {
                    // Your customer will be redirected to your `return_url`. For some payment
                    // methods like iDEAL, your customer will be redirected to an intermediate
                    // site first to authorize the payment, then redirected to the `return_url`.
                }
            });
        </script>
    @endif
</html>
