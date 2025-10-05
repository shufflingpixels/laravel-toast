<?php

namespace ShufflingPixels\Toast;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class Manager
{
    /**
     * @var Collection<int, Message>
     */
    protected Collection $messages;

    /**
     * Key to use when flashing to session.
     */
    public const SESSION_KEY = 'shufflingpixels.toast.flash';

    public function __construct(protected Session $session)
    {
        $this->messages = collect();
    }

    /**
     * Add a message.
     */
    public function addMessage(Message $message): self
    {
        $this->messages->add($message);

        return $this;
    }

    /**
     * Create a new message and add it to the manager
     */
    public function new(Severity $severity, string $text, ?string $details = null, int $duration = 3000): Message
    {
        $message = new Message($severity, $text, $details, $duration);
        $this->addMessage($message);
        return $message;
    }

    /**
     * Create a message with severity info
     */
    public function info(string $text, ?string $details = null, int $duration = 3000): Message
    {
        return $this->new(Severity::INFO, $text, $details, $duration);
    }

    /**
     * Create a message with severity success
     */
    public function success(string $text, ?string $details = null, int $duration = 3000): Message
    {
        return $this->new(Severity::SUCCESS, $text, $details, $duration);
    }

    /**
     * Create a message with severity warning
     */
    public function warning(string $text, ?string $details = null, int $duration = 3000): Message
    {
        return $this->new(Severity::WARN, $text, $details, $duration);
    }

    /**
     * Create a message with severity error
     */
    public function error(string $text, ?string $details = null, int $duration = 3000): Message
    {
        return $this->new(Severity::ERROR, $text, $details, $duration);
    }

    /**
     * Flash a message
     */
    public function flash(Message $message)
    {
        // Remove the message from the normal collection first.
        $this->messages = $this->messages
            ->reject(fn (Message $item) => $item === $message);

        // Then add it to the session collection
        $this->session->flash(self::SESSION_KEY, 
            $this->getFlashMessages()->add($message)
        );
    }

    /**
     * Get all the flash messages
     *
     * @var Collection<int, Message>
     */
    public function getFlashMessages() : Collection
    {
        return $this->session->get(self::SESSION_KEY, collect([]));
    }

    /**
     * Get all messages
     *
     * @var Collection<int, Message>
     */
    public function getMessages() : Collection
    {
        $flashMessages = $this->getFlashMessages();
        if ($flashMessages->isNotEmpty()) {
            $this->messages = $this->messages->merge(
                $flashMessages
            );
            $this->session->forget(self::SESSION_KEY);
        }
        return $this->messages;
    }
}
