
// image review
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="file"][name="images[]"]').forEach(function(input) {
        input.addEventListener('change', function(event) {
            // Lấy id của input, ví dụ: for_images_2 -> 2
            const inputId = input.id;
            const index = inputId.split('_').pop(); // lấy số cuối cùng
            const previewContainer = document.getElementById('preview-' + index);
            previewContainer.innerHTML = ''; // Clear cũ

            const files = event.target.files;

            if (files.length > 3) {
                alert("Chỉ được chọn tối đa 3 ảnh.");
                input.value = ''; // Reset input
                return;
            }

            Array.from(files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.height = '100px';
                    img.style.marginRight = '10px';
                    img.style.borderRadius = '6px';
                    img.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(file);
            });
        });
    });
});
// click imagee
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    modal.style.display = 'flex';
    modalImg.src = src;
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.style.display = 'none';
    document.getElementById('modalImage').src = '';
}
// rating
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.review-rating').forEach(function(ratingDiv) {
        const index = ratingDiv.dataset.index;
        const stars = ratingDiv.querySelectorAll('.star');
        const hiddenInput = document.getElementById('rating-value-' + index);

        stars.forEach(function(star) {
            star.addEventListener('click', function() {
                const value = this.dataset.value;
                hiddenInput.value = value;

                stars.forEach(function(s) {
                    s.style.color = s.dataset.value <= value ? 'gold' :
                        '#ccc';
                });
            });
        });
    });
});
// no reload 
$(document).ready(function () {
    $('#rating').on('change', function () {
        let rating = $(this).val();
        $.ajax({
            url: window.location.href.split('?')[0], 
            type: 'GET',
            data: { rating: rating },
            beforeSend: function () {
                $('#review-list').html('<p>Đang tải đánh giá...</p>');
            },
            success: function (data) {
                let html = $(data).find('#review-list').html();
                $('#review-list').html(html);
            },
            error: function () {
                $('#review-list').html('<p>Không thể tải đánh giá. Vui lòng thử lại sau.</p>');
            }
        });
    });
})

//--------------------------------------------------
$(document).ready(function() {
    // Khi nhấn vào tab, ẩn màn hình loading
    $('a[data-bs-toggle="pill"]').on('click', function() {
        // Kiểm tra xem tab có đang chuyển tới "Đánh giá" không
        if ($(this).attr('href') == '#reviews') {
            // Nếu chuyển tới tab đánh giá, không cần loading
            $("#loading-screen").addClass("hide-loading");
        } else {
            // Nếu không phải tab đánh giá, bạn có thể thêm các xử lý khác ở đây nếu cần
            $("#loading-screen").addClass("hide-loading");
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".review-rating .star");
    const ratingInput = document.getElementById("rating-value");

    stars.forEach(star => {
        star.addEventListener("click", function () {
            const rating = this.getAttribute("data-value");
            ratingInput.value = rating;

            // Xóa class "selected" khỏi tất cả sao
            stars.forEach(s => s.classList.remove("selected"));

            // Thêm class "selected" cho các sao đã chọn
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add("selected");
            }
        });

        star.addEventListener("mouseover", function () {
            const rating = this.getAttribute("data-value");

            // Xóa hover cũ
            stars.forEach(s => s.classList.remove("hover"));

            // Thêm hover cho sao tương ứng
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add("hover");
            }
        });

        star.addEventListener("mouseleave", function () {
            stars.forEach(s => s.classList.remove("hover"));
        });
    });
});

// quantity product
document.addEventListener("DOMContentLoaded", function () {
    let selectedColor = null;
    let selectedSize = null;

    document.querySelectorAll(".color-option").forEach(color => {
        color.addEventListener("click", function () {
            selectedColor = this.dataset.color;
            console.log("Selected Color:", selectedColor); 
            updateStockStatus();
        });
    });

    document.querySelectorAll(".size-option").forEach(size => {
        size.addEventListener("click", function () {
            selectedSize = this.dataset.size;
            console.log("Selected Size:", selectedSize); 
            updateStockStatus();
        });
    });
    function updateStockStatus() {
        if (!selectedColor || !selectedSize) {
            document.getElementById("stock-status").innerText = "Chọn màu và size";
            return;
        }
    
        console.log("Checking stock for:", selectedColor, selectedSize); 
    
        let variant = [...document.querySelectorAll(".quantity-option")].find(q =>
            q.dataset.color === selectedColor && q.dataset.size === selectedSize
        );
    
        if (variant) {
            let quantity = parseInt(variant.dataset.quantity);
            console.log("Found quantity:", quantity); 
    
            if (quantity === 0) {
                document.getElementById("stock-status").innerText = "Hết hàng";
            } else if (quantity < 5) {
                document.getElementById("stock-status").innerText = `Sắp hết hàng (${quantity})`;
            } else {
                document.getElementById("stock-status").innerText = `Còn hàng(${quantity})`;
            }
        } else {
            console.log("Variant not found!");
            document.getElementById("stock-status").innerText = "Hết hàng";
        }
    }
    
});

// --------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    let selectedColor = null;
    let selectedSize = null;
    const priceDisplay = document.querySelector('.price');

    const productVariants = [];
    document.querySelectorAll(".color-option").forEach(colorEl => {
        const color = colorEl.getAttribute("data-color");
        const sizes = colorEl.getAttribute("data-size").split(",");

        sizes.forEach(size => {
            const variant = {
                color: color,
                size: size.trim(),
                price: parseInt(colorEl.getAttribute("data-price"))
            };
            productVariants.push(variant);
        });
    });

    let productDiscount = parseFloat(document.querySelector("#product-discount").value || 0);
    console.log("Giảm giá mới:", productDiscount);

    function updatePrice() {
        if (selectedColor && selectedSize) {
            const variant = productVariants.find(v => v.color === selectedColor && v.size === selectedSize);
            if (variant) {
                let finalPrice = variant.price * (1 - productDiscount / 100);
                priceDisplay.textContent = new Intl.NumberFormat().format(finalPrice) + " VND";
            }
        }
    }

    function updateAvailableOptions() {
        document.querySelectorAll(".size-option").forEach(sizeEl => {
            const size = sizeEl.getAttribute("data-size");
            const isAvailable = productVariants.some(v => v.color === selectedColor && v.size === size);

            sizeEl.classList.toggle("disabled", selectedColor && !isAvailable);
        });

        document.querySelectorAll(".color-option").forEach(colorEl => {
            const color = colorEl.getAttribute("data-color");
            const isAvailable = productVariants.some(v => v.size === selectedSize && v.color === color);

            colorEl.classList.toggle("disabled", selectedSize && !isAvailable);
        });
    }

    document.querySelectorAll(".color-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedColor = this.getAttribute("data-color");

            document.querySelectorAll(".color-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            document.querySelector("#selected-color").value = selectedColor;

            updateAvailableOptions();
            updatePrice();
        });
    });

    document.querySelectorAll(".size-option").forEach(el => {
        el.addEventListener("click", function () {
            selectedSize = this.getAttribute("data-size");

            document.querySelectorAll(".size-option").forEach(opt => opt.classList.remove("active"));
            this.classList.add("active");

            document.querySelector("#selected-size").value = selectedSize;

            updateAvailableOptions();
            updatePrice();
        });
    });
});

// Add to cart
$(document).ready(function () {
    $('#add-to-cart').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        window.location.href = cartIndexUrl;
                    }, 2000);
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });
});

// Add to wishlist
$(document).ready(function () {
    $('#add-wishlist').submit(function (e) {
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
                if (xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("Vui lòng đăng nhập.");
                }
            }
        });
    });
});


















