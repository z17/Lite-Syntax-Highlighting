<?php
class LiteSyntaxOptionsPage {
    public static $OPTIONS_PAGE = 'highlighting';
    public static $SYNTAX_HIGHLIGHTING_OPTIONS = "syntax_highlighting_options";

    public static function addConfigPage()
    {
        add_options_page('Lite Syntax Highlighting', 'Syntax Highlighting', 'manage_options', self::$OPTIONS_PAGE, array('LiteSyntaxOptionsPage', 'addPage'));
    }

    public static function addPage()
    {
        $flagSubmit = isset($_POST['submit']) ? $_POST['submit'] : false;

        if ($flagSubmit !== false) {
            $style = (isset($_POST['style']) ? $_POST['style'] : null);

            if (!in_array($style, array("light", "dark"))) {
                $style = LiteSyntaxHighlighting::$DEFAULT_STYLE;   // default
            }

            $options = array(
                'style' => $style,
            );
            // save lang options
            foreach(LiteSyntaxHighlighting::$LANGUAGES as $key => $name) {
                $options[$key] = ($_POST['backlite_'.$key] == 1 ? true : false);
            }

            update_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS, $options);
        }

        $options = get_option(self::$SYNTAX_HIGHLIGHTING_OPTIONS);
        ?>
        <h1><?=__("Lite Syntax Highlighting", LiteSyntaxHighlighting::$LANGUAGE_DOMAIN)?></h1>
        <p><?=__("Plugin adds syntax highlight by shortcodes in posts and comments, you can use next codes for this:", LiteSyntaxHighlighting::$LANGUAGE_DOMAIN)?></p>
        <ul>
        <?php
        foreach(LiteSyntaxHighlighting::$LANGUAGES as $key => $name) {
            ?>
            <li>[<?=LiteSyntaxSupporter::$SHORT_CODE?> lang="<?=$key?>"] ..code.. [/<?=LiteSyntaxSupporter::$SHORT_CODE?>]</li>
            <?php
        }
        ?>
        </ul>
        <p><?=__("To add syntax highlight in custom place, you can also use special html codes:", LiteSyntaxHighlighting::$LANGUAGE_DOMAIN)?></p>
        <ul>
        <?php
        foreach(LiteSyntaxHighlighting::$LANGUAGES as $key => $name) {
            ?>
            <li>&lt;pre class="<?=LiteSyntaxHighlighting::$CSS_PREFIX?><?=$key?>"&gt; ..code.. &lt;/pre&gt;</li>
            <?php
        }
        ?>
        </ul>

        <h2><?=__("Select buttons", LiteSyntaxHighlighting::$LANGUAGE_DOMAIN)?></h2>
        <form method="post">
            <table>
                <?php
                foreach(LiteSyntaxHighlighting::$LANGUAGES as $key => $name) {
                    ?>
                    <tr>
                        <td style="width:150px;"><?=$name?>:</td>
                        <td><input type="checkbox" name="backlite_<?=$key?>" value="1" <?=($options[$key] ? 'checked' : '')?>></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?=__('Select style', LiteSyntaxHighlighting::$LANGUAGE_DOMAIN)?>:</td>
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
            <input type="submit" value="<?=__('Submit', LiteSyntaxHighlighting::$LANGUAGE_DOMAIN)?>">
            <input type="hidden" name="submit" value="true">
        </form>

        <?php
    }

    public static function addSettingsLink($links) {
        $settings_link = '<a href="options-general.php?page='.self::$OPTIONS_PAGE.'">'. __("Settings", LiteSyntaxHighlighting::$LANGUAGE_DOMAIN) .'</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

}