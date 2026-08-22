<?php

namespace App\Http\Controllers;

use App\Events\EchoTestMessage;
use App\Http\Requests\BroadcastEchoTestMessageRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EchoTestController extends Controller
{
    public function send(): View
    {
        return view('echo.send');
    }

    public function receive(): View
    {
        return view('echo.receive');
    }

    public function broadcast(BroadcastEchoTestMessageRequest $request): RedirectResponse
    {
        broadcast(new EchoTestMessage($request->validated('message')));

        return back()->with('status', __('Message broadcast.'));
    }
}
