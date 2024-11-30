<?php

namespace App\Models;

use App\Helpers\HUB30;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS2DFacade;

/**
 * @property-read       int                 id
 * @property            int                 company_id
 * @property            int                 ad_id
 * @property            int                 condolence_id
 * @property            int                 user_id
 * @property            int                 post_id
 * @property            string              number
 * @property            int                 quantity
 * @property            float               price
 * @property            float               net_total
 * @property            float               taxes
 * @property            float               total
 * @property            Carbon              valid_from
 * @property            Carbon              valid_until
 * @property            bool                confirmed
 * @property            Carbon              sent_at
 * @property            Carbon              created_at
 * @property            Carbon              updated_at
 * @property            Carbon              deleted_at
 *  ------------------------------------------------------------
 * @property-read       bool                is_valid
 * @property-read       string              reference_number
 * @property-read       array               HUB30Data
 * @property-read       string              HUB30String
 * @property-read       string              base64_pdf417
 * @property-read       bool                isCondolenceOffer
 * @property-read       bool                isAdOffer
 * @property-read       bool                isPostOffer
 *  ------------------------------------------------------------
 * @property            Company             company
 * @property            Ad                  ad
 * @property            User                user
 * @property            Post                post
 * @property            Condolence          condolence
 */
class Offer extends Model
{
    use SoftDeletes;

    protected $table = 'offers';

    protected string $pdfView = 'pdf.offers';

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'sent_at' => 'datetime',
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'net_total' => 'decimal:2',
        'taxes' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected $attributes = [
        'number' => '',
        'confirmed' => false,
    ];

    /**
     * Return user related to offer
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return post related to offer
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Return company related to offer
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Return company related to offer
     * @return BelongsTo
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Return condolence related to offer
     * @return BelongsTo
     */
    public function condolence(): BelongsTo
    {
        return $this->belongsTo(Condolence::class, 'condolence_id');
    }

    /**
     * Scope a query to only include valid offers
     */
    public function scopeValid(Builder $query): void
    {
        $query->where('valid_from', '<=', now()->toDateString())
            ->where('valid_until', '>=', now()->toDateString());
    }

    /**
     * Is offer valid
     */
    protected function isValid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->valid_from->startOfDay()->lt(now()) &&
                $this->valid_until->endOfDay()->gt(now())
        );
    }

    /**
     * Return base64 encoded svg string for PDF417 barcode
     * @return Attribute
     */
    protected function base64pdf417(): Attribute
    {
        return Attribute::make(
            get: fn () => 'data:image/svg+xml;base64,' .
                base64_encode(DNS2DFacade::getBarcodeSVG($this->HUB30String, "PDF417", 3, 1))
        );
    }

    /**
     * Transform offer to raw pdf
     *
     * @return string
     */
    public function toRawPdf(): string
    {
        return SnappyPdf::loadView($this->pdfView, ['offer' => $this])
            ->setOption('encoding', 'UTF-8')
            ->output();
    }

    /**
     * Return offer pdf as response
     *
     * @return Response
     */
    public function downloadPdf(): Response
    {
        return SnappyPdf::loadView($this->pdfView, ['offer' => $this])
            ->setOption('encoding', 'UTF-8')
            ->download($this->number . '.pdf');
    }

    /**
     * HUB30 data as array
     *
     * @return Attribute
     */
    protected function HUB30Data(): Attribute
    {
        return Attribute::make(
            get: fn() => (new HUB30($this))->data()
        );
    }

    /**
     * HUB30 data as string concatenated with LF
     * @return Attribute
     */
    protected function HUB30String(): Attribute
    {
        return Attribute::make(
            get: fn() => implode("\n", $this->hub30Data)
        );
    }

    /**
     * Offer's payment reference number
     *
     * @return Attribute
     */
    protected function referenceNumber(): Attribute
    {
        return Attribute::make(
            get: fn () => implode('-', [
                config('eosmrtnice.company.oib'),
                $this->created_at->format('Y'),
                Str::padLeft($this->id, 5, '0')
            ])
        );
    }

    /**
     * Check if is condolence offer
     *
     * @return Attribute
     */
    protected function isCondolenceOffer(): Attribute
    {
        return Attribute::make(
            get: fn() => is_null($this->company_id) && is_null($this->ad_id) &&
                is_null($this->user_id) && is_null($this->post_id) && !is_null($this->condolence_id),
        );
    }

    /**
     * Check if is ad offer
     *
     * @return Attribute
     */
    protected function isAdOffer(): Attribute
    {
        return Attribute::make(
            get: fn() => !is_null($this->company_id) && !is_null($this->ad_id) &&
                is_null($this->condolence_id) && is_null($this->user_id) && is_null($this->post_id),
        );
    }

    /**
     * Check if is post offer
     *
     * @return Attribute
     */
    protected function isPostOffer(): Attribute
    {
        return Attribute::make(
            get: fn() => !is_null($this->post_id) && !is_null($this->user_id) &&
                is_null($this->company_id) && is_null($this->ad_id) && is_null($this->condolence_id),
        );
    }
}
