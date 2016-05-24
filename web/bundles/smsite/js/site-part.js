var FUNCTION_TO_EXECUTE_REMOTELY =
{
    "getQuote":getQuote,
    "get_status_admin_put_content":get_status_admin_put_content
};
var CHAT_BOX = null;

function get_part_html_put_content(id_from,path,id_to_put)
{
    var a_click = $("#"+id_to_put);
    var li_active = (id_from != null && $("#"+id_from).hasClass("active"));
    if(!li_active){
        a_click.html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.ajax(
            {
                url: path,
                success: function(result){
                    $("#"+id_to_put).html(result);
                }
            }
        );
    }
}


function post_form(path,data)
{
    var content =  $('#content-content-lte');
    content.html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.ajax(
        {
            url: path,
            data: data,
            success: function(result){
                content.html(result);
            }
        }
    );
}

//exemple use 'del_by_id("{{ path('sh_stock_delete') }}","{{ stock.id }}")'
function click_with_id(path,data)
{
    var data2={'id':data};
    post_form(path,data2);
}

function click_with_item_stock(path,item,stock)
{
    var data = {'item_id':item,'stock_id':stock};
    post_form(path,data);
}


function post_form_with_image(path,data)
{
    var content =  $('#content-content-lte');
    content.html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.ajax(
        {
            url: path,
            type: 'post',
            data: data,
            success: function(result){
            content.html(result);
        }
    }
);
}

function getQuote() {
    $.ajax({
        jsonp: "jsonp",
        dataType: "jsonp",
        url: 'http://api.forismatic.com/api/1.0/',
        contentType: 'application/jsonp',
        data: {
            lang: "en",
            method: "getQuote",
            format: "jsonp"
        },
        success: function (data) {
            var text = data.quoteText;
            var author = null;
            if (data.quoteAuthor === "") {
                author = '~ Unknown ~';
            } else {
                author = data.quoteAuthor;
            }
            $('#quote-text').html(text);
            $('#quote-author').html(author);
            $('#quote-container').removeClass("hide");
        },
        error: function (data) {
            $('#quote-text').html("Error Loading Quote");
            $('#quote-author').html('~ Sorry ~');
            $('#quote-container').removeClass("hide");
        }
    });
}

function get_status_admin_put_content()
{
    $.ajax({
        dataType: "json",
        url: 'app_dev.php/ajax/status/admin',
        contentType: 'application/json',
        success: function (admin) {
            var id_admin_name = $("#admin-name");
            var id_admin_status = $("#admin-login-status");
            id_admin_name.html(admin.name);
            var status = admin.login_status;
            if(status)
            {
                id_admin_status.html('<i class="fa fa-circle text-success"></i> Online (chat with me)');
            }else
            {
                id_admin_status.html('<i class="fa fa-circle text-danger"></i> Offline - '+admin.last_login);
            }

        }
    });
}

function contact_send_email(id_email, id_subject ,id_message, id_info)
{
    var email = $("#"+id_email);
    var message = $("#"+id_message);
    var subject = $("#"+id_subject);
    var info = $("#"+id_info);
    $.ajax({
        method: "POST",
        url: 'app_dev.php/ajax/email/send',
        data: {email: email.val(), subject: subject.val(), message: message.val()},
        success: function (result) {
            info.removeAttr("class");
            if(result.success)
            {
                info.attr( "class", "alert alert-success fade in" );
                info.html('<a href="#" class="close" onclick="$(\'#'+id_info+'\').hide()">&times;</a>'
                    +'<strong>Ok!</strong> Mail envoyé ;).');
                message.summernote('code', '');
                email.val('');
                subject.val('');
            }else{
                info.attr( "class", "alert alert-danger fade in" );
                info.html('<a href="#" class="close" onclick="$(\'.'+id_info+'\').hide()">&times;</a>'
                    +'<strong>Erreur!</strong> Problème d\'envoi de mail.');
            }
            info.show();
        }
    });
}

function show_chat_box()
{
    CHAT_BOX.show();
    CHAT_BOX.unCollapse();
}

function _exec_javascript_by_name(func_to_execute)
{
    try
    {
        FUNCTION_TO_EXECUTE_REMOTELY[func_to_execute]();
    }catch(ex) {}
}

function google_pretty_on()
{
    $(document).ready(function() {
        var prettyprint = false;
        $("pre code").parent().each(function() {
            $(this).addClass('prettyprint linenums');
            prettyprint = true;
        });
        if ( prettyprint ) {
            $.getScript("https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js");
            // ? skin = [ desert , doxy , sons-of-obsidian , sunburst]
        }
    });
}