<?php

namespace LiddleDev\LiddleForum\Drivers\TextEditor;

class Trumbowyg implements TextEditorInterface
{
    /**
     * Returns the HTML necessary to convert a textarea input into the text editor
     *
     * @param $textareaId
     * @return string
     */
    public function applyToTextArea($textareaId)
    {
        $configString = '';

        $config = config('liddleforum.text_editor.drivers.trumbowyg.config', []);
        $first = true;
        foreach ($config as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $configString .= ',';
            }

            $configString .= $key . ': ' . $value;
        }
        return <<<EOF
    $('#{$textareaId}').trumbowyg({
        {$configString}
    });
EOF;
    }

    /**
     * Return the HTML to be included in the head of the page
     *
     * @return string
     */
    public function headerIncludes()
    {
        return <<<EOF
<link rel="stylesheet" href="/vendor/liddledev/liddleforum/assets/js/trumbowyg/ui/trumbowyg.min.css">
EOF;
    }

    /**
     * Return the HTML to be included in just before the body closing in the page
     *
     * @return string
     */
    public function footerIncludes()
    {
        return <<<EOF
<script src="/vendor/liddledev/liddleforum/assets/js/trumbowyg/trumbowyg.min.js"></script>
EOF;
    }
}