<?php

namespace App\Helpers;

use App\Constants\HUB30FieldLength;
use App\Models\Offer;
use Illuminate\Support\Str;

class HUB30
{
    /**
     * Constant string with fixed value
     *
     * @var string
     */
    private string $header = 'HRVHUB30';

    /**
     * Fixed value purpose code
     *
     * @var string
     */
    private string $purposeCode = 'COST';

    /**
     * Offer model
     * @var Offer
     */
    protected Offer $offer;

    /**
     * Generated HUB30 data as array
     *
     * @var array
     */
    protected array $data;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;

        $this->data = match (true) {
            $offer->isCondolenceOffer => $this->dataFromCondolencesOffer(),
            $offer->isAdOffer => $this->dataFromAdsOffer(),
            default => [],
        };
    }

    /**
     * Return HUB30 data as array
     * @return array
     */
    public function asArray(): array
    {
        return $this->data;
    }

    /**
     * Return HUB30 data as concatenated string
     * @return string
     */
    public function asString(): string
    {
        return implode("\n", $this->data);
    }

    /**
     * Is HUB30 data valid for generating PDF417
     * @return bool
     */
    public function isValidForPdf417(): bool
    {
        // Check if the array has exactly 14 elements
        if (count($this->data) !== 14) {
            return false;
        }

        // Check if all elements are non-null and not empty strings
        foreach ($this->data as $element) {
            if ($element === null || $element === '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Extract data from condolence offer
     * @return array
     */
    private function dataFromCondolencesOffer(): array
    {
        $this->offer->load('condolence');

        $payer_zipcode_town = $this->offer->condolence?->sender_zipcode . ' ' . $this->offer->condolence?->sender_town;
        $receiver_zipcode_town = config('eosmrtnice.company.zipcode') . ' ' . config('eosmrtnice.company.town');

        return [
            substr($this->header, 0, HUB30FieldLength::HEADER), // 1.
            substr(config('app.currency'), 0, HUB30FieldLength::CURRENCY), // 2.
            $this->amount(), // 3.
            substr($this->offer->condolence->sender_full_name, 0, HUB30FieldLength::PAYER_TITLE),  // 4.
            substr($this->offer->condolence->sender_address, 0, HUB30FieldLength::PAYER_ADDRESS), // 5.
            substr($payer_zipcode_town, 0, HUB30FieldLength::PAYER_ZIPCODE_TOWN), // 6.
            substr(config('eosmrtnice.company.title'), 0,HUB30FieldLength::RECEIVER_TITLE), // 7.
            substr(config('eosmrtnice.company.address'), 0,HUB30FieldLength::RECEIVER_ADDRESS), // 8.
            substr($receiver_zipcode_town, 0, HUB30FieldLength::RECEIVER_ZIPCODE_TOWN), // 9.
            substr(config('eosmrtnice.bank.iban'), 0, HUB30FieldLength::RECEIVER_IBAN), // 10.
            substr(config('eosmrtnice.bank.model'), 0, HUB30FieldLength::TRANSACTION_MODEL), // 11.
            substr($this->offer->reference_number, 0, HUB30FieldLength::TRANSACTION_REFERENCE_NUMBER), // 12.
            substr($this->purposeCode, 0, HUB30FieldLength::TRANSACTION_PURPOSE_CODE), // 13.
            substr($this->description(), 0, HUB30FieldLength::TRANSACTION_DESCRIPTION), // 14.
        ];
    }

    private function dataFromAdsOffer(): array
    {
        $payer_zipcode_town = $this->offer->company?->zipcode . ' ' . $this->offer->company?->town;
        $receiver_zipcode_town = config('eosmrtnice.company.zipcode') . ' ' . config('eosmrtnice.company.town');

        return [
            substr($this->header, 0, HUB30FieldLength::HEADER),
            substr(config('app.currency'), 0, HUB30FieldLength::CURRENCY),
            $this->amount(),
            substr($this->offer->company->title, 0, HUB30FieldLength::PAYER_TITLE),
            substr($this->offer->company->address, 0, HUB30FieldLength::PAYER_ADDRESS),
            substr($payer_zipcode_town, 0, HUB30FieldLength::PAYER_ZIPCODE_TOWN),
            substr(config('eosmrtnice.company.title'), 0,HUB30FieldLength::RECEIVER_TITLE),
            substr(config('eosmrtnice.company.address'), 0,HUB30FieldLength::RECEIVER_ADDRESS),
            substr($receiver_zipcode_town, 0, HUB30FieldLength::RECEIVER_ZIPCODE_TOWN),
            substr(config('eosmrtnice.bank.iban'), 0, HUB30FieldLength::RECEIVER_IBAN),
            substr(config('eosmrtnice.bank.model'), 0, HUB30FieldLength::TRANSACTION_MODEL),
            substr($this->offer->reference_number, 0, HUB30FieldLength::TRANSACTION_REFERENCE_NUMBER),
            substr($this->purposeCode, 0, HUB30FieldLength::TRANSACTION_PURPOSE_CODE),
            substr($this->description(), 0, HUB30FieldLength::TRANSACTION_DESCRIPTION),
        ];
    }

    /**
     * Generate amount string
     *
     * @return string
     */
    private function amount(): string
    {
        // Transform to cents
        $amount = (float)$this->offer->total * 100;
        return Str::padLeft($amount, HUB30FieldLength::AMOUNT, '0');
    }

    /**
     * Return payment description string
     *
     * @return string
     */
    private function description(): string
    {
        return __('models/offer.payment_upon_offer', ['number' => $this->offer->number]);
    }
}
