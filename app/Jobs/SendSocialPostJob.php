<?php

namespace App\Jobs;

use App\Models\SocialConnection;
use App\Services\SocialPlatformManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
// Exception class might be needed if we re-throw exceptions
// use Exception;

class SendSocialPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public SocialConnection $connection;
    public string $targetId;
    public array $postData; // Changed from message and options

    /**
     * Create a new job instance.
     *
     * @param SocialConnection $connection
     * @param string $targetId
     * @param array $postData
     * @return void
     */
    public function __construct(SocialConnection $connection, string $targetId, array $postData)
    {
        $this->connection = $connection;
        $this->targetId = $targetId;
        $this->postData = $postData;
    }

    /**
     * Execute the job.
     *
     * @param SocialPlatformManager $platformManager
     * @return void
     */
    public function handle(SocialPlatformManager $platformManager)
    {
        Log::info("SendSocialPostJob: Attempting to post.", [
            'platform' => $this->connection->platform,
            'connection_id' => $this->connection->id,
            'target_id' => $this->targetId,
            'post_type' => $this->postData['type'] ?? 'unknown',
            'message_preview' => Str::limit($this->postData['text'] ?? '', 50) // Use Illuminate\Support\Str
        ]);

        $platformValue = is_string($this->connection->platform) ? $this->connection->platform : $this->connection->platform->value;
        $platformService = $platformManager->resolve($platformValue);

        // Call the generic 'post' method on the service
        $result = $platformService->post($this->connection, $this->targetId, $this->postData);

        if (!empty($result['error'])) {
            Log::error(
                "SendSocialPostJob: Failed to post to {$platformValue} target {$this->targetId} (Type: {$this->postData['type'] ?? 'unknown'}): " . ($result['message'] ?? 'Unknown error'),
                [
                    'details' => $result['details'] ?? [],
                    'connection_id' => $this->connection->id,
                    'target_id' => $this->targetId,
                ]
            );
            // Optionally throw an exception to allow the queue to retry based on its configuration
            // For example: throw new \Exception($result['message'] ?? "Failed to post to {$platformValue}");
        } else {
            Log::info(
                "SendSocialPostJob: Successfully posted to {$platformValue} target {$this->targetId} (Type: {$this->postData['type'] ?? 'unknown'}).",
                [
                    'post_id' => $result['data']['id'] ?? 'N/A',
                    'connection_id' => $this->connection->id,
                    'target_id' => $this->targetId,
                ]
            );
        }
    }
}
