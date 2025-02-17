<?php

/**
 *   ____             _
 *  / ___|  ___ _ __ | |_ _ __ _   _
 * \___ \ / _ \ '_ \| __| '__| | | |
 *   ___) |  __/ | | | |_| |  | |_| |
 *  |____/ \___|_| |_|\__|_|   \__, |
 *                             |___/
 * MIT License
 *
 * Copyright (c) 2022 alvin0319
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace alvin0319\Sentry;

use pocketmine\utils\MainLogger;
use const PTHREADS_INHERIT_NONE;

final class SentryLogger extends MainLogger{

    private SentryThread $sentryThread;

    public function __construct(string $vendorPath, string $logFile, bool $useFormattingCodes, string $mainThreadName, \DateTimeZone $timezone, bool $logDebug = false){
        parent::__construct($logFile, $useFormattingCodes, $mainThreadName, $timezone, $logDebug);

        $this->sentryThread = new SentryThread($vendorPath);
        $this->sentryThread->start(PTHREADS_INHERIT_NONE);
    }

    public function logException(\Throwable $e, $trace = null){
		parent::logException($e, $trace);
		$this->sentryThread->writeException($e);
	}
}