(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // Progress Bar
    $('.pg-bar').waypoint(function () {
        $('.progress .progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, { offset: '80%' });


    // Calender
    $('#calender').datetimepicker({
        inline: true,
        format: 'L'
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        dots: true,
        loop: true,
        nav: false
    });


    // Salse & Revenue Chart
    var ctx3 = $("#line-chart").get(0).getContext("2d");
    var myChart3 = new Chart(ctx3, {
        type: "bar",
        data: {
            labels: labelsRevenue,
            datasets: [{
                label: "Doanh thu",
                data: dataRevenue,
                backgroundColor: "rgba(0, 157, 255, 0.5)",
                fill: false
            }
            ]
        },
        options: {
            responsive: true
        }
    });

    // var ctx2 = $("#salse-revenue").get(0).getContext("2d");
    // var myChart2 = new Chart(ctx2, {
    //     type: "line",
    //     data: {
    //         labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
    //         datasets: [{
    //                 label: "Lượt bán",
    //                 data: [15, 30, 55, 45, 70, 65, 85],
    //                 backgroundColor: "rgba(0, 156, 255, .5)",
    //                 fill: true
    //             },
    //             {
    //                 label: "Lượt xem",
    //                 data: [99, 135, 170, 130, 190, 180, 270],
    //                 backgroundColor: "rgba(0, 156, 255, .3)",
    //                 fill: true
    //             }
    //         ]
    //         },
    //     options: {
    //         responsive: true
    //     }
    // });


    var ctx6 = $("#doughnut-chart").get(0).getContext("2d");
    var myChart6 = new Chart(ctx6, {
        type: "doughnut",
        data: {
            labels: brandLabels,
            datasets: [{
                backgroundColor: [
                    "rgba(0, 156, 255, .7)",
                    "rgba(0, 186, 200, 0.6)",
                    "rgba(255, 187, 69, 0.5)",
                    "rgba(191, 175, 0, 0.4)",
                    "rgba(0, 150, 32, 0.3)",
                ],
                data: brandSales
            }]
        },
        options: {
            responsive: true
        }
    });

})(jQuery);

