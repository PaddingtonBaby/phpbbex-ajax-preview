<?php
/**
 * AJAX Preview Controller
 *
 * @copyright (c) 2025 medved
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace sasf\ajaxpreview\controller;

/**
 * Preview controller
 */
class preview
{
    /** @var \phpbb\request\request */
    protected $request;

    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\auth\auth */
    protected $auth;

    /** @var \phpbb\config\config */
    protected $config;

    /**
     * Constructor
     *
     * @param \phpbb\request\request $request
     * @param \phpbb\user $user
     * @param \phpbb\auth\auth $auth
     * @param \phpbb\config\config $config
     */
    public function __construct(
        \phpbb\request\request $request,
        \phpbb\user $user,
        \phpbb\auth\auth $auth,
        \phpbb\config\config $config
    ) {
        $this->request = $request;
        $this->user = $user;
        $this->auth = $auth;
        $this->config = $config;
    }

    /**
     * Handle AJAX preview request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle()
    {
        header('Content-Type: application/json');
        
        if (!$this->request->is_set_post('message')) {
            echo json_encode([
                'error' => 'Отсутствует сообщение'
            ]);
            exit;
        }

        $message = $this->request->variable('message', '', true);
        $forum_id = $this->request->variable('f', 0);

        if (empty(trim($message))) {
            echo json_encode([
                'preview' => '',
                'error' => 'Сообщение пустое'
            ]);
            exit;
        }

        if ($forum_id > 0 && !$this->auth->acl_get('f_read', $forum_id)) {
            echo json_encode([
                'preview' => '',
                'error' => 'Нет прав доступа к форуму'
            ]);
            exit;
        }

        try {
            global $phpbb_root_path, $phpEx;
            if (!class_exists('parse_message')) {
                include($phpbb_root_path . 'includes/message_parser.' . $phpEx);
            }

            $message_parser = new \parse_message();
            $message_parser->message = $message;

            $enable_bbcode = $this->config['allow_bbcode'] && $this->auth->acl_get('f_bbcode', $forum_id);
            $enable_smilies = $this->config['allow_smilies'] && $this->auth->acl_get('f_smilies', $forum_id);
            $enable_urls = $this->config['allow_post_links'];
            $enable_img = $enable_bbcode && $this->auth->acl_get('f_img', $forum_id);
            $enable_flash = $enable_bbcode && $this->auth->acl_get('f_flash', $forum_id) && $this->config['allow_post_flash'];
            $enable_quote = $enable_bbcode;

            $message_parser->parse(
                $enable_bbcode,
                $enable_urls,
                $enable_smilies,
                $enable_img,
                $enable_flash,
                $enable_quote,
                $enable_urls
            );

            $preview_html = $message_parser->format_display(
                $enable_bbcode,
                $enable_urls,
                $enable_smilies,
                false
            );

            echo json_encode([
                'preview' => $preview_html,
                'error' => ''
            ]);

        } catch (\Exception $e) {
            echo json_encode([
                'preview' => '',
                'error' => 'Ошибка обработки: ' . $e->getMessage()
            ]);
        }
        
        exit;
    }
} 