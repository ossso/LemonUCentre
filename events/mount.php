<?php

namespace LemonUCentre;

/**
 * 挂载插件
 */
function mount_plugin()
{
    global $zbp;
    if (function_exists('LemonTemplate_Mount')) {
        $tplConfigs = $zbp->Config('LemonUCentre')->template;
        if (isset($tplConfigs)) {
            foreach ($tplConfigs as $item) {
                LemonTemplate_Mount($item[0], $item[1], $item[2], $item[3]);
            }
        }
    }
}

/**
 * 卸载插件
 */
function unmount_plugin()
{
    global $zbp;
    if (function_exists('LemonTemplate_Unmount')) {
        $tplConfigs = $zbp->Config('LemonUCentre')->template;
        if (isset($tplConfigs)) {
            foreach ($tplConfigs as $item) {
                LemonTemplate_Unmount($item[0]);
            }
        }
        LemonTemplate_Compiles();
    }
}
