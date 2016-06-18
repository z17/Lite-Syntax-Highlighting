<?php
class LiteSyntaxHighlighting
{
    public static $LANGUAGE_DOMAIN = 'lite-syntax-highlighting';

    private static $RESOURCES_NAME = 'lite-syntax-highlighting';
    private static $STYLES = array(
        'light' => '/css/light.css',
        'dark' => '/css/dark.css',
    );
    public static $DEFAULT_STYLE = 'light';

    public static $LANGUAGES = array(
        'php' => 'PHP',
        'html' => 'HTML',
        'css' => 'CSS',
        'js' => 'JS',
        'c' => 'C',
    );

    public static $CSS_PREFIX = 'slh__';

    public static function languagesSetup() {
        load_plugin_textdomain(self::$LANGUAGE_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    public static function liteSyntaxHighlightingResources() {
        $options = get_option(LiteSyntaxOptionsPage::$SYNTAX_HIGHLIGHTING_OPTIONS);
        if (isset(self::$STYLES[$options['style']])) {
            $cssFile = plugins_url(self::$STYLES[$options['style']], __FILE__);
        } else {
            $cssFile = plugins_url(self::$STYLES[self::$DEFAULT_STYLE], __FILE__);
        }
        $jsFile = plugins_url('/js/liteHighlighting.js', __FILE__);
        wp_enqueue_style(self::$RESOURCES_NAME, $cssFile, false, '0.1');
        wp_enqueue_script(self::$RESOURCES_NAME, $jsFile, array('jquery'), '0.1');
    }

    public static function liteSyntaxHighlightingAddButtons()
    {
        if (wp_script_is('quicktags')) {
            $options = get_option(LiteSyntaxOptionsPage::$SYNTAX_HIGHLIGHTING_OPTIONS);

            $buttons = array();
            foreach(self::$LANGUAGES as $key => $name) {
                if($options[$key]) {
                    $buttons[] = array(
                        'id' => $key,
                        'name' => $name,
                        'tagOpen' => '['.LiteSyntaxSupporter::$SHORT_CODE.' lang="'.$key.'"]',
                        'tagClose' => '[/'.LiteSyntaxSupporter::$SHORT_CODE.']',
                    );
                }
            }
            ?>
            <script type="text/javascript">
                <?php
                // кнопки, формат добавления:
                // QTags.addButton( 'идентификатор' , 'название', '<открывающий тег>', '</закрывающий тег>', 'v', 'описание', позиция(число) );
                foreach($buttons as $oneButton) {
                    ?>
                    QTags.addButton('<?=$oneButton['id']?>', '<?=$oneButton['name']?>', '<?=$oneButton['tagOpen']?>', '<?=$oneButton['tagClose']?>', 'p', '', 999);
                    <?php
                }
            ?>
            </script>
            <?php
        }
    }

    public static function activation()
    {
        if (get_option(LiteSyntaxOptionsPage::$SYNTAX_HIGHLIGHTING_OPTIONS) === false) {
            $options = array(
                'style' => self::$DEFAULT_STYLE,
            );
            // set true for all languages
            foreach(self::$LANGUAGES as $key => $name) {
                $options[$key] = true;
            }

        } else {
            // validate
            $options = get_option(LiteSyntaxOptionsPage::$SYNTAX_HIGHLIGHTING_OPTIONS);

            foreach(self::$LANGUAGES as $key => $name) {
                if (!is_bool($options[$key])) {
                    $options[$key] = true;
                }
            }
            if (!in_array($options['style'], self::$STYLES)) {
                $options['style'] = self::$DEFAULT_STYLE;
            }
        }

        add_option(LiteSyntaxOptionsPage::$SYNTAX_HIGHLIGHTING_OPTIONS, $options);
    }

    public static function uninstall()
    {
        delete_option(LiteSyntaxOptionsPage::$SYNTAX_HIGHLIGHTING_OPTIONS);
    }
}