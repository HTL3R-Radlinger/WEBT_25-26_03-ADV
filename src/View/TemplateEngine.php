<?php

namespace Radlinger\Mealplan\View;

class TemplateEngine
{
    public static function render(string $templatePath, array $data): string
    {
        $output = file_get_contents($templatePath);

        // 1) Normal Loops
        $output = self::processLoop($output, $data, 'for', 'endfor');
//        return $output;
        // 2) Sub Loops
        $output = self::processLoop($output, $data, 'subfor', 'endsubfor');

        // 3) Simple vars
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $output = str_replace('{{' . $key . '}}', $value, $output);
            }
        }

        return $output;
    }

    private static function processLoop(string $output, array $data, string $openTag, string $closeTag): string
    {
        // Regex dynamisch
        $pattern = sprintf(
            '/\{%%\s*%s\s+(\w+)\s+in\s+(\w+)\s*%%}(.*?)\{%%\s*%s\s*%%}/s',
            $openTag,
            $closeTag
        );
//        exit(1);

        // Solange Schleifen existieren
        while (preg_match_all($pattern, $output, $matches, PREG_SET_ORDER)) {

            foreach ($matches as $match) {

                [$full, $itemVar, $arrayVar, $block] = $match;
                echo $arrayVar;

                $replacement = '';

                // Prüfen, ob Array existiert
                if (isset($data[$arrayVar]) && is_array($data[$arrayVar])) {
                    foreach ($data[$arrayVar] as $item) {

                        $renderedBlock = $block;

                        // Nur Objekte oder Arrays unterstützen
                        $vars = is_object($item)
                            ? get_object_vars($item)
                            : (array)$item;

                        foreach ($vars as $k => $v) {
                            if (!is_array($v) && !is_object($v)) {
                                $renderedBlock = str_replace('{{' . $k . '}}', $v, $renderedBlock);
                            }
                        }

                        $replacement .= $renderedBlock;
                    }
                }

                $output = str_replace($full, $replacement, $output);
            }
        }

        return $output;
    }
}