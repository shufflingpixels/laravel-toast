# Laravel Toast

Lightweight toast backend with session flash support for Laravel. 

It lets you create, collect, and flash toast messages on the backend, while leaving 
full control over how you render them on the frontend. 
Pair it with your preferred UI, or use our suggested Livewire/Tailwind frontend.

## Frontends

* `shufflingpixels/laravel-toast-flux` (Livewire Flux + Tailwind + Alpine).

## Requirements

- PHP 8.1+
- Laravel 10+ (or `illuminate/support` >= 10)

## Installation

```bash
composer require shufflingpixels/laravel-toast
```

The service provider and facade alias are auto-discovered. You can use the facade `Toast` immediately.

## Concepts

- Message: a typed object with `severity`, `text`, optional `details`, and `duration` (ms).
- Manager: collects messages during a request and can flash a single message across redirects via session.
- Severities: `info`, `success`, `warning`, `error`.

## Quick Start

Createa toast message in a controller action:

```php
use ShufflingPixels\Toast\Toast;

public function store()
{
    Toast::success('Saved successfully');

    return view('profile');
}
```

In your Blade view, pull messages and render them however you like:

```blade
@php($messages = \ShufflingPixels\Toast\Toast::getMessages())

@if ($messages->isNotEmpty())
    <div class="fixed inset-0 pointer-events-none">
        @foreach ($messages as $message)
            <div class="pointer-events-auto">
                <h3>{{ $message->text }}</h3>
                @if ($message->details)
                    <p>{{ $message->details }}</p>
                @endif
            </div>
        @endforeach
    </div>
@endif
```

or use one of the frontent packages

## Flash Across Redirects

To show a toast on the next request (after redirect), flash the message:

```php
use Toast;

public function update()
{
    Toast::success('Profile updated')->flash();

    return redirect()->route('profile.show');
}
```

On the subsequent request, call `Toast::getMessages()` in your layout or view; flashed messages are merged into the in-memory collection and cleared from the session automatically.

## Helper Function

This package provides a global `toast()` helper that returns the manager. If you pass a severity and text, it will create the message immediately.

```php
use ShufflingPixels\Toast\Severity;

// Get the manager and add messages fluently
toast()->info('Heads up');
toast()->success('Saved', 'All changes are synced', 5000);

// Create immediately via helper (one-liner)
toast(Severity::ERROR, 'Something went wrong', 'Please try again');

// Flash a specific message for the next request
toast()->warning('Requires attention')->flash();
```

Helper signature:

```php
function toast(?Severity $severity = null, ?string $text = null, ?string $details = null, int $duration = 3000): \ShufflingPixels\Toast\Manager
```

## API Reference

Facade:

```php

use ShufflingPixels\Toast\Toast;

// Create messages (returns Message)
Toast::info(string $text, ?string $details = null, int $duration = 3000);
Toast::success(string $text, ?string $details = null, int $duration = 3000);
Toast::warning(string $text, ?string $details = null, int $duration = 3000);
Toast::error(string $text, ?string $details = null, int $duration = 3000);
Toast::new(Severity $severity, string $text, ?string $details = null, int $duration = 3000);

// Flash a single message to session
Toast::flash(\ShufflingPixels\Toast\Message $message): void;

// Retrieve all messages for the current request
Toast::getMessages(): Illuminate\Support\Collection<int, \ShufflingPixels\Toast\Message>;

// Retrieve flashed messages without merging
Toast::getFlashMessages(): Illuminate\Support\Collection<int, \ShufflingPixels\Toast\Message>;
```

Message object:

```php
new Message(Severity $severity, string $text, ?string $details = null, int $duration = 3000);

// Chainable setters
$message->severity(Severity::SUCCESS)
        ->text('Saved')
        ->details('All good')
        ->duration(3000)
        ->flash();
```

Severities enum:

```php
Severity::INFO
Severity::SUCCESS
Severity::WARN   // alias value: "warning"
Severity::ERROR
```

## Blade Stubs (Optional)

The package ships minimal Blade stubs you can copy and adapt:

- `src/stubs/container.blade.php` – loops over `Toast::getMessages()` and renders each message via a component.
- `src/stubs/message.blade.php` – minimal message markup.

Feel free to inline the logic in your layout or create your own Blade components.

## Notes

- Default duration is `3000` ms; use it to control how long a toast should stay visible on the frontend.
- Flashed messages are stored under the session key `shufflingpixels.toast.flash` and are cleared when read via `getMessages()`.
- This package does not include any JavaScript; you own the presentation and dismissal logic.

