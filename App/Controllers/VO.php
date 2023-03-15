<?php

namespace LemonUCentre\Controllers;

/**
 * VO输出
 */
class VO
{
    /**
     * Object对象信息转为Array数组信息
     * 
     * @param object $obj
     * @param array $list
     * @param array $data
     */
    static public function transform($obj, $list = [], &$data = [])
    {
        foreach ($list as $key) {
            $data[$key] = $obj->$key;
        }
    }

    /**
     * 转换数据
     */
    static public function to($type, $obj, $args = [], $datainfo = [])
    {
        global $lemon_uc;

        $data = array();

        foreach ($GLOBALS['hooks']['Filter_Plugin_LemonUCentre_VO_To_Begin'] as $fpname => &$fpsignal) {
            $fpname($data, $type, $obj, $args, $datainfo);
        }

        if (empty($datainfo)) {
            $datainfo = $lemon_uc->datainfo;
        }

        if (array_key_exists($type, $datainfo)) {
            $info = $datainfo[$type];
        } else if (array_key_exists($type, $lemon_uc->datainfo)) {
            $info = $lemon_uc->datainfo[$type];
        } else {
            return $data;
        }

        self::transform($obj, $info['fields'], $data);

        if (array_key_exists('params', $info)) {
            $params = $info['params'];
            foreach ($params as $key => $item) {
                if (array_key_exists($key, $args) && $args[$key]) {
                    switch ($item['type']) {
                        case 'fields':
                            self::transform($obj, $item['list'], $data);
                        break;
                        case 'field':
                            $key = $item['name'];
                            $val = $item['value'];
                            $val = $obj->$val;
                            $data[$key] = $val;
                        break;
                        case 'metas':
                            $key = $item['name'];
                            $val = $item['value'];
                            $val = $obj->Metas->$val;
                            $data[$key] = $val;
                        break;
                        case 'object':
                            $key = $item['name'];
                            $val = $item['value'];
                            $val = $obj->$val;
                            $data[$key] = null;
                            if ($val) {
                                $params = array();
                                if (array_key_exists('params', $item)) {
                                    $params = $item['params'];
                                }
                                $data2 = self::to($item['fun'], $val, $params, $datainfo);
                                $data[$key] = $data2;
                            }
                        break;
                        default:
                    }
                }
            }
        }

        foreach ($GLOBALS['hooks']['Filter_Plugin_LemonUCentre_VO_To_End'] as $fpname => &$fpsignal) {
            $fpname($data, $type, $obj, $args, $datainfo);
        }

        return $data;
    }
}
