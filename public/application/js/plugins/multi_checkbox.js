/*
 Dropdown with Multiple checkbox select with jQuery - May 27, 2013
 (c) 2013 @ElmahdiMahmoud
 license: http://www.opensource.org/licenses/mit-license.php
 */

$(".dropdown dt a").on('click', function (e) {
    e.preventDefault();
    $(".dropdown dd ul").slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function (e) {
    e.preventDefault();
    $(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
    return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function (e) {
    var $clicked = $(e.target);
    if (!$clicked.parents().hasClass("dropdown"))
        $(".dropdown dd ul").hide();
});

$('.mutliSelect input[type="checkbox"]').on('click', function () {
    apply_title_multi_select();
});

function apply_title_multi_select()
{
    var title = [];
    $(".mutliSelect li input[type='checkbox']").each(function(i){
        if($(this).is(':checked')){
            title.push($(this).closest('li').find('.select-label').html());
        }
    });
    title = title.join(", ");
    var html = '<span>' + title + '</span>';
    $('.multiSel').html(html);
    
    if(title.length == 0)
    {
        $(".hida").show();
    }
    else
    {
        $(".hida").hide();
    }
}