(function ($) {
    function changeVisibilityOfList() {
        $('.list-element-toggler').on('click', function () {
            const liElement = $(this).parent();
            const children = $('.list-element').filter('[data-parent-id="' + liElement.data('id') + '"]');
            if (liElement.attr('data-visibility') === 'shown') {
                $(this).text('Развернуть');
                liElement.attr('data-visibility', 'hidden');
                loopElements(children, 'hide');
            } else {
                $(this).text('Свернуть');
                liElement.attr('data-visibility', 'shown');
                loopElements(children, 'show');
            }
        });
    }

    function loopElements(elements, hideOrShow) {
        if (!elements.length) return;

        elements.each(function () {
            const children = $('.list-element').filter('[data-parent-id="' + $(this).data('id') + '"]');
            if (hideOrShow === 'hide') {
                $(this).attr('data-visibility', 'hidden');
                $(this).css('display', 'none');
                loopElements(children, 'hide', $(this).data('id'));
            } else {
                $(this).attr('data-visibility', 'shown');
                $(this).css('display', '');
                loopElements(children, 'show', $(this).data('id'));
            }
        });
    }

    function deleteDataItem() {
        $('.delete-button').on('click', function () {
            const id = $(this).data('id');
            $.ajax({
                url: (origin ?? location.origin) + '/site/delete?id=' + id,
                type: 'DELETE',
            }).done(function () {
                location.reload();
            }).fail(function () {
                alert('Не удалось удалить запись!')
            });
        });
    }

    function updateDataItem() {
        $('.input-value').on('change', function () {
            const id = $(this).data('id');
            $.ajax({
                url: (origin ?? location.origin) + '/site/update?id=' + id,
                type: 'PUT',
                data: {
                    value: $(this).val(),
                },
            }).done(function () {
                alert('Запись обновлена успешно!');
            }).fail(function () {
                alert('Не удалось обновить запись!');
            });
        });
    }

    $(document).ready(function () {
        changeVisibilityOfList();
        deleteDataItem();
        updateDataItem();
    });
})(jQuery);
