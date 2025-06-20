document.addEventListener("DOMContentLoaded", function () {
    function fetchProducts(color, size) {
        fetch(`/get-similar-products?color=${color}&size=${size}`)
            .then(response => response.json())
            .then(data => {
                let productContainer = document.getElementById("similar-products");
                productContainer.innerHTML = "";

                data.forEach(product => {
                    let productHTML = `
                        <div class="product-item">
                            <img src="${product.image}" alt="${product.name}">
                            <h5>${product.name}</h5>
                            <p>${product.price} VND</p>
                        </div>
                    `;
                    productContainer.innerHTML += productHTML;
                });
            })
            .catch(error => console.error("Lỗi khi tải sản phẩm:", error));
    }

    document.querySelectorAll(".color-option").forEach(option => {
        option.addEventListener("click", function () {
            let selectedColor = this.getAttribute("data-color");
            let selectedSize = document.querySelector(".size-option.active")?.getAttribute("data-size") || "";

            document.querySelectorAll(".color-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            fetchProducts(selectedColor, selectedSize);
        });
    });

    document.querySelectorAll(".size-option").forEach(option => {
        option.addEventListener("click", function () {
            let selectedSize = this.getAttribute("data-size");
            let selectedColor = document.querySelector(".color-option.active")?.getAttribute("data-color") || "";

            document.querySelectorAll(".size-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            fetchProducts(selectedColor, selectedSize);
        });
    });
    $(document).ready(function () {
        
        let minPrice = 0;
        let maxPrice = 10000000; 
    
        $("#price-range").slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [minPrice, maxPrice], 
            step: 10000, 
            slide: function (event, ui) {
                $("#amount").val(ui.values[0].toLocaleString() + "đ - " + ui.values[1].toLocaleString() + "đ");
            }
        });
    
        $("#amount").val($("#price-range").slider("values", 0).toLocaleString() + "đ - " +
            $("#price-range").slider("values", 1).toLocaleString() + "đ");
    

        $("#filter-price").click(function () {
            let min = $("#price-range").slider("values", 0);
            let max = $("#price-range").slider("values", 1);
    
            let url = new URL(window.location.href);
            url.searchParams.set('min_price', min);
            url.searchParams.set('max_price', max);
            window.location.href = url.toString();
        });
    });
});



// Add to wishlist
$(document).ready(function () {
    $('.add-wishlist-form').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON?.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("Vui lòng đăng nhập.");
                }
            }
        });
    });
});


