<?php
namespace App\Http\Controllers;

use Illuminate\Session\Store as Session;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected Session $session;

    public function __construct(Session $session) {
        $this->session = $session;
    }

    public function show(Request $request)
    {
        $type = $request->input('type');
        $title = $request->input('title');
        $message = $request->input('message');

        // Logic to handle notifications, e.g., saving to session or broadcasting
        session()->flash('notify', [
            'type' => $type,
            'title' => $title,
            'message' => $message
        ]);

        return response()->json(['success' => true]);
    }

    public function success(string $message, string $title = 'Success'): self
    {
        $this->flash($message, 'success', null, null, $title);

        return $this;
    }

    public function danger(string $message, string $title = 'Error'): self
    {
        $this->flash($message, 'danger', null, null, $title);

        return $this;
    }

    public function info(string $message, string $title = 'Info'): self
    {
        $this->flash($message, 'info', null, null, $title);

        return $this;
    }

    public function warning(string $message, string $title = 'Warning'): self
    {
        $this->flash($message, 'warning', null, null, $title);

        return $this;
    }

    public function flash(string $message, string $type = null, string $icon = null, string $model = null, string $title = null): void
    {
        $notifications = [
            'message' => $message,
            'type' => $type,
            'icon' => $icon,
            'model' => $model,
            'title' => $title,
        ];

        $this->session->flash('notify', $notifications);
    }

    public function message(): string
    {
        return $this->session->get('notify.message');
    }

    public function type(): string
    {
        return $this->session->get('notify.type');
    }

    public function title(): ?string
    {
        return $this->session->get('notify.title');
    }
}