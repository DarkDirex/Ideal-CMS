<?php
/**
 * Ideal CMS (http://idealcms.ru/)
 * @link      http://github.com/ideals/idealcms репозиторий исходного кода
 * @copyright Copyright (c) 2012-2015 Ideal CMS (http://idealcms.ru)
 * @license   http://idealcms.ru/license.html LGPL v3
 */
return array(
    'params' => array(
        'has_table' => true
    ),
    'fields' => array(
        'part_id' => array(
            'label' => 'Идентификатор страницы',
            'sql'   => 'int(11)',
        ),
        'tag_id' => array(
            'label' => 'Идентификатор тега',
            'sql'   => 'int(11)',
        ),
        'parent_id' => array(
            'label' => 'ID родительских структур',
            'sql'   => 'char(15)',
            'type'  => 'Ideal_Hidden'
        )
    )
);
