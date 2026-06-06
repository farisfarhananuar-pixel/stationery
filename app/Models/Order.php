<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'seller_id', 'total_amount',
        'shipping_address', 'phone', 'payment_status', 'receipt_image',
        'payment_note', 'amount_transferred', 'delivery_status',
        'tracking_number', 'delivery_note', 'delivered_at'
    ];

    protected $casts = ['delivered_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function seller() { return $this->belongsTo(User::class, 'seller_id'); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public static function generateOrderNumber() {
        return 'ORD-' . strtoupper(uniqid());
    }

    public function paymentStatusBadge() {
        return match($this->payment_status) {
            'pending' => '<span class="badge bg-warning">Pending Payment</span>',
            'receipt_uploaded' => '<span class="badge bg-info">Receipt Uploaded</span>',
            'approved' => '<span class="badge bg-success">Payment Approved</span>',
            'rejected' => '<span class="badge bg-danger">Payment Rejected</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function deliveryStatusBadge() {
        return match($this->delivery_status) {
            'pending' => '<span class="badge bg-secondary">Pending</span>',
            'processing' => '<span class="badge bg-warning">Processing</span>',
            'shipped' => '<span class="badge bg-info">Shipped</span>',
            'delivered' => '<span class="badge bg-success">Delivered</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
