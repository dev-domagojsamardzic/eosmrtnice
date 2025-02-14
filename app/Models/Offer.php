<?php

namespace App\Models;

use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Response;

/**
 * @property-read       int                 id
 * @property            int                 company_id
 * @property            int                 ad_id
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
 *  ------------------------------------------------------------
 * @property            Company             company
 * @property            Ad                  ad
 * @property            User                user
 * @property            Post                post
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
        return $this->belongsTo(Condolence::class);
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

}
