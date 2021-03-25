<?php

namespace Softworx\RocXolid\Common\Models\Traits\Logging;

use Carbon\Carbon;
use Illuminate\Console\Command;
// rocXolid common model contracts
use Softworx\RocXolid\Common\Models\Contracts\CommandLoggable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\CommandLog;

/**
 * Trait to log command execution.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
trait CanLogCommand
{
    /**
     * Command log reference.
     *
     * @var \Softworx\RocXolid\Common\Models\CommandLog
     */
    protected $command_log;

    /**
     * Initialize command logging.
     *
     * @return \Softworx\RocXolid\Common\Models\Contracts\CommandLoggable
     */
    protected function initCommandLogging(Command $command, ?array $arguments = null, ?array $options = null): CommandLoggable
    {
        $this->command_log = CommandLog::create([
            'command' => get_class($command),
            'arguments' => $arguments ? collect($arguments)->toJson() : null,
            'options' => $options ? collect($options)->toJson() : null,
            'started_at' => now(),
            'state' => 'running',
        ]);

        return $this;
    }

    /**
     * Finish command logging.
     *
     * @return \Softworx\RocXolid\Common\Models\Contracts\CommandLoggable
     */
    protected function finishCommandLogging(): CommandLoggable
    {
        $this->command_log->update([
            'finished_at' => now(),
            'state' => $this->command_log->isSuccess() ? 'success' : 'error',
            'message' => $this->command_log->getJsonMessages(),
            'error' => $this->command_log->getJsonErrors(),
        ]);

        return $this;
    }

    /**
     * Add message to message bag.
     *
     * @param string $message
     * @return \Softworx\RocXolid\Common\Models\Contracts\CommandLoggable
     */
    protected function logCommandMessage(string $message): CommandLoggable
    {
        $this->command_log->addMessage($message);

        return $this;
    }

    /**
     * Add error message to error bag.
     *
     * @param string $error
     * @return \Softworx\RocXolid\Common\Models\Contracts\CommandLoggable
     */
    protected function logCommandError(string $error): CommandLoggable
    {
        $this->command_log->addError($error);

        return $this;
    }

    /**
     * Obtain started time of last command.
     *
     * @return \Carbon\Carbon|null
     */
    protected function lastCommandStart(): ?Carbon
    {
        return optional($this->command_log->lastRun())->started_at;
    }
}
