<?php

namespace App\SimpleFactory;

class LogFactory
{
    const FILE_LOG = 1;

    const MONGO_LOG = 2;

    public function getLogger(string $logType): Log
    {
        if ($logType == self::MONGO_LOG) {
            return new MongoLog();
        }

        return new FileLog();
    }
}
