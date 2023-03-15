<?php
/**
 * Head输出
 */
function LemonUCentre_Head()
{
    global $zbp;
    $title = $zbp->template->templateTags['title'];
    $split = '-';

    $output_title = '<title>'.$title.$split.$zbp->name.'</title>';

    echo $output_title . "\n";
}

/**
 * 替换通用关键词
 */
function LemonUCentre_HeadOutReplace(&$str)
{
    global $zbp;

    if ($zbp->Config('LemonUCentre')->titleSplit) {
        $split = $zbp->Config('LemonUCentre')->titleSplit;
    } else {
        $split = '-';
    }
    $title = $zbp->template->templateTags['title'];

    $str = preg_replace('/\{%title%\}/', $title, $str);
    $str = preg_replace('/\{%split%\}/', $split, $str);
    $str = preg_replace('/\{%name%\}/', $zbp->name, $str);
    $str = preg_replace('/\{%domain%\}/', $_SERVER['HTTP_HOST'], $str);
}
