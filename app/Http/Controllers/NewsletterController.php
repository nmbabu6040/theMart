<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;


class NewsletterController extends Controller
{
    // Admin side: Display all subscribers
    // ১. একটিভ সাবস্ক্রাইবার লিস্ট
    public function index(Request $request)
    {
        // ট্যাবের উপর ভিত্তি করে ডাটা লোড হবে
        $tab = $request->get('tab', 'active');

        if ($tab == 'trash') {
            $subscribers = Subscriber::onlyTrashed()->latest()->paginate(10);
        } else {
            $subscribers = Subscriber::latest()->paginate(10);
        }

        $activeCount = Subscriber::count();
        $trashCount = Subscriber::onlyTrashed()->count();

        return view('admin.subscribers.index', compact('subscribers', 'tab', 'activeCount', 'trashCount'));
    }

    // ২. সফট ডিলিট করা (Trash-এ পাঠানো)
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete(); // Soft delete হবে

        return back()->with('success', 'Subscriber moved to trash successfully!');
    }

    // ৩. ট্র্যাশ (Trashed) সাবস্ক্রাইবারদের লিস্ট
    public function trash()
    {
        $subscribers = Subscriber::onlyTrashed()->latest()->paginate(10);
        return view('admin.subscribers.trash', compact('subscribers'));
    }

    // ৪. সফট ডিলিট থেকে রিস্টোর করা
    public function restore($id)
    {
        $subscriber = Subscriber::onlyTrashed()->findOrFail($id);
        $subscriber->restore();

        return back()->with('success', 'Subscriber restored successfully!');
    }

    // ৫. ডাটাবেজ থেকে চিরতরে মুছে ফেলা
    public function forceDelete($id)
    {
        $subscriber = Subscriber::onlyTrashed()->findOrFail($id);
        $subscriber->forceDelete();

        return back()->with('success', 'Subscriber permanently deleted!');
    }
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'You are already subscribed to our newsletter!',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
