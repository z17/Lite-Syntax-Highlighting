<?php
class LiteSyntaxHighlighting
{
    private static $SYNTAX_HIGHLIGHTING_OPTIONS = "syntax_highlighting_options";
    private static $RESOURCES_NAME = 'lite-syntax-highlighting';
    private static $LANGUAGE_DOMAIN = 'lite-syntax-highlighting';
    private static $OPTIONS_PAGE = 'highlighting';
    private static $STYLES = array(
        'light' => '/css/light.css',
        'dark' => '/css/dark.css',
    );
    private static $DEFAULT_STYLE = 'light';

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
        $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
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
            $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);

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

    public static function liteSyntaxHighlightingAddConfigPag()
    {
        add_options_page('Lite Syntax Highlighting', 'Syntax Highlighting', 'manage_options', self::$OPTIONS_PAGE, array('LiteSyntaxHighlighting', 'addOptionsPage'));
    }

    public static function addOptionsPage()
    {

        $flagSubmit = isset($_POST['submit']) ? $_POST['submit'] : false;

        if ($flagSubmit !== false) {
            $style = (isset($_POST['style']) ? $_POST['style'] : null);

            if (!in_array($style, array("light", "dark"))) {
                $style = self::$DEFAULT_STYLE;   // default
            }

            $options = array(
                'style' => $style,
            );
            // save lang options
            foreach(self::$LANGUAGES as $key => $name) {
                $options[$key] = ($_POST['backlite_'.$key] == 1 ? true : false);
            }

            update_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS, $options);
        }

        $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
        ?>
        <h1><?=__("Lite Syntax Highlighting", self::$LANGUAGE_DOMAIN)?></h1>
        <h2><?=__("Select buttons", self::$LANGUAGE_DOMAIN)?></h2>
        <form method="post">
            <table>
                <?php
                foreach(self::$LANGUAGES as $key => $name) {
                    ?>
                    <tr>
                        <td style="width:150px;"><?=$name?>:</td>
                        <td><input type="checkbox" name="backlite_<?=$key?>" value="1" <?=($options[$key] ? 'checked' : '')?>></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?=__('Select style', self::$LANGUAGE_DOMAIN)?>:</td>
                    <td>
                        <select name="style">
                            <option value="light" <?=($options['style'] == 'light' ? 'selected' : '')?>>Light</option>
                            <option value="dark" <?=($options['style'] == 'dark' ? 'selected' : '')?>>Dark</option>
                        </select>
                    </td>
                </tr>
            </table>
            <p>

            </p>
            <input type="submit" value="<?=__('Submit', self::$LANGUAGE_DOMAIN)?>">
            <input type="hidden" name="submit" value="true">
        </form>

        <?php
    }

    public static function activation()
    {
        if (get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS) === false) {
            $options = array(
                'style' => self::$DEFAULT_STYLE,
            );
            // set true for all languages
            foreach(self::$LANGUAGES as $key => $name) {
                $options[$key] = true;
            }

        } else {
            // validate
            $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);

            foreach(self::$LANGUAGES as $key => $name) {
                if (!is_bool($options[$key])) {
                    $options[$key] = true;
                }
            }
            if (!in_array($options['style'], self::$STYLES)) {
                $options['style'] = self::$DEFAULT_STYLE;
            }
        }

        add_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS, $options);
    }

    public static function uninstall()
    {
        delete_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
    }

    public static function addSettingsLink($links) {
        $settings_link = '<a href="options-general.php?page='.self::$OPTIONS_PAGE.'">'. __("Settings", self::$LANGUAGE_DOMAIN) .'</a>';
        array_unshift($links, $settings_link);
        return $links;

    }
}