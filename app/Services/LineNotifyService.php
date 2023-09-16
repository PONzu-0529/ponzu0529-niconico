<?php

namespace App\Services;

use Exception;
use App\Helpers\SettingHelper;

class LineNotifyService
{
    /**
     * Send Log Notify
     *
     * @param string $message Message
     * @return void
     */
    public function sendLogNotify(string $message): void
    {
        $accessToken = SettingHelper::getSettingValue('LINE_NOTIFY_LOG_ACCESS_TOKEN');

        $this->sendNotify($accessToken, $message);
    }

    /**
     * Send Error Log Notify
     *
     * @param string $message Message
     * @return void
     */
    public function sendErrorLogNotify(string $message): void
    {
        $accessToken = SettingHelper::getSettingValue('LINE_NOTIFY_ERROR_ACCESS_TOKEN');

        $this->sendNotify($accessToken, $message);
    }

    /**
     * Send LINE Notify
     *
     * @param string $accessToken Access Token
     * @param string $message Message
     * @return void
     */
    private function sendNotify(string $accessToken, string $message): void
    {
        $ch = curl_init("https://notify-api.line.me/api/notify");
        $header = [
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer $accessToken"
        ];
        $query = http_build_query([
            "message" => "\n$message"
        ]);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

        try {
            $response = curl_exec($ch);
        } catch (Exception $ex) {
        } finally {
            curl_close($ch);
        }
    }
}
