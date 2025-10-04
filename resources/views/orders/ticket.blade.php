<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de compra</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 400px;
            margin: 20px auto;
            padding: 20px;
        }

        h1,
        h2,
        h3,
        h4 {
            text-align: center;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info div{
            margin-bottom: 5px
        }

        .footer{
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <h4>
            Numero de orden: {{ $order->id }}<br>
        </h4>

        <div class="info">
            <h3>
                Informacion de la tienda
            </h3>

            <div>
                Nombre: Ecommerce Hmb-Sport
            </div>

            <div>
                Ruc: 0603296484001
            </div>

            <div>
                Telefono: 0989009428
            </div>

            <div>
                Correo: quisniahugo@hotmail.com
            </div>




        </div>

        <div class="info">
            <h3>
                Datos del Cliente
            </h3>
            {{-- @dump($order->toArray()) --}}

            <div>
                Nombre: {{ $order->address['receiver_info']['name'] ?? 'No disponible' }}
                {{ $order->address['receiver_info']['last_name'] ?? '' }}

            </div>

            <div>
                Documento: {{ $order->address['receiver_info']['document_number'] ?? 'No disponible' }}
            </div>

            <div>
                Direccion: {{ $order->address['description'] }} - {{ $order->address['city'] }}
                ({{ $order->address['reference'] }})
            </div>

            <div>
                Telefono: {{ $order->address['receiver_info']['phone'] }}
            </div>

        </div>

        <div class="footer">
            !Gracias por su compra!
        </div>

    </div>
