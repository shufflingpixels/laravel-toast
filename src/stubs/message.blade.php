@props([
    'message',
])

<div>
    <h3>{{ $message->text }}</h3>
    @if ($message->details)
    <p>{{ $message->details }}</p>
    @endif 
</div>
