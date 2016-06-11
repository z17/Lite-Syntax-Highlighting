/*
 Name: Lite Syntax Highlighting
 URI: http://blweb.ru/blog/prostaya-podsvetka-koda-na-sajjt
 Description: Lite Syntax Highlighting: php, html, css, js, c
 Version: 1.6
 Author: z-17
 Author URI: http://blweb.ru
 GitHub URI: https://github.com/z17/Lite-Syntax-Highlighting
 License: GPLv2 or later
 License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 
var phpKeywords = [
'unset',
'print',
'return',
'require_once',
'require',
'list',
'isset',
'include_once',
'include',
'eval',
'exit',
'empty',
'echo',
'die',
'yield',
'trait',
'insteadof',
'__NAMESPACE__',
'__METHOD__',
'__FUNCTION__',
'__LINE__',
'__FILE__',
'__DIR__',
'__CLASS__',
'__TRAIT__',
'__halt_compiler',
'abstract',
'and',
'array',
'as',
'break',
'callable',
'case',
'catch',
'class',
'clone',
'const',
'continue',
'declare',
'default',
'do',
'else',
'elseif',
'enddeclare',
'endfor',
'endforeach',
'endif',
'endswitch',
'endwhile',
'extends',
'final',
'finally',
'for',
'foreach',
'function',
'global',
'goto',
'if',
'implements',
'instanceof',
'interface',
'namespace',
'new',
'or',
'private',
'protected',
'public',
'static',
'switch',
'throw',
'try',
'use',
'var',
'while',
'xor',
'implode',
'sizeof',
'json_encode',
'json_decode',
'array_unique',
'array_map',
'array_search',
'strtotime',
'array_merge',
'__construct',
'explode',
'date',
'file_get_contents',
'preg_split',
'define'
];
var htmlTags = [
'html',
'title',
'body',
'h1',
'p',
'br',
'hr',
'acronym',
'abbr',
'address',
'b',
'bdo',
'big',
'blockquote',
'center',
'cite',
'code',
'del',
'dfn',
'em',
'font',
'i',
'ins',
'kbd',
'mark',
'meter',
'pre',
'progress',
'q',
'rp',
'rt',
'ruby',
's',
'samp',
'small',
'strike',
'strong',
'sub',
'sup',
'time',
'tt',
'u',
'var',
'wbr',
'form',
'input',
'textarea',
'button',
'select',
'optgroup',
'option',
'label',
'fieldset',
'legend',
'datalist',
'keygen',
'output',
'frame',
'frameset',
'noframes',
'iframe',
'img',
'map',
'area',
'canvas',
'figcaption',
'figure',
'audio',
'source',
'video',
'aside',
'a',
'link',
'nav',
'ul',
'ol',
'li',
'dir',
'dl',
'dt',
'dd',
'menu',
'table',
'caption',
'th',
'tr',
'td',
'thead',
'tbody',
'tfoot',
'col',
'colgroup',
'style',
'div',
'span',
'header',
'footer',
'section',
'article',
'details',
'summary',
'head',
'meta',
'base',
'basefont',
'script',
'noscript',
'applet',
'embed',
'object',
'param'
];
var jsKeywords = [
'auto',
'double',
'int',
'struct',
'break',
'else',
'long',
'switch',
'case',
'enum',
'register',
'typedef',
'char',
'var',
'extern',
'return',
'union',
'const',
'float',
'short',
'unsigned',
'continue',
'for',
'signed',
'void',
'default',
'GOTO',
'sizeof',
'volatile',
'do',
'if',
'static',
'while',
'function',
'delete',
'catch',
'in',
'this',
'while',
'instanceof',
'throw',
'with',
'finally',
'let',
'try',
'debugger',
'new',
'typeof'
];

function backLightHtml(txt) {
    var comments = [];
    var quotes = [];
    var attr = [];
	var htmlTagsReg = new RegExp('(&lt;\/?(' + htmlTags.join('|') + ')(&gt;|\\s))', 'g');
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
        .replace(htmlTagsReg, '<span class="code-tags">$1</span>')
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
function backLightPHP(txt) {
    var comments = [];
    var quotes = [];
	var phpOperatorReg = new RegExp('(\\s|\\!|\\(|^|\\t)(' + phpKeywords.join('|') + ')(\\s|\\(|$|;)', 'g');
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
        .replace(phpOperatorReg, '$1<span class="code-operator">$2</span>$3')
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
	var htmlTagsReg = new RegExp('(\\s|\\n|^)(' + htmlTags.join('|') + ')(\\s|,|:[a-zA-Z]|\\.|{|#)', 'g');
    txt = txt
        .replace(/\/\*[\s\S]*?\*\//g, function (str) {
            var l = comments.length;
            comments.push(str);
            return '~~~COMM' + l + '~~~';
        })
        .replace(htmlTagsReg, '$1<span class="code-tags">$2</span>$3')
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
	var jsKeywordsReg = new RegExp('(\\(|\\s|\\!|^)(' + jsKeywords.join('|') + ')(\\)|\\s|\\!|=|\\()', 'g');
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
        .replace(jsKeywordsReg, '$1<span class="code-operator">$2</span>$3')
        .replace(/(=|\s|\(|\t)"([^(code\-)].*?)"/g, '$1<span class="code-quotes">"$2"</span>')
        .replace(/\'([^(code\-)].*?)\'/g, '<span class="code-quotes">\'$1\'</span>')
        .replace(/~~~(COMM)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-comments">' + comments[num] + '</span>';
        })
    ;
    return txt;
}
function backlightC(txt) {
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
        .replace(/(\(|\s|\!|^)(auto|struct|break|else|switch|case|enum|register|NULL|typedef|extern|return|union|const|continue|for|signed|void|default|GOTO|sizeof|volatile|do|if|static|while)(\);||\s|\!|=|\()/g, '$1<span class="code-operator">$2</span>$3')
        .replace(/(\(|\s|\!|^)(bool|char|short|unsigned|int|long|float|double)(\)|\s|\!|=|\()/g, '$1<span class="code-types">$2</span>$3')
        .replace(/(\(|\s|\!|^|\[)([0-9]*)(\)|;|\]|\s|\!|=|\()/g, '$1<span class="code-number">$2</span>$3')
        .replace(/(=|\s|\(|\t)"([^(code\-)].*?)"/g, '$1<span class="code-quotes">"$2"</span>')
        .replace(/\'([^(code\-)].*?)\'/g, '<span class="code-quotes">\'$1\'</span>')
        .replace(/~~~(COMM)([0-9]*?)~~~/g, function (reg, str, num) {
            return '<span class="code-comments">' + comments[num] + '</span>';
        })
    ;
    return txt;
}
jQuery(document).ready(function () {
    jQuery('pre.html, pre.css, pre.php, pre.js, pre.slh__html, pre.slh__css, pre.slh__js, pre.slh__php, pre.slh__c').each(function () {
        var safe = {
            '<': '&lt;',
            '>': '&gt;'
        };
        var txt = jQuery(this).html();
        txt = txt
            .replace(/<!--\?php/g, '<?php')
            .replace(/\?-->/g, '?>')
            .replace(/[\<\>]/g, function (m) {
                return safe[m];
            });
        jQuery(this).html(txt);
    });
    jQuery('pre.html, pre.slh__html').each(function () {
        var txt = jQuery(this).html();
        txt = backLightHtml(txt);
        jQuery(this).html(txt);
    });
    jQuery('pre.css, pre.slh__css').each(function () {
        var txt = jQuery(this).html();
        txt = backlightCSS(txt);
        jQuery(this).html(txt);
    });
    jQuery('pre.php, pre.slh__php').each(function () {
        var php = [];
        var txt = jQuery(this).html();
        txt = txt
            .replace(/&lt;\?php([\s\S]*?)\?&gt;/g, function (str) {
                var l = php.length;
                php.push(backLightPHP(str));
                return '~~~PHP' + l + '~~~';
            });
        if (php.length > 0)		// если открывающих-закрывающих скобок php кода не было, значит весь код на php
        {
            txt = backLightHtml(txt);
            txt = txt.replace(/~~~(PHP)([0-9]*?)~~~/g, function (reg, str, num) {
                return php[num];
            });
        }
        else {
            txt = backLightPHP(txt)
        }
        jQuery(this).html(txt);
    });
    jQuery('pre.js, pre.slh__js').each(function () {
        var txt = jQuery(this).html();
        txt = backlightJs(txt);
        jQuery(this).html(txt);
    });
    jQuery('pre.slh__c').each(function () {
        var txt = jQuery(this).html();
        txt = backlightC(txt);
        jQuery(this).html(txt);
    });
});