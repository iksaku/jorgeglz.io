<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;

class ImportEmoji extends Command
{
    const EMOJI_DATA_ENDPOINT = 'https://api.github.com/emojis';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emoji:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Emoji reference data from Github API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        /** @var Client $client */
        $client = new Client();

        try {
            /** @var ResponseInterface $response */
            $response = $client->request('GET', self::EMOJI_DATA_ENDPOINT);
        } catch (GuzzleException $e) {
            $this->error('Unable to update emoji data. For more information please refer to the logs.');
            logger()->error("Unable to update emoji data:\n" . $e->getMessage());
            return false;
        }

        $data = $response->getBody();

        file_put_contents(base_path('resources/emoji.json'), (string) $data);

        $this->info('Successfully updated emoji data.');
        logger()->info('Successfully updated emoji data.');

        return true;
    }
}
