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
        // Handle loops recursively
        if (preg_match_all('/\{% for (\w+) in (\w+) %}(.*?)\{% endfor %}/s', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
//                print_r($match);
                [$fullMatch, $itemVar, $arrayVar, $loopContent] = $match;
                echo $match[0];
//                echo $fullMatch;
                $replacement = '';
                if (isset($data[$arrayVar]) && is_array($data[$arrayVar])) {
                    foreach ($data[$arrayVar] as $item) {
                        $itemVars = is_object($item) ? get_object_vars($item) : $item;
                        // Render loop content recursively
                        $replacement .= self::renderContent($loopContent, $itemVars);
                    }
                }
//echo $content;
                $content = str_replace($fullMatch, $replacement, $content);
            }
        }

        // Replace scalar variables
        foreach ($data as $key => $value) {
            if (is_scalar($value)) {
                $content = str_replace('{{' . $key . '}}', $value, $content);
            }
        }

//        return $content;
        return "";
    }
}