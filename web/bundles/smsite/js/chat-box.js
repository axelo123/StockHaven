var Class = function(methods) {
    var klass = function() {
        this.initialize.apply(this, arguments);
    };

    for (var property in methods) {
        klass.prototype[property] = methods[property];
    }

    if (!klass.prototype.initialize) klass.prototype.initialize = function(){};

    return klass;
};

if (!String.prototype.format) {
    String.prototype.format = function() {
        var str = this.toString();
        if (!arguments.length)
            return str;
        var args = typeof arguments[0],
            args = (("string" == args || "number" == args) ? arguments : arguments[0]);
        for (arg in args)
            str = str.replace(new RegExp("\\{" + arg + "\\}", "gi"), args[arg]);
        return str;
    }
}

var ChatBox = Class({
    initialize: function(id, options) {
        this.id = id;
        this.options = options;
        this.options['send_function'] = (Object.prototype.toString.call(this.options['send_function']) == '[object Function]')?
            this.options['send_function'].name : this.options['send_function'];
    },
    create: function(id,send_function)
    {
        $('#'+id).html(this.priv_createChatContainer());
    },
    getId: function()
    {
        return this.id;
    },
    addMessage: function(user_name,message,date,avatar,is_receive)
    {
        if(avatar == null || avatar.length < 2)
        {
            avatar = this.options['default_avatar'];
        }
        if(date == null || date.length < 2)
        {
            date = private_datetime_now_string();
        }
        var msg = this.priv_createMessage(user_name,message,date,avatar,is_receive);
        var id_chat_message = $("#"+this.id+"-container-msg");
        id_chat_message.html(id_chat_message.html()+msg);
    },
    addContact: function(user_name,last_message,last_date,avatar)
    {
        if(avatar == null || avatar.length < 2)
        {
            avatar = this.options['default_avatar'];
        }
        var contact = this.priv_createContact(user_name,last_message,last_date,avatar);
        var id_chat_contact = $("#"+this.id+"-contacts-add");
        id_chat_contact.html(id_chat_contact.html()+contact);
    },
    setUnreadTooltip: function(unread_tooltip)
    {
        var id_unread = $("#"+this.id+"-unread");
        id_unread.attr("data-original-title",unread_tooltip);
    },
    setUnreadNumber: function(unread_number)
    {
        var id_unread = $("#"+this.id+"-unread");
        id_unread.html(unread_number);
    },
    isCollapsed: function()
    {
        return $('#'+this.id).hasClass("collapsed-box");
    },
    toggleCollapse: function()
    {
        var id_chat_box = $('#'+this.id);
        id_chat_box.toggleClass("collapsed-box");
        var box_body = id_chat_box.find('.box-body');
        var box_footer = id_chat_box.find('.box-footer');
        var button_minus_plus = $("#"+this.id+"-minus");
        if(this.isCollapsed())
        {
            box_footer.attr("style","display: none;");
            box_body.attr("style","display: none;");
            button_minus_plus.html('<i class="fa fa-plus"></i>');
        }else{
            box_footer.attr("style","display: block;");
            box_body.attr("style","display: block;");
            button_minus_plus.html('<i class="fa fa-minus"></i>');
        }
    },
    collapse: function()
    {
        var id_chat_box = $('#'+this.id);
        if(!id_chat_box.hasClass("collapsed-box"))
        {
            id_chat_box.addClass("collapsed-box");
        }
        id_chat_box.find('.box-body').attr("style", "display: none;");
        id_chat_box.find('.box-footer').attr("style", "display: none;");
        $("#"+this.id+"-minus").html('<i class="fa fa-plus"></i>')
    },
    unCollapse: function()
    {
        var id_chat_box = $('#'+this.id);
        if(id_chat_box.hasClass("collapsed-box"))
        {
            id_chat_box.removeClass("collapsed-box");
        }
        id_chat_box.find('.box-body').attr("style","display: block;");
        id_chat_box.find('.box-footer').attr("style","display: block;");
        $("#"+this.id+"-minus").html('<i class="fa fa-minus"></i>');
    },
    toggleContacts: function()
    {
        $("#"+this.id).toggleClass("direct-chat-contacts-open")
    },
    hide: function()
    {
        $("#"+this.id).attr("style","display: none;");
    },
    show: function()
    {
        $("#"+this.id).attr("style","display: block;");
    },
    priv_createMessage: function(user_name,message,date,avatar,is_receive)
    {
        var class_chat = is_receive?'direct-chat-msg':'direct-chat-msg right';
        var formated_html = '<div class="{class_chat}"><div class="direct-chat-info clearfix">' +
            '<span class="direct-chat-name pull-left">{user_name}</span>' +
            '<span class="direct-chat-timestamp pull-right">{date}</span>' +
            '</div><img class="direct-chat-img" src="{avatar}"' +
            'alt="message user image"><div class="direct-chat-text">' +
            '{message}</div></div>';

        return formated_html.format(
                {
                    user_name:user_name,
                    date:date,
                    avatar:avatar,
                    message:message,
                    class_chat:class_chat
                });
    },
    priv_createContact: function(user_name,last_message,last_date,avatar)
    {
        var formated_html = '<li><a href="#"><img class="contacts-list-img" src="{avatar}">' +
            '<div class="contacts-list-info">' +
            '<span class="contacts-list-name">{user_name} <small class="contacts-list-date pull-right">{last_date}</small>' +
            '</span><span class="contacts-list-msg">{last_message}</span>' +
            '</div></a></li>';

        return formated_html.format(
                {
                    user_name:user_name,
                    last_date:last_date,
                    avatar:avatar,
                    last_message:last_message
                });
    },
    priv_createChatContainer: function()
    {
        var placeholder = "Type message ...";
        var title = "Chat Box Sm";
        var unread_tooltip = "0 Messages";
        var unread_number = "0";
        var formated_html = '<div id="{id}" class="box box-primary direct-chat direct-chat-primary">' +
            '<div class="box-header with-border">' +
            '<h3 class="box-title">{title}</h3><div class="box-tools pull-right">' +
            '<span id="{id}-unread" data-toggle="tooltip" title="" class="badge bg-light-blue" data-original-title="{unread_tooltip}">' +
            '{unread_number}</span><button id="{id}-minus" class="btn btn-box-tool" data-widget="collapse">' +
            '<i class="fa fa-minus"></i></button><button id="{id}-contacts" class="btn btn-box-tool" ' +
            'data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">' +
            '<i class="fa fa-comments"></i></button><button id="{id}-remove" class="btn btn-box-tool" onclick="$(\'#{id}\').hide()">' +
            '<i class="fa fa-times"></i></button></div></div><div class="box-body" style="display: block;">' +
            '<div id="{id}-container-msg" class="direct-chat-messages"></div><div id="{id}-contacts-div" class="direct-chat-contacts">' +
            '<ul id="{id}-contacts-add" class="contacts-list"></ul></div></div><div class="box-footer" ' +
            'style="display: block;"><form action="#" method="post"><div class="input-group">' +
            '<input id="{id}-input" type="text" name="message" placeholder="{placeholder}" class="form-control">' +
            '<span class="input-group-btn"><button onclick="{send_function}(\'{id}-input\');" id="{id}-send" type="button" class="btn btn-primary btn-flat">' +
            'Send</button></span></div></form></div></div>';
        return formated_html.format(
                {
                    title:title,
                    placeholder:placeholder,
                    id:this.id,
                    unread_number:unread_number,
                    unread_tooltip:unread_tooltip,
                    send_function: this.options['send_function']
                });
    }
});

function private_datetime_now_string()
{
    /*
    var monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre",
        "Octobre", "Novembre", "Decembre"
    ];*/

    var date = new Date();
    /*var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();*/
    var hour = date.getHours();
    var minutes = date.getMinutes();
    var second = date.getSeconds();

    return hour+":"+minutes+":"+second;
}