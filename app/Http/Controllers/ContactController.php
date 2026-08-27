<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display Page 4: Contact Us & Rajshahi Customer Support
     */
    public function index(Request $request)
    {
        $faqs = [
            [
                'question' => 'How fast is grocery delivery in Rajshahi city?',
                'answer' => 'Our local delivery riders deliver groceries within 45 to 60 minutes across Shaheb Bazar, Kazla, Motihar, Upashahar, and surrounding areas in Rajshahi.'
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept bKash (with 1.5% cashback), Nagad, DBBL Rocket, Upay, Visa/Mastercard, and Cash on Delivery (COD).'
            ],
            [
                'question' => 'What if the vegetables, fruits, or fish are not fresh upon delivery?',
                'answer' => 'We offer an instant 100% replacement or full refund guarantee. You can inspect all items before paying our rider.'
            ],
            [
                'question' => 'Is there any minimum order requirement for free delivery?',
                'answer' => 'Delivery is 100% FREE for all orders above ৳500 across Rajshahi city. For orders below ৳500, a minimal delivery charge of ৳50 applies.'
            ],
            [
                'question' => 'Can I order directly by phone call or WhatsApp?',
                'answer' => 'Yes! You can call our hotline at +880 1712-345678 or message our dedicated WhatsApp number at +880 1812-987654 anytime between 7:00 AM and 10:00 PM.'
            ]
        ];

        return view('contact', [
            'faqs' => $faqs,
            'successMessage' => session('success')
        ]);
    }

    /**
     * Handle Contact Message Submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        return redirect()->route('contact')->with(
            'success', 
            'ধন্যবাদ! আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে। আমাদের রাজশাহী টিম দ্রুত আপনার সাথে যোগাযোগ করবে।'
        );
    }
}
