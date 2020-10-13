var l10n = wp.media.view.l10n, client_id = '';
wp.media.view.MediaFrame.Select.prototype.browseRouter = function (routerView) {
    routerView.set({
        upload: {
            text: l10n.uploadFilesTitle,
            priority: 20
        },
        browse: {
            text: l10n.mediaLibraryTitle,
            priority: 40
        },
        my_tab: {
            text: "Widen Collective",
            priority: 60
        }
    });
};

jQuery(document).ready(function ($) {
    if (wp.media) {
        wp.media.view.Modal.prototype.on( "open", function() {

            if ($('.media-frame-tab-panel button.media-menu-item.active').text() == "Widen Collective") {
                doMyTabContent();
            }
            else {
                $('.media-frame-toolbar').show();
            }
        });
        $(wp.media).on('click', '.media-router a.media-menu-item', function (e) {
            if (e.target.innerText == "Widen Collective") {
                doMyTabContent();
            }
            else {
                $('.media-frame-toolbar').show();
            }
        });
    }
    window.addEventListener('message', function (event) {
      try {
        var embedCode = event.data.items[0];
        window.parent.send_to_editor(embedCode, client_id);
      } catch(e) {}
    });

    window.send_to_editor = function (embed, clientID) {
        if (embed.embed_link !== null) {
            let block = wp.blocks.createBlock('core/image', {url: embed.embed_link, alt: embed.embed_name});
            var ids = wp.data.select('core/block-editor').getBlockOrder();
            wp.data.dispatch('core/block-editor').insertBlocks(block);
            $('.media-modal-close').trigger('click');
        }
    }
});
function doMyTabContent() {
    var loading = '<img src="../wp-content/plugins/widendam/images/ajax_loader_blue_128.gif" /><br /><h3>Loading...</h3>';
    client_id = client_id == '' ? jQuery(event.target).parents('.wp-block-image').parent().attr('data-block') : client_id;
    jQuery('.media-frame-toolbar').hide();
    jQuery('body .media-modal-content .media-frame-content').css({'textAlign': 'center', 'paddingTop': '20px'}).html(loading);
    jQuery('body .media-modal-content .media-frame-content').load('./upload.php?page=DAMLibrary&tab=1 #widen_media_body');
}
