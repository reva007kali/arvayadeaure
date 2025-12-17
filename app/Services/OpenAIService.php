<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    /**
     * Generate kata-kata mutiara pernikahan
     */
    public static function generateWeddingQuote($groom, $bride, $tone = 'islami', $language = 'id')
    {
        $apiKey = env('OPENAI_API_KEY');

        if (empty($apiKey)) {
            return "Error: API Key OpenAI belum disetting di .env";
        }

        $lang = $language === 'en' ? 'English' : 'Bahasa Indonesia';
        $promptTone = match ($tone) {
            'islami' => "with gentle spiritual undertones inspired by Islamic teachings (do not include Arabic scripture here),",
            'modern' => "modern, natural, and conversational,",
            'formal' => "formal, poetic, and elegant,",
            default => "romantic and natural,",
        };

        $prompt = "Write a short wedding invitation quote (max 32 words) for {$groom} and {$bride}, {$promptTone} heartfelt, in {$lang}. Avoid clichés. Make it feel authentic.";

        try {
            $response = Http::withToken($apiKey)->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a professional wedding quote writer. Keep it natural, warm, and succinct.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 200,
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            } else {
                Log::error('OpenAI Error: ' . $response->body());
                return "Maaf, AI sedang sibuk. Silakan coba lagi nanti.";
            }
        } catch (\Exception $e) {
            Log::error('OpenAI Connection Error: ' . $e->getMessage());
            return "Gagal terhubung ke server AI.";
        }
    }

    /**
     * Generate structured inspiration content: quran, quote, bible
     */
    public static function generateWeddingInspiration($groom, $bride, $mode = 'quote', $language = 'id', array $options = [])
    {
        $apiKey = env('OPENAI_API_KEY');
        if (empty($apiKey)) {
            return [
                'type' => 'error',
                'display_text' => 'Error: API Key OpenAI belum disetting di .env',
            ];
        }

        $lang = $language === 'en' ? 'English' : 'Indonesian';
        $quranSourceHint = isset($options['source']) && is_string($options['source']) ? trim($options['source']) : '';
        $instructions = match ($mode) {
            'quran' => "Return a JSON object with keys: type='quran', arabic='<full arabic verse>', translation='<{$lang} translation>', source='QS SurahName Ayah Number', display_text='<concise combined line in {$lang} referencing the verse without Arabic>'.
Require the Arabic text to be fully written." . ($quranSourceHint ? " Use EXACTLY this verse: {$quranSourceHint}. Do not choose a different verse." : " Choose a verse suitable for marriage/love themes."),
            'bible' => "Return a JSON object with keys: type='bible', verse_text='<full verse text>', translation='<{$lang} translation or original if available>', source='Book Chapter:Verse', display_text='<concise combined line in {$lang} referencing the verse>'. Choose a marriage/love verse.",
            default => "Return a JSON object with keys: type='quote', quote_text='<short authentic deep quote about love/marriage>', source='<author and work if relevant>', display_text='<one line in {$lang} introducing or summarizing the quote>'. Prefer well-known authors or philosophers.",
        };

        $prompt = "Couple: {$groom} & {$bride}. Mode: {$mode}. Language: {$lang}.
{$instructions}
Only output JSON. No markdown.";

        try {
            $response = Http::withToken($apiKey)->timeout(20)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You produce structured JSON responses for wedding inspirations.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => $mode === 'quran' ? 0.2 : 0.5,
                'max_tokens' => 350,
                'response_format' => ['type' => 'json_object'],
            ]);

            if (!$response->successful()) {
                Log::error('OpenAI Error: ' . $response->body());
                return ['type' => 'error', 'display_text' => 'Maaf, AI sedang sibuk. Silakan coba lagi nanti.'];
            }

            $content = $response->json()['choices'][0]['message']['content'] ?? '{}';
            try {
                $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
                return is_array($data) ? $data : ['type' => 'error', 'display_text' => 'Format tidak dikenali.'];
            } catch (\Throwable $e) {
                return ['type' => 'error', 'display_text' => 'Format tidak dikenali.'];
            }
        } catch (\Exception $e) {
            Log::error('OpenAI Connection Error: ' . $e->getMessage());
            return ['type' => 'error', 'display_text' => 'Gagal terhubung ke server AI.'];
        }
    }
}
