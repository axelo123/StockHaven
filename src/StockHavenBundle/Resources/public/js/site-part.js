function get_part_html_put_content(path,id_to_put)
{
    // spinner here
    $("#"+id_to_put).html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.ajax(
        {
            url: path,
            success: function(result){
                $("#"+id_to_put).html(result);
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