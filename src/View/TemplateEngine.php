<?php

namespace Radlinger\Mealplan\View;

class TemplateEngine
{
    public function loadTemplate(string $path): string
    {
        $handle = fopen($path, 'r');
        $template = fread($handle, filesize($path));
        fclose($handle);
        return $template;
    }

    public function render(string $template, array $vars): string
    {
        foreach ($vars as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }
        return $template;
    }
}