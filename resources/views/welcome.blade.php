<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="antialiased">

    <div id="paypal-button-container"></div>



    <script
        src="https://www.paypal.com/sdk/js?client-id=Aes56nAKYQiNZSLJVCBL_mow2U1RIGfRINJuoRpkx5oZPAi7qCu3EHzYgJV_EyjKS_pyq0qiLhYshhMv&components=buttons&disable-funding=card,sofort&currency=EUR">
    </script>
    <script src="{{asset('/js/paypal.js')}}" defer>

    </script>

</body>

</html>
