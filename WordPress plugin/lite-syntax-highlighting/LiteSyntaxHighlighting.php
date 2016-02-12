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

    public static function languagesSetup() {
        load_plugin_textdomain(self::$LANGUAGE_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }
    public static function liteSyntaxHighlightingResources()
    {
        $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
        if (isset(self::$STYLES[$options['style']])) {
            $cssFile = plugins_url(self::$STYLES[$options['style']], __FILE__);
        } else {
            $cssFile = plugins_url(self::$STYLES[self::$DEFAULT_STYLE], __FILE__);
        }
        $jsFile = plugins_url('/js/liteHighlighting.js', __FILE__);
        wp_enqueue_style(self::$RESOURCES_NAME, $cssFile, false, '0.1');
        wp_enqueue_script(self::$RESOURCES_NAME, $jsFile, false, '0.1');
    }

    public static function liteSyntaxHighlightingAddButtons()
    {
        if (wp_script_is('quicktags')) {
            $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
            ?>
            <script type="text/javascript">

                <?php
                // кнопки, формат добавления:
                // QTags.addButton( 'идентификатор' , 'название', '<открывающий тег>', '</закрывающий тег>', 'v', 'описание', позиция(число) );
                if ($options['php']) {
                    ?>
                    QTags.addButton('php', 'PHP', '<pre class="slh__php">', '</pre>', 'p', '', 999);
                    <?php
                }
                if ($options['html']) {
                    ?>
                    QTags.addButton('html', 'HTML', '<pre class="slh__html">', '</pre>', 'p', '', 999);
                    <?php
                }
                if ($options['css']) {
                    ?>
                       QTags.addButton('css', 'CSS', '<pre class="slh__css">', '</pre>', 'p', '', 999);
                    <?php
                }
                if ($options['js']) {
                    ?>
                    QTags.addButton('js', 'JS', '<pre class="slh__js">', '</pre>', 'p', '', 999);
                    <?php
                }
                if ($options['c']) {
                    ?>
                QTags.addButton('c', 'C', '<pre class="slh__c">', '</pre>', 'p', '', 999);
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
            $flagPHP = ($_POST['backlite_php'] == 1 ? true : false);
            $flagHTML = ($_POST['backlite_html'] == 1 ? true : false);
            $flagCSS = ($_POST['backlite_css'] == 1 ? true : false);
            $flagJS = ($_POST['backlite_js'] == 1 ? true : false);
            $flagC = ($_POST['backlite_c'] == 1 ? true : false);
            $style = $_POST['style'];

            if (!in_array($style, array("light", "dark"))) {
                $style = self::$DEFAULT_STYLE;   // default
            }

            $options = array(
                'php' => $flagPHP,
                'js' => $flagJS,
                'css' => $flagCSS,
                'html' => $flagHTML,
                'c' => $flagC,
                'style' => $style,
            );
            update_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS, $options);
        }

        $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
        ?>
        <h1><?=__("Lite Syntax Highlighting", self::$LANGUAGE_DOMAIN)?></h1>
        <h2><?=__("Select buttons", self::$LANGUAGE_DOMAIN)?></h2>
        <form method="post">
            <table>
                <tr>
                    <td style="width:150px;">PHP:</td>
                    <td><input type="checkbox" name="backlite_php" value="1" <?=($options['php'] ? 'checked' : '')?>></td>
                </tr>
                <tr>
                    <td>HTML:</td>
                    <td><input type="checkbox" name="backlite_html" value="1" <?=($options['html'] ? 'checked' : '')?>></td>
                </tr>
                <tr>
                    <td>CSS:</td>
                    <td><input type="checkbox" name="backlite_css" value="1" <?=($options['css'] ? 'checked' : '')?>></td>
                </tr>
                <tr>
                    <td>JavaScript:</td>
                    <td><input type="checkbox" name="backlite_js" value="1" <?=($options['js'] ? 'checked' : '')?>></td>
                </tr>
                <tr>
                    <td>C:</td>
                    <td><input type="checkbox" name="backlite_c" value="1" <?=($options['c'] ? 'checked' : '')?>></td>
                </tr>
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
                'php' => true,
                'js' => true,
                'css' => true,
                'html' => true,
                'style' => self::$DEFAULT_STYLE,
            );

        } else {
            // validate
            $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
            if (!in_array($options['php'], array(true, false))) {
                $options['php'] = true;
            }
            if (!in_array($options['js'], array(true, false))) {
                $options['js'] = true;
            }
            if (!in_array($options['html'], array(true, false))) {
                $options['html'] = true;
            }
            if (!in_array($options['css'], array(true, false))) {
                $options['css'] = true;
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