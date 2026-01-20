<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = []; // Sudah benar, mengizinkan semua kolom diisi

    protected $table = 'tickets';

    // Auto generate nomor tiket IT-YYYYMMDD-0001
    protected static function booted()
    {
        static::creating(function ($ticket) {
            $date = now()->format('Ymd');
            $count = self::whereDate('created_at', now()->toDateString())->count() + 1;
            $ticket->nomor_tiket = 'IT-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi ke User (Pelapor)
    public function user()
    {
        // Sesuaikan jika foreign key di tabel tickets adalah 'user_id'
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Teknisi (Optional jika ingin pakai relasi)
    public function teknisiUser()
    {
        return $this->belongsTo(USERLOG_ID::class, 'teknisi_id', 'ID');
    }
}