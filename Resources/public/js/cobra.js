/**
 * Created by jmeuriss on 16/12/13.
 */
(function () {
    'use strict';

    var collectionId;
    var collectionElement;
    var route;

    $('.cobra-unregister-button').click(function () {
        $('#unregister-collection-validation-box').modal('show');
        collectionId = $(this).attr('btn-cobra-collection-id');
        collectionElement = $(this).parent().parent();
    });

    $('#unregister-confirm-ok').click(function () {
        $.ajax({
            url: Routing.generate('unamur_cobra_unregister_collection', {'cobraCollectionId': collectionId}),
            type: 'DELETE',
            success: function () {
                $('#unregister-collection-validation-box').modal('hide');
                collectionElement.remove();
            }
        });
    });

    $('.cobra-collection-change-visibility').click(function () {

        collectionId = $(this).attr('btn-cobra-collection-id');
        var container = $(this).parent().parent();
        var icon = $(this).children(':first');
        var setVisible = $(icon).hasClass('icon-eye-close') ? true : false;

        $.ajax({
            url: Routing.generate('unamur_cobra_change_collection_visibility', {'cobraCollectionId': collectionId}),
            type: 'POST',
            success: function () {
               if(setVisible)
               {
                   $(icon).removeClass('icon-eye-close').addClass('icon-eye-open');

                   $(container).removeClass('panel-danger').addClass('panel-primary');
               }
               else
               {
                   $(icon).removeClass('icon-eye-open').addClass('icon-eye-close');

                   $(container).removeClass('panel-primary').addClass('panel-danger');
               }
            },
            error: function () {
                alert('chiotte');
            }
        });


    });

    $('.cobra-collection-move-up').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        var currentElement = $(this).parent().parent();
        collectionId = $(this).attr('btn-cobra-collection-id');

        $.ajax({
            url: Routing.generate('unamur_cobra_move_collection', {'cobraCollectionId': collectionId, 'direction' : 'up'}),
            type: 'POST',
            success: function (data) {
                var previousSibling = currentElement.prev();
                previousSibling.before(currentElement);
                $('.cobra-collection-move-up').removeClass('disabled');
                $('.cobra-collection-move-down').removeClass('disabled');
                $('.cobra-collection-move-up').first().addClass('disabled');
                $('.cobra-collection-move-down').last().addClass('disabled');
            },
            error: function (data) {
                alert(data);
            }
        });


    });

    $('.cobra-collection-move-down').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        var currentElement = $(this).parent().parent();
        collectionId = $(this).attr('btn-cobra-collection-id');

        $.ajax({
            url: Routing.generate('unamur_cobra_move_collection', {'cobraCollectionId': collectionId, 'direction' : 'down'}),
            type: 'POST',
            success: function (data) {

                var nextSibling = currentElement.next();
                nextSibling.after(currentElement);
                $('.cobra-collection-move-up').removeClass('disabled');
                $('.cobra-collection-move-down').removeClass('disabled');
                $('.cobra-collection-move-up').first().addClass('disabled');
                $('.cobra-collection-move-down').last().addClass('disabled');
            },
            error: function (data) {
                alert(data);
            }
        });


    });

    $('.lemma').click(function (e){
       alert("I was clicked " + $(this).attr('name'));
    });

})();