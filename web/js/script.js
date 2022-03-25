/*
 * Функция работы модального окна
 */
$(function () {
    $(document).on('click', '.showModalButton', function (e) {
        e.preventDefault();
        var container = $('#modalContent');
        var header = $('#modalHeader');
        /* очищаем контейнер */
        container.html('Пожалуйста, подождите. Идет загрузка...');
        /* выводим модальное окно, загружаем данные */
        $('#modal').find(header).text($(this).attr('title'));
        $('#modal').modal('show').find(container).load($(this).attr('value'));
        $("#modal").on('hidden.bs.modal', function () {
            $('#modalContent').html('');
        });
    });
});

/*
 * Функция изменения класса при наведении на блок
 */
$(function () {
    $('.minnesota-connect').hover(function (e) {
        e.preventDefault();
        $(this).removeClass('rosatom-frame-milwaukee');
        $(this).addClass('rosatom-frame-minnesota');
    }, function (e) {
        e.preventDefault();
        $(this).removeClass('rosatom-frame-minnesota');
        $(this).addClass('rosatom-frame-milwaukee');
    });
});

/*
 * Функция работы навигационного меню гамбургер
 */
$(function () {
    $('.header__burger').click(function (e) {
        e.preventDefault();
        $('.header__burger, .header__menu').toggleClass('active');
        $('body').toggleClass('lock');
    });
});

/*
 * Функция определения высоты контентной части для дальнейшего присвоения размера вертикальной линии
 */
$(function () {
    var size_content_window = $('.content').outerHeight();
    $('.vertical').css('height', size_content_window);
});

/*
 * Функция определения высоты контентной части для дальнейшего присвоения размера вертикальной линии при изменении размера
 * окна браузера
 */
$(function () {
    $(window).on('resize', function (e) {
        e.preventDefault();
        var size_content_window = $('.content').outerHeight();
        $('.vertical').css('height', size_content_window);
    });
});

/*
 * Функция при изменении размера экрана выполняет:
 * 1. сдвиг вертикальной линии влево;
 * 2. изменяет размер баннера;
 * 3. поднимает наименование баннера вверх.
 */
$(function () {
    $(window).on('resize', function (e) {
        e.preventDefault();
        var size_browser = $(window).width();
        if (size_browser <= 585) {
            $('.vertical').css('left', '90%');
            $('.banner__image').css('height', '248px');
            $('.banner__index_text').css('margin', '0 0 155px');
        } else {
            $('.vertical').css('left', '96%');
            $('.banner__image').css('height', '360px');
            $('.banner__index_text').css('margin', '0 0 55px');
        }
    });
});

/*
 * Функция при загрузки страницы выполняет:
 * 1. сдвиг вертикальной линии влево;
 * 2. изменяет размер баннера;
 * 3. поднимает наименование баннера вверх.
 */
$(function () {
    var size_browser = $(window).width();
    if (size_browser <= 585) {
        $('.vertical').css('left', '90%');
        $('.banner__image').css('height', '248px');
        $('.banner__index_text').css('margin', '0 0 155px');
    } else {
        $('.vertical').css('left', '96%');
        $('.banner__image').css('height', '360px');
        $('.banner__index_text').css('margin', '0 0 55px');
    }
});

/*
 * Активируем кнопку с помощью добавления класса при скроллинге страницы
 */
$(function () {
    $(window).on('scroll', function (e) {
        e.preventDefault();
        $('.btn-milwaukee').toggleClass('active', window.scrollY>50);
    });
});

/*
 * Функция анимации скроллинга
 */
