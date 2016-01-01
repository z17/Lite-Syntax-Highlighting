<?php
function liteSyntaxHighlightingResources() {
    $cssFile = plugins_url( '/css/style.css', __FILE__ );
    $jsFile =  plugins_url( '/js/liteHighlighting.js', __FILE__ );
    wp_enqueue_style('lite-syntax-highlighting', $cssFile, false, '0.1' );
    wp_enqueue_script('lite-syntax-highlighting', $jsFile, false, '0.1');
}

function liteSyntaxHighlightingAddButtons() {
    if ( wp_script_is('quicktags') ){
        ?>
        <script type="text/javascript">
            // кнопки, формат добавления:
            // QTags.addButton( 'идентификатор' , 'название', '<открывающий тег>', '</закрывающий тег>', 'v', 'описание', позиция(число) );

            QTags.addButton( 'php','PHP','<pre class="php">','</pre>', 'p', '', 999 );
            QTags.addButton( 'html','HTML','<pre class="html">','</pre>', 'p', '', 999 );
            QTags.addButton( 'css','CSS','<pre class="css">','</pre>', 'p', '', 999 );
            QTags.addButton( 'js','JS','<pre class="js">','</pre>', 'p', '', 999 );
        </script>
        <?php
    }
}