# Subscription Renewal Payment
This is the job that needs to be called to process a subscription payment. This job does not check if the subscription is due for payment (that is done in the (Subscription Payment Queuer Job)).

## What it does
This job passes data to and calls `execute()` method on the payment method service.


