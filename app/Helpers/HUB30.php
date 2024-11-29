<?php

namespace App\Helpers;

use App\Constants\HUB30FieldLength;
use App\Models\Offer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

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
    protected Offer $model;

    /**
     * Generated HUB30 data as array
     *
     * @var array
     */
    protected array $data;

    public function __construct(Offer $model)
    {
        $this->model = $model;

        $this->data = match (true) {
            !is_null($model->condolence_id) => $this->dataFromCondolencesOffer(),
            default => [],
        };
    }

    /**
     * Return HUB30 data as array
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Extract data from condolence offer
     *
     * @return array
     */
    private function dataFromCondolencesOffer(): array
    {
        $this->model->load('condolence');

        $payer_zipcode_town = $this->model->condolence?->sender_zipcode . ' ' . $this->model->condolence?->sender_town;
        $receiver_zipcode_town = config('eosmrtnice.company.zipcode') . ' ' . config('eosmrtnice.company.town');

        return [
            substr($this->header, 0, HUB30FieldLength::HEADER),
            substr(config('app.currency'), 0, HUB30FieldLength::CURRENCY),
            $this->amount(),
            substr($this->model->condolence->sender_full_name, 0, HUB30FieldLength::PAYER_TITLE),
            substr($this->model->condolence->sender_address, 0, HUB30FieldLength::PAYER_ADDRESS),
            substr($payer_zipcode_town, 0, HUB30FieldLength::PAYER_ZIPCODE_TOWN),
            substr(config('eosmrtnice.company.title'), 0,HUB30FieldLength::RECEIVER_TITLE),
            substr(config('eosmrtnice.company.address'), 0,HUB30FieldLength::RECEIVER_ADDRESS),
            substr($receiver_zipcode_town, 0, HUB30FieldLength::RECEIVER_ZIPCODE_TOWN),
            substr(config('eosmrtnice.bank.iban'), 0, HUB30FieldLength::RECEIVER_IBAN),
            substr(config('eosmrtnice.bank.model'), 0, HUB30FieldLength::TRANSACTION_MODEL),
            substr($this->model->reference_number, 0, HUB30FieldLength::TRANSACTION_REFERENCE_NUMBER),
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
        $amount = (float)$this->model->total * 100;
        return Str::padLeft($amount, HUB30FieldLength::AMOUNT, '0');
    }

    /**
     * Return payment description string
     *
     * @return string
     */
    private function description(): string
    {
        return __('models/offer.payment_upon_offer', ['number' => $this->model->number]);
    }
}
