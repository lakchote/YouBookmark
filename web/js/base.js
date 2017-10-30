$(function () {
    var isSelected = false;
    var categoryRoot = null;
    var addCategory = 'Ajouter une catégorie';
    $('#submitSearch').click(function (e) {
        if(!isSelected) e.preventDefault();
    });
    (function randomQuote() {
        var citations = [
            'Le talent, ça n’existe pas. Le talent, c’est d’avoir envie de faire quelque chose.',
            'Tout le monde est un génie. Mais si on juge un poisson sur sa capacité à grimper à un arbre, il passera sa vie à croire qu’il est stupide.',
            'Riez tant que vous pouvez : c’est un médicament économique.',
            'L’optimiste ne refuse jamais de voir le côté négatif des choses ; il refuse simplement de s’attarder dessus.',
            'Nous commençons à vieillir quand nous remplaçons nos rêves par des regrets.',
            'Ce n’est pas la chute qui représente l’échec. L’échec, c’est de rester là où l’on est tombé…',
            'Qui veut faire quelque chose trouve un moyen, qui ne veut rien faire trouve une excuse.',
            'Il n’est jamais trop tard pour devenir ce que nous aurions pu être.',
            'Accueillir avec confiance une difficulté, c’est déjà la faciliter.',
            'L’attitude est le pinceau de l’esprit. Elle colore toutes les situations.',
            'La difficulté de réussir ne fait qu’ajouter à la nécessité d’entreprendre.',
            'Il suffit d’une minute pour changer votre attitude et avec cette minute, vous pouvez changer toute votre journée.',
            'La croyance que rien ne change provient soit d’une mauvaise vue, soit d’une mauvaise foi. La première se corrige, la seconde se combat.',
            'N’attendez pas d’être heureux pour sourire, souriez pour être heureux.',
            'C’est malheureux de s’égarer. Mais il y a pire que de perdre son chemin : c’est de perdre sa raison d’avancer.',
            'Un sourire coûte moins cher que l’électricité, mais donne autant de lumière.',
            'Ne laissez pas le monde changer votre sourire, mais laissez votre sourire changer le monde.',
            'Mettez en tout un grain d’audace.',
            'Si vous voulez que la vie vous sourie, apportez-lui votre bonne humeur.',
            'Il y a des jours avec et des jours sans…et les jours sans, il faut faire avec !',
            'Il est plus facile de désintégrer un atome qu’un préjugé.',
            'La seule véritable erreur est celle dont on ne tire aucun enseignement.',
            'La seule limite à notre épanouissement de demain sera nos doutes d’aujourd’hui.',
            'J’ai décidé d’être heureux parce que c’est bon pour la santé.',
            'L’amour que l’on donne est le seul qui nous reste.',
            'Il y a des fleurs partout pour qui veut bien les voir.',
            'Se donner du mal pour les petites choses, c’est parvenir aux grandes, avec le temps.',
            'Le plus grand plaisir dans la vie est de réaliser ce que les autres vous pensent incapable de réaliser.',
            'Certains veulent que ça arrive, d’autres aimeraient que ça arrive, et les autres font que ça arrive.',
            'L’obstination est le chemin de la réussite'
        ];
        var item = citations[Math.floor(Math.random()*citations.length)];
        $('#camel__speechBubble').text(item);
    })();
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
        $('#camel__speechBubble').css('display', 'none');
    }).blur(function () {
        $('#removeCategory').css('display', 'block');
        $('#camel').css('bottom', '60px');
        $('#camel__speechBubble').css('display','block');
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