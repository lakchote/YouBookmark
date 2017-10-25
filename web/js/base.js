$(function () {
    var isSelected = false;
    var categoryRoot = null;
    var addCategory = 'Ajouter une catégorie';
    $('#submitSearch').click(function (e) {
       if(!isSelected) e.preventDefault();
    });
    $('#searchInput').autocomplete({
        source: function(request, response) {
            categoryRoot = request.term.toUpperCase();
              $.ajax({
                  url: '/get_category',
                  method: 'GET',
                  dataType: 'JSON',
                  data: 'category=' + request.term,
                  success: response
              });
        },
        response: function(event, ui) {
                ui.content.unshift({'label': addCategory, 'value': addCategory});
        },
        select: function(event, ui) {
            isSelected = true;
            if(ui.item.label === 'Ajouter une catégorie') {
                loadModalAddCategory();
                return false;
            }
        }
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
        if (item.label === 'Ajouter une catégorie') {
            return $('<li>').append('<div id="loadModalAddCategory"><span class="fa fa-plus"></span> ' + item.label + '</div>').appendTo(ul);
        }
        else {
            return $('<li>').append('<a href="' +  '/show/' + categoryRoot + '/' + item.label + '">' + item.label + '</a>').appendTo(ul);
        }
    };

    function loadModalAddCategory() {
        $('#modalAddCategory').modal();
        $('#addCategoryBody').html('<div style="color:#000;"><span class="fa fa-spinner fa-pulse" aria-hidden="true"></span> Chargement...</div>');
        $.ajax({
            url: $('#modalAddCategory').data('url') + '/' + categoryRoot,
            method: 'GET'
        }).done(function (content) {
            $('#addCategoryBody').html(content);
        });
    }

    $('#searchInput').focus(function () {
        $('#removeCategory').css('display', 'none');
        $('#camel').css('bottom', '20px');
    }).blur(function () {
        $('#removeCategory').css('display', 'block');
        $('#camel').css('bottom', '60px');
    });

    $('#removeCategory').click(function () {
        loadModalRemoveCategory();
    });

    function loadModalRemoveCategory() {
        $('#modalRemoveCategory').modal();
        $('#removeCategoryBody').html('<div style="color:#000;"><span class="fa fa-spinner fa-pulse" aria-hidden="true"></span> Chargement...</div>');
        $.ajax({
           url: $('#modalRemoveCategory').data('url'),
           method: 'GET'
        }).done(function (content) {
           $('#removeCategoryBody').html(content);
        });
    };
});
