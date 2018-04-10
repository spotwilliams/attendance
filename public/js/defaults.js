$.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }
);

// Selectpicker
(function ($) {
    // Por defecto busca el igual
    $.fn.selectpicker.defaults = {
        liveSearchStyle: 'equals',
    };

    // pseudo para equals
    $.expr.pseudos.equals = function (obj, index, meta) {
        var $obj = $(obj);
        var haystack = ($obj.data('tokens') || $obj.text()).toString().toUpperCase();

        return haystack === (meta[3].toUpperCase());
    };

    $.extend(true, $.fn.selectpicker.Constructor.prototype, {
        liveSearchListener: function () {
            var that = this,
                $no_results = $('<li class="no-results"></li>');

            this.$button.on('click.dropdown.data-api', function () {
                that.$menuInner.find('.active').removeClass('active');
                if (!!that.$searchbox.val()) {
                    that.$searchbox.val('');
                    that.$lis.not('.is-hidden').removeClass('hidden');
                    if (!!$no_results.parent().length) $no_results.remove();
                }
                if (!that.multiple) that.$menuInner.find('.selected').addClass('active');
                setTimeout(function () {
                    that.$searchbox.focus();
                }, 10);
            });

            this.$searchbox.on('click.dropdown.data-api focus.dropdown.data-api touchend.dropdown.data-api', function (e) {
                e.stopPropagation();
            });

            this.$searchbox.on('input propertychange', function () {
                that.$lis.not('.is-hidden').removeClass('hidden');
                that.$lis.filter('.active').removeClass('active');
                $no_results.remove();

                if (that.$searchbox.val()) {
                    var $searchBase = that.$lis.not('.is-hidden, .divider, .dropdown-header'),
                        $hideItems;

                    $hideItems = $searchBase.find('a').not(':equals("' + that.$searchbox.val() + '")');

                    console.log($hideItems)
                    if ($hideItems.length === $searchBase.length) {
                        $no_results.html(that.options.noneResultsText.replace('{0}', '"' + htmlEscape(that.$searchbox.val()) + '"'));
                        that.$menuInner.append($no_results);
                        that.$lis.addClass('hidden');
                    } else {
                        $hideItems.parent().addClass('hidden');

                        var $lisVisible = that.$lis.not('.hidden'),
                            $foundDiv;

                        // hide divider if first or last visible, or if followed by another divider
                        $lisVisible.each(function (index) {
                            var $this = $(this);

                            if ($this.hasClass('divider')) {
                                if ($foundDiv === undefined) {
                                    $this.addClass('hidden');
                                } else {
                                    if ($foundDiv) $foundDiv.addClass('hidden');
                                    $foundDiv = $this;
                                }
                            } else if ($this.hasClass('dropdown-header') && $lisVisible.eq(index + 1).data('optgroup') !== $this.data('optgroup')) {
                                $this.addClass('hidden');
                            } else {
                                $foundDiv = null;
                            }
                        });
                        if ($foundDiv) $foundDiv.addClass('hidden');

                        $searchBase.not('.hidden').first().addClass('active');
                    }
                }
            });
        },
    })


})(jQuery);