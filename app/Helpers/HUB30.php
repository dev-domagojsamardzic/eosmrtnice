<?php

namespace App\Helpers;

use App\Constants\HUB30FieldLength;
use App\Models\Offer;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS2DFacade;

class HUB30
{
    /**
     * Constant string with fixed value
     *
     * @var string
     */
    private string $header = "HRVHUB30";

    /**
     * Fixed value purpose code
     * GDSV = Kupoprodaja roba i usluga
     * @var string
     */
    private string $purposeCode = "GDSV";

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

        // Init HUB30 data array
        $basic = [
            substr($this->header, 0, HUB30FieldLength::HEADER),
            substr(config('app.currency'), 0, HUB30FieldLength::CURRENCY),
            $this->amount(),
        ];
        $payer = $this->payerData();
        $payee = $this->payeeData();
        $transaction = $this->transactionData();

        $this->data = [...$basic, ...$payer, ...$payee, ...$transaction];
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
        return count($this->data) === 14;
    }

    /**
     * Return base64 encoded svg string for PDF417 barcode
     * @return string
     */
    public function pdf417AsBase64(): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode(DNS2DFacade::getBarcodeSVG($this->asString(), "PDF417", 3, 1, '#000000'));
    }

    /**
     * Extract payer data for condolence offer
     * @return array
     */
    private function payerDataForCondolencesOffer(): array
    {
        $this->offer->load('condolence');
        $zipcodeAndTown = (!$this->offer->condolence?->sender_zipcode || !$this->offer->condolence?->sender_town) ?
            '' : $this->offer->condolence?->sender_zipcode . ' ' . $this->offer->condolence?->sender_town;

        return [
            substr($this->offer->condolence?->sender_full_name ?? '', 0, HUB30FieldLength::PAYER_TITLE),
            substr($this->offer->condolence?->sender_address ?? '', 0, HUB30FieldLength::PAYER_ADDRESS),
            substr($zipcodeAndTown, 0, HUB30FieldLength::PAYER_ZIPCODE_TOWN),
        ];
    }

    /**
     * Extract payer data for ads offer
     * @return array
     */
    private function payerDataForAdsOffer(): array
    {
        $zipcodeAndTown = (!$this->offer->company?->zipcode || !$this->offer->company?->town) ?
            '' : $this->offer->company?->zipcode . ' ' . $this->offer->company?->town;

        return [
            substr($this->offer->company?->title, 0, HUB30FieldLength::PAYER_TITLE),
            substr($this->offer->company->address, 0, HUB30FieldLength::PAYER_ADDRESS),
            substr($zipcodeAndTown, 0, HUB30FieldLength::PAYER_ZIPCODE_TOWN),
        ];
    }

    /**
     * Extract payer data for posts offer
     * @return array
     */
    private function payerDataForPostsOffer(): array
    {
        $zipcodeAndTown = (!$this->offer->user?->zipcode || !$this->offer->user?->town) ?
            '' : $this->offer->user?->zipcode . ' ' . $this->offer->user?->town;

        return [
            substr($this->offer->user?->full_name, 0, HUB30FieldLength::PAYER_TITLE),
            substr($this->offer->user?->address, 0, HUB30FieldLength::PAYER_ADDRESS),
            substr($zipcodeAndTown, 0, HUB30FieldLength::PAYER_ZIPCODE_TOWN),
        ];
    }

    /**
     * Get transaction related data
     * @return array
     */
    private function transactionData(): array
    {
        return [
            substr(config('eosmrtnice.bank.model'), 0, HUB30FieldLength::TRANSACTION_MODEL),
            substr($this->offer->reference_number, 0, HUB30FieldLength::TRANSACTION_REFERENCE_NUMBER),
            substr($this->purposeCode, 0, HUB30FieldLength::TRANSACTION_PURPOSE_CODE),
            substr($this->description(), 0, HUB30FieldLength::TRANSACTION_DESCRIPTION),
        ];
    }


    /**
     * Payment receiver data
     * @return array
     */
    private function payeeData(): array
    {
        return [
            substr(config('eosmrtnice.company.title'), 0, HUB30FieldLength::RECEIVER_TITLE),
            substr(config('eosmrtnice.company.address'), 0, HUB30FieldLength::RECEIVER_ADDRESS),
            substr(
                config('eosmrtnice.company.zipcode') . ' ' . config('eosmrtnice.company.town'),
                0,
                HUB30FieldLength::RECEIVER_ZIPCODE_TOWN
            ),
            substr(config('eosmrtnice.bank.iban'), 0, HUB30FieldLength::RECEIVER_IBAN),
        ];
    }

    /**
     * Get payer data based on offer type
     * @return array
     */
    private function payerData(): array
    {
        return match (true) {
            $this->offer->isCondolenceOffer => $this->payerDataForCondolencesOffer(),
            $this->offer->isAdOffer => $this->payerDataForAdsOffer(),
            $this->offer->isPostOffer => $this->payerDataForPostsOffer(),
            default => ["", "", ""],
        };
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
