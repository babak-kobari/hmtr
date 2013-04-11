$(document).ready(function () {

    
    // Common function to change the color onfocus of the textfield and textarea
    $('textarea').live('focus', function () {
        $(this).addClass('highlighted').parent().addClass('highlighted');
    });
    $('textarea').live('blur', function () {
        $(this).removeClass('highlighted').parent().removeClass('highlighted');
    });
    $('input[type=text]').live('focus', function () {
        $(this).addClass('highlighted').parent().addClass('highlighted');
    });
    $('input[type=text]').live('blur', function () {
        $(this).removeClass('highlighted').parent().removeClass('highlighted');
    });
    $('input[type=password]').live('focus', function () {
        $(this).addClass('highlighted').parent().addClass('highlighted');
    });
    $('input[type=password]').live('blur', function () {
        $(this).removeClass('highlighted').parent().removeClass('highlighted');
    });
	
	function ShowCloseButton() {

    $('.close-selector li, .frnd-frnd-listing figure').hover(function () {
        $(this).find('a.close-btn-01, a.close-btn-03').show();
        //        $(this).css('cursor', 'default');
    }, function () {
        $(this).find('a.close-btn-01, a.close-btn-03').hide();
    });

}
    //var documentHeight = $('header').height()+$('.cnt-pnl').height()+$('footer').height();

    //radio selected highlight
    /*$('.frm-rows input[type=radio]').each(function(){
    if($('.frm-rows :radio]').is(':checked'))
    {
    $(this).parent().css('color','#087eba');
    }
    });*/
    //comment box focus functions
    $('.commentBox').focus(function () {
        // if ($(this).val() == '') {
        $(this).parent().parent().next().fadeIn();
        //}
    });

    // text area auto grow function calls for the post comment section
    $(".autogrow").live("focus", function () {
        if (this.value == 'Post your comment') { this.value = '' };
        $(this).animate({ height: '70px' }, 400);
    });
    $(".autogrow").live("blur", function () {
        if (this.value == '') { this.value = 'Post your comment' };
        if ($(this).val() == 'Post your comment') {
            $(this).animate({ 'height': '18px' });
        }
    });
 }); 