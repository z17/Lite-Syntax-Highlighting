<?php
class LiteSyntaxSupporter {
    public static $SHORT_CODE = "slh";
    public static function shortCodeFunction($attr, $content) {
        $cssClass = '';
        if (isset($attr['lang'])) {
            if (array_key_exists($attr['lang'], LiteSyntaxHighlighting::$LANGUAGES)) {
                $cssClass = LiteSyntaxHighlighting::$CSS_PREFIX . $attr['lang'];
            }
        }

        $content = str_replace('<', '&lt;', $content);
        $content = str_replace('>', '&gt;', $content);
        return '<pre class="' . $cssClass . '">' . $content . '</pre>';
    }

    public function wpAutoP($text) {
        $text = do_shortcode($text);
        return wpautop($text);
    }
}