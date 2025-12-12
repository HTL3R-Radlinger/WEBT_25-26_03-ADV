<?php

namespace Radlinger\Mealplan\View;

use function PHPUnit\Framework\equalToCanonicalizing;

class TemplateEngine
{
    public static function render(string $templatePath, array $data): string
    {
        $content = file_get_contents($templatePath);
        return self::renderContent($content, $data);
    }

    private static function renderContent(string $content, array $data): string
    {
        print_r($data);
        $parsed = self::parseWithStack($content, $data);
//        echo $parsed;
//        return self::replaceVars($parsed, $data);
        return "";
    }

    /**
     * Stack-basierter Parser für verschachtelte for-Schleifen.
     */
    private static function parseWithStack(string $content, array $data): string
    {
        $tokens = self::tokenize($content);
        echo "START\n#########\n";
        print_r($tokens);
        echo "END\n#########\n";
        $stack = [];
        $output = '';

        foreach ($tokens as $token) {
            if ($token['type'] === 'for_open') {
                $stack[] = [
                    'var' => $token['var'],
                    'array' => $token['array'],
                    'inner' => ''
                ];
                continue;
            }

            if ($token['type'] === 'for_close') {
                $loop = array_pop($stack);
                $rendered = '';

                $arr = $data[$loop['array']] ?? [];
                if (!is_array($arr)) {
                    $arr = [];
                }

                foreach ($arr as $item) {
                    $scope = is_array($item)
                        ? array_merge($data, $item)
                        : array_merge($data, [$loop['var'] => $item]);

                    $renderedBlock = self::replaceVars($loop['inner'], $scope);
                    $renderedBlock = self::parseWithStack($renderedBlock, $scope);
                    $rendered .= $renderedBlock;
                }

                if (empty($stack)) {
                    $output .= $rendered;
                } else {
                    $stack[count($stack) - 1]['inner'] .= $rendered;
                }
                continue;
            }

            if ($token['type'] === 'text') {
                if (empty($stack)) {
                    $output .= $token['value'];
                } else {
                    $stack[count($stack) - 1]['inner'] .= $token['value'];
                }
                continue;
            }
        }

        return $output;
    }

    /** Tokenizer: zerlegt das Template in Text + For-Tags */
    private static function tokenize(string $content): array
    {
        $pattern = '/(\{%\s*for\s+(\w+)\s+in\s+(\w+)\s*%\}|\{%\s*endfor\s*%\})/';
        $parts = preg_split($pattern, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        $tokens = [];
        for ($i = 0; $i < count($parts); $i++) {
            $part = $parts[$i];
            if ($part === '') continue;

            if (preg_match('/^\{%\s*for\s+(\w+)\s+in\s+(\w+)\s*%\}$/', $part, $m)) {
                $tokens[] = ['type' => 'for_open', 'var' => $m[1], 'array' => $m[2]];
                continue;
            }

            if (preg_match('/^\{%\s*endfor\s*%\}$/', $part)) {
                $tokens[] = ['type' => 'for_close'];
                continue;
            }

            $tokens[] = ['type' => 'text', 'value' => $part];
        }

        return $tokens;
    }

    private static function replaceVars(string $content, array $data): string
    {
        return preg_replace_callback('/{{\s*(\w+)\s*}}/', function ($matches) use ($data) {
            $key = $matches[1];
            return $data[$key] ?? '';
        }, $content);
    }
}
