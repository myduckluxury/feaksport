const provinceSelect = document.getElementById('province');
const districtSelect = document.getElementById('district');

let provinceNameInput = document.createElement('input');
provinceNameInput.type = 'hidden';
provinceNameInput.name = 'province';
document.querySelector('form').appendChild(provinceNameInput);

fetch('https://provinces.open-api.vn/api/?depth=1')
    .then(res => res.json())
    .then(data => {
        data.forEach(province => {
            const option = document.createElement('option');
            option.value = province.code;
            option.textContent = province.name;
            provinceSelect.appendChild(option);
        });
    });

provinceSelect.addEventListener('change', function () {
    const provinceCode = this.value;
    const provinceName = this.options[this.selectedIndex].textContent;

    provinceNameInput.value = provinceName;

    districtSelect.innerHTML = '<option value="">-- Chọn quận/huyện --</option>';

    if (!provinceCode) return;

    fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
        .then(res => res.json())
        .then(data => {
            data.districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.name;
                option.textContent = district.name;
                districtSelect.appendChild(option);
            });
        });
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        form.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        })
        .then(async res => {
            if (res.status === 422) {
                const data = await res.json();
                const errors = data.errors;
        
                for (let key in errors) {
                    const errorElement = form.querySelector(`.error-${key}`);
                    if (errorElement) {
                        errorElement.textContent = errors[key][0];
                    }
                }
            } else if (res.ok) {
                const data = await res.json();
                toastr.success(data.message || 'Cập nhật thành công!');
                
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 1500);
            } else {
                toastr.error('Có lỗi không xác định!');
            }
        })        
    });
});

