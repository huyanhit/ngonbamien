const CONST = { 
    TAG: {
        ALL_TAG: /(\[\/?\w+)(.*?\])/g,
        TO_ALL: /(\[toall])/g,
        TO: /(\[to:([\d])+])/g,
        TO_ID: /to:([\d]+)/i,
        TO_ID_MULTI: /to:([\d]+)/g,

        PRODUCT: /(\[product:([\d])+])/g,
        PRODUCT_ID: /product:([\d]+)/i,

        IMG: /(\[img:([\d])+])/g,
        IMG_ID: /img:([\d]+)/i,

        FILE: /(\[file:([\d])+])/g,
        FILE_ID: /file:([\d]+)/i,

        REPLY: /(\[reply mid:([\d]+) to:([\d]+)( rid:([\d]+))*\])/g,

        REPLY_TO_ID: /to:([\d]+)/i,
        REPLY_TO_ID_MULTI: /to:([\d]+)/g,
        REPLY_MESSAGE_ID: /mid:([\d]+)/i,
        REPLY_ROOM_ID: /rid:([\d]+)/i,

        TAG_BOLD: /(\[b\])(.|\r|\n)*(?:\[\/b\])/g,
        TAG_B_RM_PR: /(\[b\])/g,
        TAG_B_RM_EN: /(\[\/b?\])/g,

        TAG_ITALIC: /(\[i\])(.|\r|\n)*(?:\[\/i\])/g,
        TAG_I_RM_PR: /(\[i\])/g,
        TAG_I_RM_EN: /(\[\/i?\])/g,

        TAG_CODE: /(\[code\])(.|\r|\n)*(?:\[\/code\])/g,
        TAG_CODE_RM_PR: /(\[code?\w+.*?\])/g,
        TAG_CODE_RM_EN: /(\[\/code?\w+.*?\])/g,

        AUTH: /(\[auth:([\d])+])/g,
        AUTH_ID: /auth:([\d]+)/i,

        ROOM: /(\[room:([\d])+])/g,
        ROOM_ID: /room:([\d]+)/i,

        MEMBER: /(\[members:([\d\-])+])/g,
        MEMBER_ID: /members:([\d\-]+)/i,

        LINK: /(https?):\/\/[^\s$.?#].[^\s\"\'\[\(\{]*/gm,
        LINK_APP: /\/chat\/(rid[-\d+]+[-\d+]+)/gm,

        TAG_BIND_VUE_OPEN: /(\{\{)/g,
        TAG_BIND_VUE_CLOSE: /(\}\})/g,
    },
    ROOM: {
        CREATE: /\[room-create\](.|\r|\n)*(?:room-create\])/g,
        UPDATE: /\[room-update\](.|\r|\n)*(?:room-update\])/g,
        ADD_MEMBER: /\[room-add-member\](.|\r|\n)*(?:room-add-member\])/g,
        UPDATE_MEMBER: /\[room-update-member\](.|\r|\n)*(?:room-update-member\])/g,
        DELETE_MEMBER: /\[room-delete-member\](.|\r|\n)*(?:room-delete-member\])/g,
        LEAVE_MEMBER: /\[room-leave-member\](.|\r|\n)*(?:room-leave-member\])/g,
    },
    REPLACE_MESSAGE: {
        CODE: '[RP_CODE]',
        UN_CODE: '[URP_CODE]',
        LINK: '[RP_LINK]'
    },
    HTML: {
        TO_ALL: '<span class="ico to-all"></span>',
    },
    ROUTE_LINK: /rid-([0-9]+)-([0-9]+)$/i,
    ROUTE_LINK_POSITION: /rid-([\d]+)$|rid-([\d]+).([\d]+)$/i,
}

export default CONST;