<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\QueueMonitoring;

use Exception;
use Piwik\Plugins\QueuedTracking\Queue;
use Piwik\Plugins\QueuedTracking\SystemCheck;

use function sprintf;

/**
 * Exports queue status for Prometheus.
 */
class API extends \Piwik\Plugin\API
{
    /**
     * Prometheus export method
     * /index.php?module=API&method=QueueMonitoring.getQueueMetrics&format=original
     *
     * @return string
     * @throws Exception
     */
    public function getQueueMetrics(): string
    {
        $settings = Queue\Factory::getSettings();

        if ($settings->isRedisBackend()) {
            $systemCheck = new SystemCheck();
            $systemCheck->checkRedisIsInstalled();
        }

        $backend = Queue\Factory::makeBackend();
        $manager = Queue\Factory::makeQueueManager($backend);
        $queues  = $manager->getAllQueues();

        $result = '';
        foreach ($queues as $queue) {
            $result .= sprintf(
                "matomo_queued_requests{id=\"%u\"} %u\n",
                $queue->getId(),
                $queue->getNumberOfRequestSetsInQueue(),
            );
        }

        return $result;
    }
}
