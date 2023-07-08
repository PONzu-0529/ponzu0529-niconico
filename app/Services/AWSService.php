<?php

namespace App\Services;

use Exception;
use App\Helpers\SettingHelper;

class AWSService
{
    /**
     * Get AWS EC2 Instance Status
     *
     * @param string $instance_id Instance ID
     * @return void
     */
    public function getInstanceStatus(string $instance_id): void
    {
        $this->setSettings();

        exec("aws ec2 describe-instance-status --instance-ids \"{$instance_id}\"", $output_list);

        if (count($output_list) === 0) {
            throw new Exception('EC2 Instance ID is Invalid.');
        }

        $output_json = str_replace(' ', '', implode('', $output_list));

        $output = json_decode($output_json, true);

        var_dump($output);
    }

    /**
     * Set AWS Settings
     *
     * @return void
     */
    private function setSettings(): void
    {
        putenv('AWS_DEFAULT_REGION=' . SettingHelper::getSettingValue('AWS_DEFAULT_REGION'));
        putenv('AWS_ACCESS_KEY_ID=' . SettingHelper::getSettingValue('AWS_ACCESS_KEY_ID'));
        putenv('AWS_SECRET_ACCESS_KEY=' . SettingHelper::getSettingValue('AWS_SECRET_ACCESS_KEY'));
    }
}
