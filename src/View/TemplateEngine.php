<?php

namespace Radlinger\Mealplan\View;

class TemplateEngine
{
    public static function render(string $templatePath, array $data): string
    {
        $output = file_get_contents($templatePath);
        return self::renderContent($output, $data);
    }

    private static function renderContent(string $content, array $data): string
    {
        while (preg_match('/\{% for (\w+) in (\w+) %\}/', $content, $startMatch, PREG_OFFSET_CAPTURE)) {
            $startPos = $startMatch[0][1] + strlen($startMatch[0][0]); // use +, not .
            $itemVar = $startMatch[1][0];
            $arrayVar = $startMatch[2][0];

            // Find matching {% endfor %}
            $pos = $startPos;
            $openCount = 1;
            while ($openCount > 0 && preg_match('/\{% for (\w+) in (\w+) %}|\{% endfor %\}/', $content, $m, PREG_OFFSET_CAPTURE, $pos)) {
                if (str_contains($m[0][0], '% for')) {
                    $openCount++;
                } else {
                    $openCount--;
                }
                $pos = $m[0][1] + strlen($m[0][0]); // use +, not .
            }

            $endPos = $m[0][1];
            $loopContent = substr($content, $startPos, $endPos - $startPos);

            $replacement = '';
            if (isset($data[$arrayVar]) && is_array($data[$arrayVar])) {
                foreach ($data[$arrayVar] as $item) {
                    $itemVars = is_object($item) ? self::objectToArray($item) : $item;
                    $replacement .= self::renderContent($loopContent, $itemVars);
                }
            }

            $length = $endPos + 11 - $startMatch[0][1]; // 11 = strlen('{% endfor %}')
            $content = substr_replace($content, $replacement, $startMatch[0][1], $length);
        }

        // Replace scalar variables
        foreach ($data as $key => $value) {
            if (is_scalar($value)) {
                $content = str_replace('{{' . $key . '}}', $value, $content);
            }
        }

        return $content;
    }

    private static function objectToArray(object $obj): array
    {
        $arr = [];
        $reflection = new \ReflectionClass($obj);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if (str_starts_with($method->name, 'get')) {
                $key = lcfirst(substr($method->name, 3));
                $arr[$key] = $method->invoke($obj);
            }
        }
        return $arr;
    }
}
