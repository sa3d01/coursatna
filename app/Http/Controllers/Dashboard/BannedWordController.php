<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\BannedWordStoreRequest;
use App\Http\Requests\Dashboard\BannedWordUpdateRequest;
use App\Models\BannedWord;
use App\Http\Controllers\Controller;

class BannedWordController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BannedWord::class, 'banned_word');
    }

    public function index()
    {
        return view('dashboard.banned-words.index')
            ->with('bannedWords', BannedWord::orderBy('id', 'desc')->paginate())
            ->with('total', BannedWord::count())
            ->with('indexUrl', route('dashboard.banned-words.index'));
    }

    public function create()
    {
        return view('dashboard.banned-words.create');
    }

    public function store(BannedWordStoreRequest $request)
    {
        BannedWord::create($request->validated());
        return redirect()->route('dashboard.banned-words.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(BannedWord $bannedWord)
    {
        return redirect()->route('dashboard.banned-words.edit', $bannedWord['id']);
    }

    public function edit(BannedWord $bannedWord)
    {
        return view('dashboard.banned-words.edit')
            ->with('bannedWord', $bannedWord);
    }

    public function update(BannedWordUpdateRequest $request, BannedWord $bannedWord)
    {
        $bannedWord->update($request->validated());
        return redirect()->route('dashboard.banned-words.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(BannedWord $bannedWord)
    {
        $bannedWord->delete();
        return redirect()->route('dashboard.banned-words.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
