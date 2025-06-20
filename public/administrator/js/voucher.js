document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const kindSelect = document.getElementById('kind');
    const maxDiscountInput = document.getElementById('max_discount');
    const minTotalInput = document.getElementsByName('min_total')[0];

    function toggleFields() {
        const kind = kindSelect.value;
        const type = typeSelect.value;

        // Ẩn/hiện min_total và max_discount
        if (kind === 'shipping') {
            maxDiscountInput.parentElement.style.display = 'none';
        } else {
            minTotalInput.parentElement.style.display = 'block';
            // Chỉ hiện max_discount nếu type là percentage
            if (type === 'percentage') {
                maxDiscountInput.parentElement.style.display = 'block';
            } else {
                maxDiscountInput.parentElement.style.display = 'none';
            }
        }
    }

    function validateValue() {
        const type = typeSelect.value;
        if (type === 'percentage') {
            valueInput.min = 1;
            valueInput.max = 100;
            valueInput.placeholder = 'Nhập từ 1 đến 100';
        } else {
            valueInput.min = 0.1;
            valueInput.removeAttribute('max');
            valueInput.placeholder = 'Nhập số tiền cố định';
        }
    }

    // Bắt sự kiện change
    typeSelect.addEventListener('change', function () {
        toggleFields();
        validateValue();
    });

    kindSelect.addEventListener('change', function () {
        toggleFields();
    });

    // Khi load trang thì gọi trước
    toggleFields();
    validateValue();
});
