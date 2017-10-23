$(function () {
    var isSelected = false;
    var categoryRoot = null;
    $('#submitSearch').click(function (e) {
       if(!isSelected) e.preventDefault();
    });
    $('#searchInput').autocomplete({
        source: function(request, response) {
            categoryRoot = request.term;
              $.ajax({
                  url: '/get_category',
                  method: 'GET',
                  dataType: 'JSON',
                  data: 'category=' + request.term,
                  success: response
              });
        },
        response: function(event, ui) {
                ui.content.unshift({'label': 'Ajouter une catégorie', 'value': 'Ajouter une catégorie'});
        },
        select: function(event, ui) {
            isSelected = true;
            if(ui.item.label === 'Ajouter une catégorie') {
                loadModalAddCategory();
                return false;
            }
            $('#searchInput').removeAttr('maxlength');
        }
        }).data('ui-autocomplete')._renderItem = function (ul, item) {
        if (item.label === 'Ajouter une catégorie') {
            return $('<li>').append('<div id="loadModalAddCategory"><span class="fa fa-plus"></span> ' + item.label + '</div>').appendTo(ul);
        }
        else {
            return $('<li>').append(item.label).appendTo(ul);
        }
    };

    function loadModalAddCategory() {
        $('#modalAddCategory').modal();
        $('#addCategoryBody').html('<span class="fa fa-spinner fa-pulse" aria-hidden="true"></span> Chargement...');
        $.ajax({
            url: $('#modalAddCategory').data('url') + '/' + categoryRoot,
            method: 'GET'
        }).done(function (content) {
            $('#addCategoryBody').html(content);
        })
    }
});
