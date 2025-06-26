<?php
/**
 * AJAX Preview
 *
 * @copyright (c) 2025 medved
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace sasf\ajaxpreview;

/**
 * Extension base class
 */
class ext extends \phpbb\extension\base
{
    /**
     * Можем включить?
     *
     * @return bool
     */
    public function is_enableable()
    {
        return phpbb_version_compare(PHPBB_VERSION, '3.1.0', '>=');
    }
} 