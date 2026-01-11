/* global jQuery, wp */
(function ($) {
  'use strict';

  function initTffpPageHeroMeta() {
    var $id = $('#tffp_page_hero_bg_id');
    var $preview = $('#tffp_page_hero_bg_preview');

    if (!$id.length) {
      return;
    }

    var frame;

    function setPreview(url) {
      if (!url) {
        $preview.html('');
        return;
      }

      $preview.html(
        '<img src="' + url + '" alt="" style="max-width:100%;height:auto;display:block;border:1px solid #dcdcde;" />'
      );
    }

    $('#tffp-hero-bg-select').on('click', function (e) {
      e.preventDefault();

      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title: 'Selecteer achtergrondafbeelding',
        button: { text: 'Gebruik deze afbeelding' },
        library: { type: 'image' },
        multiple: false,
      });

      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        $id.val(attachment.id);

        var url = attachment.url;
        if (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) {
          url = attachment.sizes.medium.url;
        }
        setPreview(url);
      });

      frame.open();
    });

    $('#tffp-hero-bg-clear').on('click', function (e) {
      e.preventDefault();
      $id.val('');
      setPreview('');
    });
  }

  $(initTffpPageHeroMeta);
})(jQuery);
