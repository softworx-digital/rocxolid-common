<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;

/**
 * CommandLog model.
 * Serves to log execution process of (Artisan) commands.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class CommandLog extends AbstractCrudModel
{
    use SoftDeletes;

    /**
     * Container to log messages.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $message_bag;

    /**
     * Container to log processing errors.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $error_bag;

    /**
     * {@inheritDoc}
     */
    protected $system = [
        'id',
        'caller',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        // 'caller',
        'command',
        'arguments',
        'options',
        'state',
        'started_at',
        'finished_at',
        'message',
        'error',
    ];

    /**
     * {@inheritDoc}
     */
    protected $dates = [
        'started_at',
        'finished_at',
    ];

    public function getTitle(): string
    {
        return sprintf('[%s] @ [%s]', $this->command, $this->started_at->toDateString());
    }

    /**
     * Add message to message bag.
     *
     * @param string $message
     * @return self
     */
    public function addMessage(string $message): self
    {
        $this->message_bag = $this->message_bag ?? collect();
        $this->message_bag->push($message);

        return $this;
    }

    /**
     * Obtain JSON formatted message bag to be persisted.
     *
     * @return string
     */
    public function getJsonMessages(): string
    {
        return collect($this->message_bag ?: [])->toJson();
    }

    /**
     * Add error to error bag.
     *
     * @param string $message
     * @return self
     */
    public function addError(string $error): self
    {
        $this->error_bag = $this->error_bag ?? collect();
        $this->error_bag->push($error);

        return $this;
    }

    /**
     * Obtain JSON formatted error bag to be persisted.
     *
     * @return string
     */
    public function getJsonErrors(): string
    {
        return collect($this->error_bag ?: [])->toJson();
    }

    /**
     * Messages attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getMessageAttribute($value): Collection
    {
        return collect($value ? json_decode($value) : [])->filter();
    }

    /**
     * Errors attribute getter mutator.
     *
     * @param mixed $value
     * @return \Illuminate\Support\Collection
     */
    public function getErrorAttribute($value): Collection
    {
        return collect($value ? json_decode($value) : [])->filter();
    }

    /**
     * Check if the command ended successfully.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return collect($this->error_bag ?: [])->isEmpty();
    }

    /**
     * {@inheritDoc}
     */
    public function canBeCreated(Request $request): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function lastRun(): ?self
    {
        return static::where('command', $this->command)->orderBy('started_at', 'desc')->first();
    }
}
