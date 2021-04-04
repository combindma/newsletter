<?php

namespace Combindma\Newsletter\Http\Controllers;

use Combindma\Newsletter\Http\Requests\NewsletterRequest;
use Combindma\Newsletter\Models\NewsletterSubscription;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscription::withTrashed()->latest('id')->paginate(10);

        return view('newsletter::.index', compact('subscribers'));
    }

    public function store(NewsletterRequest $request)
    {
        NewsletterSubscription::create($request->validated());
        flash(__('newsletter::messages.created'));

        return redirect(route('newsletter::newsletter.index'));
    }

    public function edit(NewsletterSubscription $subscriber)
    {
        return view('newsletter::.edit', compact('subscriber'));
    }

    public function update(NewsletterRequest $request, NewsletterSubscription $subscriber)
    {
        $subscriber->update($request->validated());
        flash(__('newsletter::messages.updated'));

        return back();
    }

    public function destroy(NewsletterSubscription $subscriber)
    {
        $subscriber->delete();
        flash(__('newsletter::messages.deleted'));

        return back();
    }

    public function restore($id)
    {
        NewsletterSubscription::withTrashed()->where('id', $id)->restore();
        flash(__('newsletter::messages.restored'));

        return back();
    }
}
