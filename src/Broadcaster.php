<?php

namespace ChaosWs\LaravelChaosBroadcaster;

use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Contracts\Redis\Factory as Redis;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Pusher\Pusher;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * 
 */
class Broadcaster extends PusherBroadcaster
{
    /** @var Redis factory */
	protected $redis;

    /** @var strint redis database */
	protected $connection;

	/**
     * Create a new broadcaster instance.
     *
     * @param  \Illuminate\Contracts\Redis\Factory  $redis
     * @param  string|null  $connection
     * @return void
     */
    public function __construct(Pusher $pusher, Redis $redis, $connection = null)
    {
        $this->redis = $redis;
        $this->connection = $connection;
        parent::__construct($pusher);
    }

	/**
     * Broadcast the given event.
     *
     * @param  array  $channels
     * @param  string  $event
     * @param  array  $payload
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = [])
    {
    	$connection = $this->redis->connection($this->connection);

        $socket = Arr::pull($payload, 'socket') ?? "";

        $post_params = [
        	'event' => $event,
        	'data' => json_encode($payload),
        ];

        foreach ($this->formatChannels($channels) as $channel) {
        	$post_params['channel'] = $channel;
        	$payload = json_encode($post_params);

            // $connection->publish($channel, $payload);
            $connection->executeRaw([
            	'PUBLISH',
            	$channel,
            	$socket,
            	$payload
            ]);
        }
    }
}