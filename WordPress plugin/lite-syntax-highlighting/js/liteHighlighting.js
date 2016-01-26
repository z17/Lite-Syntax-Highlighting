/*
 Name: Lite Syntax Highlighting
 URI: http://blweb.ru/blog/prostaya-podsvetka-koda-na-sajjt
 Description: Lite Syntax Highlighting: php, html, css, js
 Version: 1.5
 Author: z-17
 Author URI: http://blweb.ru
 GitHub URI: https://github.com/z17/Lite-Syntax-Highlighting
 License: GPLv2 or later
 License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
function backlightHtml(txt) {
    var comments = [];
    var quotes = [];
    var attr = [];
    txt = txt
        .replace(/(&lt;!--[\s\S]*?--&gt;)/g, function (str) {
            var l = comments.length;
            comments.push(str);
            return '~~~COMM' + l + '~~~';
        })
        .replace(/"(.*?)"/g, function (str, a, b, c) {
            var l = quotes.length;
            quotes.push(str);
            return '~~~QUO' + l + '~~~';
        })
        .replace(/'(.*?)'/g, function (str, a, b, c) {
            var l = quotes.length;
            quotes.push(str);
            return '~~~QUO' + l + '~~~';
        })
        .replace(/(align|valign|src|id|style|width|body|name|cellspacing|cellpadding|border|height|href|content|http-equiv|type|rel|class|target)=/g, function (str1, str2) {
            var l = attr.length;
            attr.push(str2);
            return '~~~ATTR' + l + '~~~';
        })
        .replace(/(&lt;\/?(table|td|tr|span|div|html|header|body|iframe|br|img|a|strong|meta|title|head|pre|code|link|li|ul|ol|p|h1|h2|h3|h4|h5|script|b)(&gt;)?)/g, '<span class="code-tags">$1</span>')
        .replace(/~~~(COMM)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-comments">' + comments[num] + '</span>';
        })
        .replace(/~~~(QUO)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-quotes">' + quotes[num] + '</span>';
        })
        .replace(/~~~(ATTR)([0-9]*?)~~~/g, function (reg, str, num) {
            return ' <span class="code-attribute">' + attr[num] + '</span>=';
        })
    ;
    return txt;
}

function backlightPHP(txt) {
    var comments = [];
    var quotes = [];
    txt = txt
        .replace(/\/\*[\s\S]*?\*\//g, function (str) {
            var l = comments.length;
            comments.push(str);
            return '~~~COMM' + l + '~~~';
        })
        .replace(/(\/\/[^\n\r]*(\n|\r\n))/g, function (str) {
            var l = comments.length;
            comments.push(str);
            return '~~~COMM' + l + '~~~';
        })
        .replace(/'[\s\S]*?'/g, function (str) {
            var l = quotes.length;
            quotes.push(str);
            return '~~~QUO' + l + '~~~';
        })
        .replace(/"[\s\S]*?"/g, function (str) {
            var l = quotes.length;
            quotes.push(str);
            return '~~~QUO' + l + '~~~';
        })
     //   .replace(/(\$[a-zA-Z0-9-_]*?)(\s|,|-|;|\[|\.|{|\(|\)|\])/g, '<span class="code-var">$1</span>$2')
        .replace(/(\$\w*?)(\s|\W)/g, '<span class="code-var">$1</span>$2')
        .replace(/(\s|\!|\(|^|\t)(function|class|private|implode|new|sizeof|json_encode|json_decode|array|array_unique|array_map|array_search|strtotime|unset|array_merge|public|__construct|array|foreach|class|static|empty|else|elseif|if|break|return|exit|isset|while|explode|date|echo|as|file_get_contents|preg_split)(\s|\(|$|;)/g, '$1<span class="code-operator">$2</span>$3')

        .replace(/(&lt;\?php)/g, '<span class="code-php">$1</span>')
        .replace(/(\?&gt;)/g, '<span class="code-php">$1</span>')
        .replace(/~~~(COMM)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-comments">' + comments[num] + '</span>';
        })
        .replace(/~~~(QUO)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-quotes">' + quotes[num] + '</span>';
        })
    ;
    return txt;
}

function backlightCSS(txt) {
    var comments = [];
    txt = txt
        .replace(/\/\*[\s\S]*?\*\//g, function (str) {
            var l = comments.length;
            comments.push(str);
            return '~~~COMM' + l + '~~~';
        })
        .replace(/( |\n|^)(table|td|tr|span|div|html|header|body|img|a|strong|pre|code|li|ul|ol|p|a|h1|h2|h3|h4|h5|blockquote)( |,|:[a-zA-Z]|\.|{|#)/g, '$1<span class="code-tags">$2</span>$3')
        .replace(/:(link|active|hover|visited|first-child|last-child|before|after)/g, ':<span class="code-pseudo">$1</span>')
        .replace(/\.([a-zA-Z0-9-_]*?)(\s|,|:|\.|{)/g, '.<span class="code-class">$1</span>$2')
        .replace(/\#([a-zA-Z0-9-_]*?)(\s|,|:|\.|{)/g, '#<span class="code-id">$1</span>$2')
        .replace(/( |;|{|\t)(margin|padding|background|border|text-decoration|color|list-style|float|font-weight|list-style-position|font-size|color|width|height|clear|font-family|box-shadow|content|text-align|right|left|top|bottom|display|overflow|margin-right|margin-left|margin-top|margin-bottom|padding-top|padding-bottom|padding-left|padding-right|position|opacity|word-wrap|border-top|border-bottom|border-right|border-left):/g, '$1<span class="code-style">$2</span>:')
        .replace(/~~~(COMM)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-comments">' + comments[num] + '</span>';
        })
    ;
    return txt;
}

function backlightJs(txt) {

    var comments = [];
    txt = txt
        .replace(/\/\*[\s\S]*?\*\//g, function (str) {
            var l = comments.length;
            comments.push(str);
            return '~~~COMM' + l + '~~~';
        })
        .replace(/(^[\\]?\/\/[^\n\r]*(\n|\r\n))/g, function (str) {
            var l = comments.length;
            comments.push(str);
            return '~~~COMM' + l + '~~~';
        })
        .replace(/(\(|\s|\!|^)(break|default|function|return|var|case|delete|if|switch|void|catch|do|in|this|while|const|else|instanceof|throw|continue|finally|try|debugger|for|new|typeof)(\)|\s|\!|=|\()/g, '$1<span class="code-operator">$2</span>$3')
        .replace(/(=|\s|\(|\t)"([^(code\-)].*?)"/g, '$1<span class="code-quotes">"$2"</span>')
        .replace(/\'([^(code\-)].*?)\'/g, '<span class="code-quotes">\'$1\'</span>')
        .replace(/~~~(COMM)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-comments">' + comments[num] + '</span>';
        })
    ;
    return txt;
}
jQuery(document).ready(function () {
    jQuery('pre.html, pre.css, pre.php, pre.js').each(function () {

        var safe = {
            '<': '&lt;',
            '>': '&gt;'
        };
        var txt = jQuery(this).html();
        txt = txt
            .replace("<!--?php", '<?php')
            .replace("?-->", '?>')
            .replace(/[\<\>]/g, function (m) {
                return safe[m];
            });
        jQuery(this).html(txt);
    });

    jQuery('pre.html').each(function () {

        var comments = [];
        var quotes = [];
        var attr = [];
        var txt = jQuery(this).html();
        txt = backlightHtml(txt);
        jQuery(this).html(txt);
    });

    jQuery('pre.css').each(function () {

        var comments = [];
        var txt = jQuery(this).html();
        txt = backlightCSS(txt);
        jQuery(this).html(txt);
    });

    jQuery('pre.php').each(function () {

        var php = [];
        var txt = jQuery(this).html();
        txt = txt
            .replace(/&lt;\?php([\s\S]*?)\?&gt;/g, function (str) {
                var l = php.length;
                php.push(backlightPHP(str));
                return '~~~PHP' + l + '~~~';
            });
        if (php.length > 0)		// если открывающих-закрывающих скобок php кода не было, значит весь код на php
        {
            txt = backlightHtml(txt);
            txt = txt.replace(/~~~(PHP)([0-9]*?)~~~/g, function (reg, str, num) {
                return php[num];
            });
        }
        else {
            txt = backlightPHP(txt)
        }
        jQuery(this).html(txt);
    });

    jQuery('pre.js').each(function () {
        var comments = [];
        var txt = jQuery(this).html();
        txt = backlightJs(txt);
        jQuery(this).html(txt);
    });

});