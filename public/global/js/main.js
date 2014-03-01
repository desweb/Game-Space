$(function()
{
    /**
     * Events
     */

    /* Popup */

    $('#mask').click(function()
    {
        Interface.hidePopup();
    });

    $('.popup').click(function(e)
    {
        e.stopPropagation();
    });

    $('.popup .close').click(function()
    {
        Interface.hidePopup();
    });

    /* Form */

    $('input[type=file]').change(function()
    {
        if (!$(this).data('preview')) return false;

        Tools.previewImage($(this).data('preview'), this);
    });
});