<x-mail::table>
    <table class="table_signature">
        <tbody>
            <tr>
                <td style="font-weight: bold">{{ config('app.name') }} {{ __('mail.team') }}</td>
            </tr>
            <tr>
                <td>{{ __('models/company.email') . ': ' . company_data('email') }}</td>
            </tr>
            <tr>
                <td>{{ __('models/company.phone') . ': ' . company_data('phone') }}</td>
            </tr>
            <tr>
                <td>{{ __('models/company.fax') . ': ' . company_data('fax') }}</td>
            </tr>
        </tbody>
    </table>
</x-mail::table>

