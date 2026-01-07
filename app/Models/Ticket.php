<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'tickets';

    /*protected $fillable = [
        'nomor_tiket',
        'user_id',
        'judul',
        'deskripsi',
        'lokasi',
        'prioritas',
        'status',
    ];*/

    // auto generate nomor tiket
    protected static function booted()
    {
        static::creating(function ($ticket) {
            $date = now()->format('Ymd');
            $count = self::whereDate('created_at', now()->toDateString())->count() + 1;
            $ticket->nomor_tiket = 'IT-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }

    // relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
