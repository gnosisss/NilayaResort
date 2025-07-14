<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyDocument extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'document_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'document_type',
        'file_path',
        'file_name',
        'file_extension',
        'file_size',
        'status',
        'notes',
        'purchase_id',
    ];

    /**
     * The document types that can be uploaded.
     *
     * @var array<int, string>
     */
    public static $documentTypes = [
        'KTP' => 'Kartu Tanda Penduduk',
        'KK' => 'Kartu Keluarga',
        'SLIP_GAJI' => 'Slip Gaji',
        'NPWP' => 'Nomor Pokok Wajib Pajak',
        'REKENING_KORAN' => 'Rekening Koran',
        'SURAT_KETERANGAN_KERJA' => 'Surat Keterangan Kerja',
        'OTHER' => 'Dokumen Lainnya',
    ];

    /**
     * Get the user that owns the document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the property purchase that the document belongs to.
     */
    public function propertyPurchase(): BelongsTo
    {
        return $this->belongsTo(PropertyPurchase::class, 'purchase_id', 'purchase_id');
    }
}