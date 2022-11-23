const paypalButtonsComponent = paypal.Buttons({
    createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units: [
                {
                    amount: {
                        value: "0.01", // can be set to anything
                    },
                },
            ],
            application_context: {
                shipping_preference: "NO_SHIPPING",
            },
        });
    },

    // Finalize the transaction after payer approval
    onApprove: function (data, actions) {
        const captureOrderHandler = (details) => {
            console.log(details); // the order details returned.  the details.id is the order number saved to the database
        };

        return actions.order.capture().then(captureOrderHandler);
    },

    // handle unrecoverable errors
    onError: (err) => {
        console.error(err);
        self.handleError(err.response.data);
    },
});

paypalButtonsComponent.render("#paypal-button-container").catch((err) => {
    console.error("PayPal Buttons failed to render");
});
