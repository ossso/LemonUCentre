<?php

namespace LemonUCentre;

/**
 * 定义转换数据结构
 */
function defineDatainfo(&$info)
{
    $info = array(
        'User' => array(
            'fields' => array(
                'ID',
                'UID',
                'VIPType',
                'Points',
                'Gender',
                'Age',
                'CollectNums',
                'LikeNums',
                'FansNums',
                'Nickname',
                'Avatar',
                'InviteCode',
            ),
            'params' => array(
                'more' => array(
                    'type'  => 'fields',
                    'list'  => array(
                        'VIPTime',
                        'VIPDate',
                        'Phone',
                        'Phoned',
                        'Email',
                        'Emailed',
                        'Username',
                    ),
                ),
                'member' => array(
                    'type'  => 'object',
                    'name'  => 'User',
                    'value' => 'User',
                    'fun'   => 'Member',
                ),
                'admin' => array(
                    'type'  => 'fields',
                    'list'  => array(
                        'Token',
                        'UpdateTime',
                    ),
                ),
            ),
        ),
        'Member' => array(
            'fields' => array(
                'ID',
                'Name',
                'Avatar',
                'Email',
                'Level',
                'Status',
                'StaticName',
            ),
            'params' => array(
                'privacy' => array(
                    'type'  => 'fields',
                    'list'  => array(
                        'Articles',
                        'Comments',
                        'Uploads',
                        'Pages',
                        'Alias',
                        'Intro',
                    ),
                ),
            ),
        ),
        'Article' => array(
            'fields' => array(
                'ID',
                'CateID',
                'AuthorID',
                'Status',
                'IsTop',
                'IsLock',
                'Title',
                'Alias',
                'PostTime',
                'CommNums',
                'ViewNums',
                'Thumb',
            ),
            'params' => array(
                'url' => array(
                    'type'  => 'field',
                    'name'  => 'Url',
                    'value' => 'Url',
                ),
                'intro' => array(
                    'type'  => 'field',
                    'name'  => 'Intro',
                    'value' => 'Intro',
                ),
                'content' => array(
                    'type'  => 'field',
                    'name'  => 'Content',
                    'value' => 'Content',
                ),
                'cate' => array(
                    'type'  => 'object',
                    'name'  => 'Cate',
                    'value' => 'Category',
                    'fun'   => 'Category',
                ),
                'author' => array(
                    'type'  => 'object',
                    'name'  => 'Author',
                    'value' => 'Author',
                    'fun'   => 'User',
                ),
                'prev' => array(
                    'type'  => 'object',
                    'name'  => 'Prev',
                    'value' => 'Prev',
                    'fun'   => 'Article',
                ),
                'next' => array(
                    'type'  => 'object',
                    'name'  => 'Next',
                    'value' => 'Next',
                    'fun'   => 'Article',
                ),
            ),
        ),
        'Page' => array(
            'fields' => array(
                'ID',
                'Status',
                'IsLock',
                'Title',
                'Alias',
                'Content',
                'CommNums',
                'ViewNums',
            ),
        ),
        'Category' => array(
            'fields' => array(
                'ID',
                'Name',
                'Order',
                'Count',
                'Alias',
                'Intro',
                'RootID',
                'ParentID',
            ),
        ),
        'Tag' => array(
            'fields' => array(
                'ID',
                'Name',
                'Count',
            ),
        ),
        'Comment' => array(
            'fields' => array(
                'ID',
                'LogID',
                'IsChecking',
                'AuthorID',
                'Name',
                'Content',
                'ParentID',
                'PostTime',
            ),
            'params' => array(
                'post' => array(
                    'type'  => 'object',
                    'name'  => 'Post',
                    'value' => 'Post',
                    'fun'   => 'Article',
                ),
            ),
        ),
        'InviteCode' => array(
            'fields' => array(
                'ID',
                'LUID',
                'Type',
                'Status',
                'Code',
                'CreateTime',
                'UseTime',
            ),
            'params' => array(
                'user' => array(
                    'type'  => 'object',
                    'name'  => 'User',
                    'value' => 'User',
                    'fun'   => 'User',
                ),
            ),
        ),
        'RedeemType' => array(
            'fields' => array(
                'ID',
                'Lock',
                'Name',
                'Code',
                'Symbol',
                'Order',
                'Remark',
            ),
        ),
        'RedeemCode' => array(
            'fields' => array(
                'ID',
                'Status',
                'Code',
                'Value',
                'CodeValue',
            ),
            'params' => array(
                'more' => array(
                    'type'  => 'fields',
                    'list'  => array(
                        'TypeID',
                        'LUID',
                        'UseID',
                        'CreateTime',
                        'UseTime',
                    ),
                ),
                'use' => array(
                    'type'  => 'object',
                    'name'  => 'Use',
                    'value' => 'Use',
                    'fun'   => 'User',
                ),
                'type' => array(
                    'type'  => 'object',
                    'name'  => 'Type',
                    'value' => 'Type',
                    'fun'   => 'RedeemType',
                ),
            ),
        ),
    );

    return $info;
}
