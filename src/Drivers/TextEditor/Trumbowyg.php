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
        return <<<EOF
<script>
    $(function() {    
        $('#{$textareaId}').trumbowyg();
    });
</script>
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