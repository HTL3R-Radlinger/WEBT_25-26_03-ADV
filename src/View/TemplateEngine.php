<?php

namespace Radlinger\Mealplan\View;
class TemplateEngine
{
    public static function render(string $templatePath, array $data): string
    {
        $handle = fopen($templatePath, 'r');
        $output = fread($handle, filesize($templatePath));
        fclose($handle);

        // Handle loops
        if (preg_match_all('/\{% for (\w+) in (\w+) %\}(.*?)\{% endfor %\}/s', $output, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                [$fullMatch, $itemVar, $arrayVar, $loopContent] = $match;

                $replacement = '';
                if (isset($data[$arrayVar]) && is_array($data[$arrayVar])) {
                    foreach ($data[$arrayVar] as $item) {
                        $loopItem = $loopContent;
                        foreach (get_object_vars($item) as $key => $value) {
                            $loopItem = str_replace('{{' . $key . '}}', $value, $loopItem);
                        }
                        $replacement .= $loopItem;
                    }
                }

                $output = str_replace($fullMatch, $replacement, $output);
            }
        }

        // Replace simple variables
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $output = str_replace('{{' . $key . '}}', $value, $output);
            }
        }

        return $output;
    }
}