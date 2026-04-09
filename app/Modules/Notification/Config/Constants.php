<?php

namespace App\Modules\Notification\Config;

class Constants
{
    # Cấu hình user setting notification
    public const user_setting = array(
        'default' => [
            'staffs'        => '[1]', // luôn nhận thông báo từ user này
            'auto_close'    => '5000',
            'position'      => 'right bottom',
            'sound'         => 'default',
            'open_popup'    => true,
            'notify_mobile' => false,
            'notify_os'     => false,
        ],
        'actions' => [
            [
                'module'  => 'chat',
                'command' => 'chat_message_send',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'chat',
                'command' => 'chat_direct_send',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'chat',
                'command' => 'chat_customer_send',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'chat',
                'command' => 'chat_add_contact',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'chat',
                'command' => 'chat_approve_contact',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'main',
                'command' => 'comment_product_detail',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'main',
                'command' => 'comment_post_detail',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'main',
                'command' => 'order_product',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'main',
                'command' => 'contact_send',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
            [
                'module'  => 'main',
                'command' => 'register_notify',
                'is_notify'  => true,
                'is_mute'    => false,
                'is_send'    => false,
            ],
        ]
    );

    public const command = [
        'chat_message_send' => [
            'title'   => 'message_send_title',
            'content' => 'message_send_content',
            'url'     => 'chat/rid-{room_id}-{position}',
            'type'    => 1,
        ],
        'chat_direct_send' => [
            'title'   => 'direct_send_title',
            'content' => 'direct_send_content',
            'url'     => 'chat/rid-{room_id}-{position}',
            'type'    => 1,
        ],
        'chat_customer_send' => [
            'title'   => 'customer_send_title',
            'content' => 'customer_send_content',
            'url'     => 'chat/rid-{room_id}-{position}',
            'type'    => 1,
        ],
        'chat_add_contact'  => [
            'title'   => 'chat_contact_add',
            'content' => 'chat_contact_add_content',
            'url'     => 'chat',
            'action'  => 'approve_contact',
            'type'    => 1
        ],
        'chat_approve_contact'  => [
            'title'   => 'chat_contact_approve',
            'content' => 'chat_contact_approve_content',
            'url'     => 'chat',
            'type'    => 1
        ],
        'comment_product_detail'  => [
            'title'   => 'comment_product_title',
            'content' => 'comment_product_content',
            'url'     => 'admin/comments/{id}/edit',
            'type'    => 2,
        ],
        'comment_post_detail'  => [
            'title'   => 'comment_post_title',
            'content' => 'comment_post_content',
            'url'     => 'admin/comments/{id}/edit',
            'type'    => 2,
        ],
        'order_product'  => [
            'title'   => 'order_product_title',
            'content' => 'order_product_content',
            'url'     => 'admin/orders/{id}/edit',
            'type'    => 2,
        ],
        'contact_send'  => [
            'title'   => 'contact_send_title',
            'content' => 'contact_send_content',
            'url'     => 'admin/contacts/{id}/edit',
            'type'    => 2,
        ],
        'register_notify'  => [
            'title'   => 'register_notify_title',
            'content' => 'register_notify_content',
            'url'     => 'admin/registers/{id}/edit',
            'type'    => 2,
        ],
    ];
}