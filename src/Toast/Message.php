<?php

namespace ShufflingPixels\Toast;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Message implements Arrayable
{
    /**
     * Message severity (info, success, error, warning)
     */
    public Severity $severity;

    /**
     * The message text
     */
    public string $text;

    /**
     * More detailed text.
     */
    public ?string $details;

    /**
     * Duration (in milliseconds) before the message should disappear.
     */
    public int $duration;

    public function __construct(Severity $severity, string $text, ?string $details = null, int $duration = 3000)
    {
        $this->severity($severity)
            ->text($text)
            ->details($details)
            ->duration($duration);
    }

    public function severity(Severity $severity): self
    {
        $this->severity = $severity;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function details(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function duration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Flash the message.
     *
     * Syntactic sugar for calling the facade's flash() method.
     */
    public function flash(): self
    {
        Toast::flash($this);
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'severity' => $this->severity,
            'text' => $this->text,
            'details' => $this->details,
            'duration' => $this->duration,
        ];
    }
}
