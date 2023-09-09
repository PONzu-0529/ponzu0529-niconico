<?php

namespace App\Services;

use Aws\Credentials\Credentials;
use Aws\Ec2\Ec2Client;
use Exception;
use App\Helpers\SettingHelper;

class AWSService
{
    public string $instance_id;

    private int $ATTEMPT_COUNT = 10;
    private int $WAIT_TIME = 5;

    private Ec2Client $ec2Client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCredentials();
    }

    /**
     * Get AWS EC2 Instance Status
     *
     * @param string $instance_id Instance ID
     * @return void
     */
    public function isInstanceState(string $instance_id, string $desiredState = 'running'): bool
    {
        try {
            $result = $this->ec2Client->describeInstances([
                'InstanceIds' => [$instance_id]
            ]);
        } catch (Exception $ex) {
            throw new Exception('EC2 Instance ID is Invalid.');
        }

        $state = $result['Reservations'][0]['Instances'][0]['State']['Name'];

        return $state == $desiredState;
    }

    /**
     * Start EC2 Instance
     *
     * @param string $instance_id Instance ID
     * @return void
     */
    public function startInstance(string $instance_id): void
    {
        if ($this->isInstanceState($instance_id)) {
            return;
        }

        $startParams = [
            'InstanceIds' => [$instance_id],
        ];

        try {
            $this->ec2Client->startInstances($startParams);

            $attempts = 0;

            while ($attempts < $this->ATTEMPT_COUNT) {
                if ($this->isInstanceState($instance_id)) {
                    return;
                }

                sleep($this->WAIT_TIME);
                $attempts++;
            }
        } catch (Exception $ex) {
            throw new Exception('Failed to Start Instance.');
        }

        throw new Exception('Failed to Start Instance.');
    }

    /**
     * Start Instance from Template
     *
     * @param string $template_name Template Name
     * @return string Instance ID
     */
    public function startInstanceFromTemplate(string $template_name): string
    {
        try {
            $response = $this->ec2Client->runInstances([
                'LaunchTemplate' => [
                    'LaunchTemplateName' => $template_name,
                    'Version' => '$Latest'
                ],
                'MaxCount' => 1,
                'MinCount' => 1
            ]);

            $this->instance_id = $response->get('Instances')[0]['InstanceId'];

            $attempts = 0;

            while ($attempts < $this->ATTEMPT_COUNT) {
                if ($this->isInstanceState($this->instance_id)) {
                    return $this->instance_id;
                }

                sleep($this->WAIT_TIME);

                $attempts++;
            }
        } catch (Exception $ex) {
            throw new Exception('Failed to Start Instance.');
        }

        throw new Exception('Failed to Start Instance.');
    }

    /**
     * Terminate Instance
     *
     * @return void
     */
    public function terminateInstance(): void
    {
        if ($this->isInstanceState($this->instance_id, 'terminated')) {
            return;
        }

        $stopParams = [
            'InstanceIds' => [$this->instance_id],
        ];

        try {
            $this->ec2Client->terminateInstances($stopParams);

            $attempts = 0;

            while ($attempts < $this->ATTEMPT_COUNT) {
                if ($this->isInstanceState($this->instance_id, 'terminated')) {
                    return;
                }

                sleep(5);
                $attempts++;
            }
        } catch (Exception $e) {
            throw new Exception('Failed to Terminate Instance.');
        }

        throw new Exception('Failed to Terminate Instance.');
    }

    /**
     * Stop EC2 Instance
     *
     * @param string $instance_id Instance ID
     * @return void
     */
    public function stopInstance(string $instance_id): void
    {
        if ($this->isInstanceState($instance_id, 'stopped')) {
            return;
        }

        $stopParams = [
            'InstanceIds' => [$instance_id],
        ];

        try {
            $this->ec2Client->stopInstances($stopParams);

            $attempts = 0;

            while ($attempts < $this->ATTEMPT_COUNT) {
                if ($this->isInstanceState($instance_id, 'stopped')) {
                    return;
                }

                sleep(5);
                $attempts++;
            }
        } catch (Exception $e) {
            throw new Exception('Failed to Stop Instance.');
        }

        throw new Exception('Failed to Stop Instance.');
    }

    /**
     * Get EC2 Instance IP Address
     *
     * @param string $instance_id Instance ID
     * @return string IP Address
     */
    public function getInstanceIPAddress(string $instance_id = ''): string
    {
        if ($instance_id === '') {
            $instance_id = $this->instance_id;
        }

        if (!$this->isInstanceState($instance_id)) {
            throw new Exception('This Instance is Not Running.');
        }

        $params = [
            'InstanceIds' => [$instance_id],
        ];

        $result = $this->ec2Client->describeInstances($params);
        $ipAddress = $result['Reservations'][0]['Instances'][0]['PublicIpAddress'];

        return $ipAddress;
    }

    /**
     * Set AWS Settings
     *
     * @return void
     */
    private function setCredentials(): void
    {
        $region = SettingHelper::getSettingValue('AWS_DEFAULT_REGION');
        $credentials = new Credentials(
            SettingHelper::getSettingValue('AWS_ACCESS_KEY_ID'),
            SettingHelper::getSettingValue('AWS_SECRET_ACCESS_KEY')
        );

        $this->ec2Client = new Ec2Client([
            'version' => 'latest',
            'region' => $region,
            'credentials' => $credentials
        ]);
    }
}
