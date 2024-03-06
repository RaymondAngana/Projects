jQuery(document).ready(function ($) {
    // Define tabs as an object that will populate with data.
    var tabs = {
        theading: [],
        tbody: {
            col0: [],
            col1: [],
            col2: [],
            col3: []
        }
    };

    // Get recommended value.
    $('.table-component table thead tr.recommended_row td').each(function (key) {
        if ($(this).hasClass('recommended')) {
            tabs.theading.push(key);
        }
    });

    // Build tab body.
    $(".table-component table tbody tr").each(function () {
        $('td', this).each(function (key) {
            var data = $(this).html();
            if (key == 0) tabs.tbody.col0.push(data);
            if (key == 1) tabs.tbody.col1.push(data);
            if (key == 2) tabs.tbody.col2.push(data);
            if (key == 3) tabs.tbody.col3.push(data);
        });
    });

    // Build table inside the tab for mobile.
    $(".table-component .tabs-content table").each(function () {
        var key = $(this).attr('class').split('panel')[1];
        var tabkey = parseInt(key) + 1;
        var table = '';
        for (var i = 0; i < tabs.tbody.col0.length; i++) {
            top_td = (i == 0) ? ' class="top"' : '';
            bottom_td = (i == tabs.tbody.col0.length-1) ? ' class="bottom"' : '';
            table += '<tr>';
            table += '<td>' + (tabs['tbody']['col0'][i]) + '</td>';
            table += '<td' + top_td + bottom_td + '>' + (tabs['tbody']['col' + tabkey][i]) + '</td>';
            table += '</tr>';
        }
        $(this).find('tbody').append(table);
        console.log('fired');
    });

    // Add "recommended" on top of the tab.
    $('.table-component .tabs .tabs-title a').each(function (key) {
        var href = $(this).attr('href');
        var index = href.split('#panel')[1];
        var indexoffset = parseInt(index) + 1;
        if (tabs.theading.indexOf(indexoffset) >= 0) {
            $(this).prepend("<strong>Recommended</strong>");
        }
    });

    let touchstartX = 0;
    let touchstartY = 0;
    let touchendX = 0;
    let touchendY = 0;

    $(".tabs-content td").on('touchstart', function(event) {
        touchstartX = event.changedTouches[0].screenX;
        touchstartY = event.changedTouches[0].screenY;
    });

    $(".tabs-content td").on('touchend', function(event) {
        touchendX = event.changedTouches[0].screenX;
        touchendY = event.changedTouches[0].screenY;
        handleGesture();
    });

    function handleGesture() {
     var xDiff = touchendX - touchstartX;
     var yDiff = touchendY - touchstartY;

      // Check if swipe left/right only.
      if (Math.abs(xDiff) > Math.abs(yDiff)) {
          // Swipe left.
          if (touchendX > touchstartX) {
            var $tab = $('#table-to-tab-component .is-active').prev();
            $tab.trigger('click').next().removeClass('is-active');
        }

          // Swipe right.
          if (touchendX < touchstartX) {
            var $tab = $('#table-to-tab-component .is-active').next();
            $tab.trigger('click').prev().removeClass('is-active');
        }
    }
}
});