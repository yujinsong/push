<?php
/**
 * Created by PhpStorm.
 * User: Sway
 * Date: 16/10/26
 * Time: 下午2:40
 */

namespace App\Http\Service;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;

/**
 * 日志记录工具
 *
 * Class LogUtil
 * @package App\Http\Controllers\service
 */
class LogService
{
    private static $file_path = '/var/log/sway';
    private static $date_format = 'Y-m-d H:i:s';
    private static $output_format = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";

    private static $logger = false;

    private function __construct() {}

//    public static function getInstance() {
//        if (self::$logger === false) {
//            $date = date("Y-m-d");
//            $formatter = new LineFormatter(self::$output_format, self::$date_format);
//            $info_path = self::$file_path . '/' . $date . '.info.log';
//            $error_path = self::$file_path . '/' . $date . '.error.log';
//
//            $info_handler = new StreamHandler($info_path, Logger::INFO, true, 0777);
//            $err_handler = new StreamHandler($error_path, Logger::ERROR, true, 0777);
//
//            $info_handler->setFormatter($formatter);
//            $err_handler->setFormatter($formatter);
//
//            self::$logger = new Logger('push');
//            self::$logger->pushProcessor(new IntrospectionProcessor(Logger::INFO));
//
//            self::$logger->pushHandler($info_handler);
//            self::$logger->pushHandler($err_handler);
//        }
//
//        return self::$logger;
//    }

    public static function getInstance() {
        if (self::$logger === false) {
            $formatter = new LineFormatter(self::$output_format, self::$date_format);

            $stdout_handler = new StreamHandler('php://stdout', Logger::DEBUG);
            $stderr_handler = new StreamHandler('php://stderr', Logger::ERROR);
            $stdout_handler->setFormatter($formatter);
            $stderr_handler->setFormatter($formatter);

            self::$logger = new Logger('push');
            self::$logger->pushHandler($stdout_handler);
            self::$logger->pushHandler($stderr_handler);
        }
        return self::$logger;
    }
}