# Matomo QueueMonitoring Plugin

## Description

This plugin provides a Matomo API call to generate the export of the tracking queue status for Prometheus.

## Call it
It is important to use the `format=original` parameter, to get correct format. If it is missing, or it's set to some
other value, Matomo will wrap the output into something, and it will not work with Prometheus.

Example: `https://matomo.makaira.io/index.php?module=API&method=QueueMonitoring.getQueueMetrics&format=original`
This will output something like
```text
matomo_queued_requests{id=0} 2
matomo_queued_requests{id=1} 0
matomo_queued_requests{id=2} 0
matomo_queued_requests{id=3} 0
matomo_queued_requests{id=4} 0
matomo_queued_requests{id=5} 16
matomo_queued_requests{id=6} 0
matomo_queued_requests{id=7} 0
```