$(function () {
    $('.btn-milwaukee').click(function (e) {
        e.preventDefault();
        $('body, html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
});

/*
 * Функция определения баннера по URL страницы
 */
// $(function () {
//     var url_window = window.location.href;
//     var first = (url_window.lastIndexOf('/')) + 1;
//     var second = url_window.length;
//     var total = url_window.substring(first, second);
//     switch (total) {
//         case 'contact':
//             $('.banner__image').attr('src', '/image/banner/administration.jpg');
//             $('.banner__index_text').text('Администрирование');
//             break;
//         default:
//             $('.banner__image').attr('src', '/image/banner/home.jpg');
//             $('.banner__index_text').text('Личный кабинет заявителя');
//             break;
//     }
// });

/*
 * Функция определения баннера по названию контроллера (название выводится в label)
 */
$(function () {
    var controller_name = $('.rogue');
    switch (controller_name[0]['innerText']) {
        case 'site':
            $('.banner__image').attr('src', '/image/banner/home.jpg');
            $('.banner__index_text').text('Личный кабинет заявителя');
            break;
        case 'administration':
            $('.banner__image').attr('src', '/image/banner/administration.jpg');
            $('.banner__index_text').text('Администрирование');
            break;
        case 'electricity':
            $('.banner__image').attr('src', '/image/banner/electricity.jpg');
            $('.banner__index_text').text('Электросети');
            break;
        default:
            $('.banner__image').attr('src', '/image/banner/home.jpg');
            $('.banner__index_text').text('Личный кабинет заявителя');
            break;
    }
});

/*
 * Функция поиска документа
 */
$(function () {
    $(document).on('change', '#minnesotaSearch', function (e) {
        e.preventDefault();
        var text = $("#minnesotaSearch").val().toLowerCase();
        $('.document-search').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(text) > -1)
        });
    });
});

/*
 * Функция работы выпадающего списка в справке по электросетям (при выборе из списка появляется подробная информация по
 * подключению)
 */
$(function () {
    $(document).on('change', '.type-connect-help', function (e) {
        e.preventDefault();
        var connect = $(".type-connect-help").val();
        switch (connect) {
            case '0':
                $('#temporary-connection').css('display', 'block');
                $('#permanent-connection-15').css('display', 'none');
                $('#permanent-connection-150').css('display', 'none');
                $('#permanent-connection-670').css('display', 'none');
                $('#permanent-connection-max').css('display', 'none');
                $('#power-redistribution').css('display', 'none');
                break;
            case '1':
                $('#temporary-connection').css('display', 'none');
                $('#permanent-connection-15').css('display', 'block');
                $('#permanent-connection-150').css('display', 'none');
                $('#permanent-connection-670').css('display', 'none');
                $('#permanent-connection-max').css('display', 'none');
                $('#power-redistribution').css('display', 'none');
                break;
            case '2':
                $('#temporary-connection').css('display', 'none');
                $('#permanent-connection-15').css('display', 'none');
                $('#permanent-connection-150').css('display', 'block');
                $('#permanent-connection-670').css('display', 'none');
                $('#permanent-connection-max').css('display', 'none');
                $('#power-redistribution').css('display', 'none');
                break;
            case '3':
                $('#temporary-connection').css('display', 'none');
                $('#permanent-connection-15').css('display', 'none');
                $('#permanent-connection-150').css('display', 'none');
                $('#permanent-connection-670').css('display', 'block');
                $('#permanent-connection-max').css('display', 'none');
                $('#power-redistribution').css('display', 'none');
                break;
            case '4':
                $('#temporary-connection').css('display', 'none');
                $('#permanent-connection-15').css('display', 'none');
                $('#permanent-connection-150').css('display', 'none');
                $('#permanent-connection-670').css('display', 'none');
                $('#permanent-connection-max').css('display', 'block');
                $('#power-redistribution').css('display', 'none');
                break;
            case '5':
                $('#temporary-connection').css('display', 'none');
                $('#permanent-connection-15').css('display', 'none');
                $('#permanent-connection-150').css('display', 'none');
                $('#permanent-connection-670').css('display', 'none');
                $('#permanent-connection-max').css('display', 'none');
                $('#power-redistribution').css('display', 'block');
                break;
            default:
                $('#temporary-connection').css('display', 'none');
                $('#permanent-connection-15').css('display', 'none');
                $('#permanent-connection-150').css('display', 'none');
                $('#permanent-connection-670').css('display', 'none');
                $('#permanent-connection-max').css('display', 'none');
                $('#power-redistribution').css('display', 'none');
                break;
        }
    });
});