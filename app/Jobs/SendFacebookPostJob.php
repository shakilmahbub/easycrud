<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SendFacebookPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $targetId;
    public string $message;
    public string $accessToken;
    public string $targetType;

    /**
     * Create a new job instance.
     *
     * @param string $targetId
     * @param string $message
     * @param string $accessToken
     * @param string $targetType
     * @return void
     */
    public function __construct(string $targetId, string $message, string $accessToken, string $targetType)
    {
        $this->targetId = $targetId;
        $this->message = $message;
        $this->accessToken = $accessToken;
        $this->targetType = $targetType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Note: For local development, if the queue driver is 'sync', this job will execute immediately.
        // For background processing, configure a different queue driver (e.g., database, Redis)
        // and run a queue worker: `php artisan queue:work`

        $endpointUrl = "https://graph.facebook.com/v19.0/{$this->targetId}/feed";
        $requestData = [
            'message' => $this->message,
            'access_token' => $this->accessToken,
        ];

        Log::info("Attempting to post to Facebook via Job.", [
            'target_id' => $this->targetId,
            'target_type' => $this->targetType,
            'message_length' => strlen($this->message)
        ]);

        try {
            $response = Http::post($endpointUrl, $requestData);

            if ($response->successful()) {
                Log::info('Post successfully submitted to Facebook via Job.', [
                    'target_id' => $this->targetId,
                    'target_type' => $this->targetType,
                    'response_id' => $response->json()['id'] ?? 'N/A',
                ]);
                // Optionally, you could dispatch another event here, e.g., PostSuccessful,
                // or update a local status if you store posts before sending.
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? 'Unknown Facebook API error.';
                Log::error('Facebook Post Error via Job: ', [
                    'target_id' => $this->targetId,
                    'target_type' => $this->targetType,
                    'response_status' => $response->status(),
                    'response_body' => $errorData ?: $response->body(),
                ]);
                // Decide on retry strategy:
                // For some errors (e.g., temporary issues), you might throw an exception to let the queue retry.
                // $this->release(60); // Release back to queue to retry after 60 seconds
                // Or throw new Exception($errorMessage);
                // For permanent errors (e.g., auth issues, bad request), logging might be sufficient.
            }
        } catch (Exception $e) {
            Log::error('Exception during Facebook post job: ', [
                'target_id' => $this->targetId,
                'target_type' => $this->targetType,
                'exception_message' => $e->getMessage(),
                // Avoid logging full trace in production for potentially many job failures,
                // but useful for debugging. Consider conditional logging.
                // 'exception_trace' => $e->getTraceAsString(),
            ]);
            // throw $e; // Re-throw to let the queue handle it as a failed job (retry/dead-letter)
        }
    }
}
