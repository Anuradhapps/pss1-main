<?php

namespace App\Services;

use GuzzleHttp\Client;

class TextCorrectionService
{
    /**
     * Correct text: spacing, capitalization, grammar
     *
     * @param string $text
     * @param bool $useAI Whether to use OpenAI for advanced correction
     * @return string
     */
    public function correctText(string $text, bool $useAI = false): string
    {
        // 1️⃣ Fix extra spaces
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        // 2️⃣ Capitalize first letter of sentences
        $text = preg_replace_callback('/([.!?]\s*|^)([a-z])/', function ($matches) {
            return $matches[1] . strtoupper($matches[2]);
        }, $text);

        // 3️⃣ Optional AI grammar correction
        if ($useAI) {
            $text = $this->correctWithAI($text);
        }

        return $text;
    }

    /**
     * Use OpenAI API to correct grammar and improve text
     *
     * @param string $text
     * @return string
     */
    protected function correctWithAI(string $text): string
    {
        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "model" => "gpt-4-mini",
                "messages" => [
                    ["role" => "user", "content" => "Correct grammar, spacing, and make this text perfect: $text"]
                ],
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        return $result['choices'][0]['message']['content'] ?? $text;
    }
}
