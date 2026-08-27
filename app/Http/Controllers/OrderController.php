<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display Page 3: Order Now with Bangladeshi Payment Methods
     */
    public function index(Request $request)
    {
        $zones = [
            'Shaheb Bazar' => 'Shaheb Bazar & Zero Point',
            'Motihar' => 'Motihar (Rajshahi University Campus)',
            'Kazla' => 'Kazla & Talaimari',
            'Upashahar' => 'Housing Upashahar & Airport Road',
            'Laxmipur' => 'Laxmipur (Medical College Area)',
            'Rani Bazar' => 'Rani Bazar & New Market',
            'Sagarpara' => 'Sagarpara & Alupatti',
            'Bornali' => 'Bornali & Rail Station',
            'Bhodro' => 'Bhodro & Shiroil Bus Terminal',
            'Binodpur' => 'Binodpur & RUET Area',
        ];

        $paymentMethods = [
            [
                'id' => 'bkash',
                'name' => 'bKash (বিকাশ)',
                'badge' => 'Instant 1.5% Cashback',
                'description' => 'Pay seamlessly with your bKash personal or merchant account.',
                'color' => '#e2136e',
                'icon' => '📱'
            ],
            [
                'id' => 'nagad',
                'name' => 'Nagad (নগদ)',
                'badge' => 'Fast & Secure',
                'description' => 'Pay via Nagad digital postal payment gateway.',
                'color' => '#f7941d',
                'icon' => '⚡'
            ],
            [
                'id' => 'rocket',
                'name' => 'Rocket (রকেট - DBBL)',
                'badge' => 'Dutch-Bangla',
                'description' => 'Direct payment using DBBL Rocket wallet 12-digit number.',
                'color' => '#8c3494',
                'icon' => '🚀'
            ],
            [
                'id' => 'upay',
                'name' => 'Upay (ইউপ্রায় - UCB)',
                'badge' => 'UCB Digital',
                'description' => 'Pay quickly using your Upay account.',
                'color' => '#0056b3',
                'icon' => '💎'
            ],
            [
                'id' => 'cod',
                'name' => 'Cash on Delivery (ক্যাশ অন ডেলিভারি)',
                'badge' => 'Pay on Arrival',
                'description' => 'Hand cash directly to our rider after inspecting all fresh items at your doorstep.',
                'color' => '#059669',
                'icon' => '💵'
            ],
            [
                'id' => 'card',
                'name' => 'Debit / Credit Card (SSLCommerz)',
                'badge' => 'Visa / Mastercard',
                'description' => 'Supports all Bangladeshi bank Visa, Mastercard, and Amex cards.',
                'color' => '#1e293b',
                'icon' => '💳'
            ],
        ];

        return view('order', [
            'zones' => $zones,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Handle Order Submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'zone' => 'required|string',
            'address' => 'required|string|max:255',
            'delivery_slot' => 'required|string',
            'payment_method' => 'required|string',
            'items_data' => 'nullable|string',
            'order_total' => 'nullable|numeric',
        ]);

        $orderId = 'RJS-' . rand(10000, 99999);
        $orderTotal = floatval($request->input('order_total', 560));
        $deliveryFee = $orderTotal >= 500 ? 0 : 50;
        $grandTotal = $orderTotal + $deliveryFee;

        return view('order-confirmation', [
            'orderId' => $orderId,
            'customerName' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'zone' => $validated['zone'],
            'address' => $validated['address'],
            'deliverySlot' => $validated['delivery_slot'],
            'paymentMethod' => $validated['payment_method'],
            'orderTotal' => $orderTotal,
            'deliveryFee' => $deliveryFee,
            'grandTotal' => $grandTotal,
            'createdAt' => now()->format('d M Y, h:i A')
        ]);
    }
}
