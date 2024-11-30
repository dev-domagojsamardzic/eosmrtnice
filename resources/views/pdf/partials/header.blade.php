<table style="float: left;">
    <tbody>
        <tr><td><h2>{{ company_data('title') }}</h2></td></tr>
        <tr><td>{{ company_data('address') }}</td></tr>
        <tr><td>{{ company_data('zipcode') . ', ' . company_data('town') }}</td></tr>
        <tr><td>{{ company_data('country') }}</td></tr>
        <tr><td>{{ __('models/company.oib') }}: {{ company_data('oib') }}</td></tr>
        <tr><td>{{ __('models/company.phone_short') }}: {{ company_data('phone') }}</td></tr>
        <tr><td>{{ __('models/company.fax_short') }}: {{ company_data('fax') }}</td></tr>
        <tr><td>{{ __('models/company.email') }}: {{ company_data('email') }}</td></tr>
    </tbody>
</table>

<table style="float: right">
    <tbody>
        <tr><td>{{ __('models/company.bank_iban') }}: {{ company_bank_data('iban') }}</td></tr>
        <tr><td>{{ __('models/company.bank_swift') }}: {{ company_bank_data('swift_code') }}</td></tr>
        <tr><td>{{ __('models/company.bank_model_reference_number') }}: <br>{{ company_bank_data('model').' / ' . $offer->reference_number }}</td></tr>
        <tr><td>{{ __('models/company.bank_title') }}: {{ company_bank_data('title') }}</td></tr>
        <tr>
            <td style="padding: 32px 0 0 0;">
                <img src="{!! $offer->base64pdf417 !!}" style="width: 56mm;height:auto;" alt="PDF417">
            </td>
        </tr>
    </tbody>
</table>
