<?php
/**
 * AJAX Preview языковой файл (Russian)
 *
 * @copyright (c) 2025 medved
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = [];
}

$lang = array_merge($lang, [
    'AJAX_PREVIEW'              => 'Предпросмотр',
    'AJAX_PREVIEW_LOADING'      => 'Загрузка...',
    'AJAX_PREVIEW_TITLE'        => 'Предпросмотр сообщения',
    'AJAX_PREVIEW_ERROR_GENERIC' => 'Ошибка при загрузке предпросмотра',
    'AJAX_PREVIEW_NO_MESSAGE'   => 'Отсутствует сообщение',
    'AJAX_PREVIEW_EMPTY_MESSAGE' => 'Введите текст сообщения для предпросмотра',
    'AJAX_PREVIEW_ERROR'        => 'Ошибка обработки',
]); 