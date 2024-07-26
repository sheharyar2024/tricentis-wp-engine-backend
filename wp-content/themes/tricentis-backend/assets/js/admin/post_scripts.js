(function($) {
    $(document).ready(function() {
        function triggerTemplateSelection() {
        var location = window.document.location;
        if (!location.pathname.includes('wp-admin/post-new.php')) return;

        var select = $("#page_template");
        setTimeout(() => { // Timeout needed in order to trigger the admin-ajax.php endpoint.
        select.trigger('change');
        }, 250);
        
    };
    triggerTemplateSelection();
    });
})(jQuery)