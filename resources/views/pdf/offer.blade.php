<html>
<head>
    <meta charset="UTF-8">
    <title>Ponuda {{ $offer->number }}</title>
    <style>
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/Montserrat-Medium.ttf') }}) format('truetype');
        }
        *{font-family: Montserrat, sans-serif;}
    </style>
</head>
<body>

    <table>
        <tbody>
            <tr><td>Naziv tvrtke</td></tr>
            <tr><td>Adresa tvrtke 12</td></tr>
            <tr><td>32000, Naziv Gradačca</td></tr>
            <tr><td>Republika Hrvatska</td></tr>
            <tr><td>OIB: 11583484321</td></tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top:16px;">
        <thead>
            <tr>
                <th style="text-align: left; font-size: 22px;">{{ __('models/offer.offer') . ' #' . $offer->id}}</th>
                <th style="text-align: right; font-size: 22px;">{{ $offer->number }}</th>
            </tr>
        </thead>
        <tbody>
            <tr style="margin-top: 12px;">
                <td style="text-align: left;">
                    <table>
                        <tr><td><strong>{{ __('models/offer.buyer') }}</strong></td></tr>
                        <tr><td>{{ $offer->company->title }}</td></tr>
                        <tr><td>{{ $offer->company->address }}</td></tr>
                        <tr><td>{{ $offer->company->zipcode . ' ' . $offer->company->city->title }}</td></tr>
                        <tr><td>Republika Hrvatska</td></tr>
                    </table>
                </td>
                <td style="text-align: right;">
                    <table style="width: 100%">
                        <tr>
                            <td style="text-align: left">Datum izdavanja</td>
                            <td style="text-align: right">{{ $offer->created_at->format('d.m.Y.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Mjesto izdavanja: </td>
                            <td style="text-align: right">Zagreb</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Vrijeme izdavanja: </td>
                            <td style="text-align: right">{{ $offer->created_at->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Ponuda vrijedi do: </td>
                            <td style="text-align: right">{{ $offer->valid_until->format('d.m.Y.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; border: 1px solid grey;">
        <thead>
            <tr>
                <th style="text-align: left;">{{ __('models/offer.item') }}</th>
                <th style="text-align: right;">{{ __('models/offer.quantity') }}</th>
                <th style="text-align: right;">{{ __('models/offer.price') }}</th>
                <th style="text-align: right;">{{ __('models/offer.total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offer->offerables as $item)
                <tr>
                    <td style="text-align: left">{{ $item->title }}</td>
                    <td style="text-align: right">{{ $item->quantity }}</td>
                    <td style="text-align: right">{{ $item->price . '€' }}</td>
                    <td style="text-align: right">{{ number_format((int)$item->quantity * (float)$item->price, 2) . '€'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
