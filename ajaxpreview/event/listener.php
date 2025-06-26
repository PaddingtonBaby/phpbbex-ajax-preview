<?php
/**
 * AJAX Preview Event Listener
 *
 * @copyright (c) 2025 medved
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace sasf\ajaxpreview\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
    /** @var \phpbb\template\template */
    protected $template;

    /** @var \phpbb\user */
    protected $user;

    /** @var string */
    protected $root_path;

    /** @var string */
    protected $php_ext;

    /**
     * Constructor
     *
     * @param \phpbb\template\template $template
     * @param \phpbb\user $user
     * @param string $root_path
     * @param string $php_ext
     */
    public function __construct(
        \phpbb\template\template $template,
        \phpbb\user $user,
        $root_path,
        $php_ext
    ) {
        $this->template = $template;
        $this->user = $user;
        $this->root_path = $root_path;
        $this->php_ext = $php_ext;
    }

    /**
     * Assign functions defined in this class to event listeners in the core
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'core.viewtopic_assign_template_vars_before' => 'add_ajax_preview_assets',
        ];
    }

    /**
     * Add JavaScript and CSS for AJAX preview
     *
     * @param \phpbb\event\data $event
     */
    public function add_ajax_preview_assets($event)
    {
        // Языковые переменные для JavaScript
        $this->user->add_lang_ext('sasf/ajaxpreview', 'ajax_preview');

        // Переменные в шаблон
        $this->template->assign_vars([
            'AJAX_PREVIEW_URL' => append_sid("{$this->root_path}app.{$this->php_ext}/ajaxpreview"),
            'L_AJAX_PREVIEW' => $this->user->lang('AJAX_PREVIEW'),
            'L_AJAX_PREVIEW_LOADING' => $this->user->lang('AJAX_PREVIEW_LOADING'),
            'L_AJAX_PREVIEW_ERROR_GENERIC' => $this->user->lang('AJAX_PREVIEW_ERROR_GENERIC'),
            'L_AJAX_PREVIEW_TITLE' => $this->user->lang('AJAX_PREVIEW_TITLE'),
            'L_AJAX_PREVIEW_EMPTY_MESSAGE' => $this->user->lang('AJAX_PREVIEW_EMPTY_MESSAGE'),
            'S_AJAX_PREVIEW_ENABLED' => true,
        ]);
    }
} 