<?php
class LiteSyntaxHighlighting
{


    const SYNTAX_HIGHLIGHTING_OPTIONS = "syntax_highlighting_options";
    const RESOURCES_NAME = 'lite-syntax-highlighting';

    public static function liteSyntaxHighlightingResources()
    {
        $cssFile = plugins_url('/css/style.css', __FILE__);
        $jsFile = plugins_url('/js/liteHighlighting.js', __FILE__);
        wp_enqueue_style(self::RESOURCES_NAME, $cssFile, false, '0.1');
        wp_enqueue_script(self::RESOURCES_NAME, $jsFile, false, '0.1');
    }

    public static function liteSyntaxHighlightingAddButtons()
    {
        if (wp_script_is('quicktags')) {
            $options = get_option(self::SYNTAX_HIGHLIGHTING_OPTIONS);
            ?>
            <script type="text/javascript">

                <?php
                // кнопки, формат добавления:
                // QTags.addButton( 'идентификатор' , 'название', '<открывающий тег>', '</закрывающий тег>', 'v', 'описание', позиция(число) );
                if ($options['php']) {
                    ?>
                    QTags.addButton('php', 'PHP', '<pre class="php">', '</pre>', 'p', '', 999);
                    <?php
                }
                if ($options['html']) {
                    ?>
                    QTags.addButton('html', 'HTML', '<pre class="html">', '</pre>', 'p', '', 999);
                    <?php
                }
                if ($options['css']) {
                    ?>
                       QTags.addButton('css', 'CSS', '<pre class="css">', '</pre>', 'p', '', 999);
                    <?php
                }
                if ($options['js']) {
                    ?>
                    QTags.addButton('js', 'JS', '<pre class="js">', '</pre>', 'p', '', 999);
                    <?php
                }
                ?>
            </script>
            <?php
        }
    }

    public static function liteSyntaxHighlightingAddConfigPag()
    {
        add_options_page('Lite Syntax Highlighting', 'Syntax Highlighting', 'manage_options', 'highlighting', array('LiteSyntaxHighlighting', 'addOptionsPage'));
    }

    public static function addOptionsPage()
    {

        $flagSubmit = isset($_POST['submit']) ? $_POST['submit'] : false;

        if ($flagSubmit !== false) {
            $flagPHP = $_POST['backlite_php'];
            $flagHTML = $_POST['backlite_html'];
            $flagCSS = $_POST['backlite_css'];
            $flagJS = $_POST['backlite_js'];

            if ($flagPHP == 1) {
                $flagPHP = true;
            } else {
                $flagPHP = false;
            }

            if ($flagHTML == 1) {
                $flagHTML = true;
            } else {
                $flagHTML = false;
            }

            if ($flagCSS == 1) {
                $flagCSS = true;
            } else {
                $flagCSS = false;
            }

            if ($flagJS == 1) {
                $flagJS = true;
            } else {
                $flagJS = false;
            }

            $options = array(
                'php' => $flagPHP,
                'js' => $flagJS,
                'css' => $flagCSS,
                'html' => $flagHTML
            );
            update_option(self::SYNTAX_HIGHLIGHTING_OPTIONS, $options);
        }

        $options = get_option(self::SYNTAX_HIGHLIGHTING_OPTIONS);
        ?>
        <h2>Lite Syntax Highlighting</h2>
        <p>Отображать конпки в редакторе:</p>
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
            </table>
            <input type="submit" value="Сохранить">
            <input type="hidden" name="submit" value="true">
        </form>

        <?php
    }

    public static function activation()
    {
        if (get_option(self::SYNTAX_HIGHLIGHTING_OPTIONS) === false) {
            $options = array(
                'php' => true,
                'js' => true,
                'css' => true,
                'html' => true
            );
            add_option(self::SYNTAX_HIGHLIGHTING_OPTIONS, $options);
        }
    }

    public static function uninstall()
    {
        delete_option(self::SYNTAX_HIGHLIGHTING_OPTIONS);
    }
}