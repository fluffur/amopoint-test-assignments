const hideNotIncludedInputs = () => {
    const selectedType = document.querySelector('select[name="type_val"]').value;
    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {
        input.parentElement.style.display = input.name.endsWith(selectedType) ? 'block' : 'none';

    });
}

document.addEventListener('DOMContentLoaded', hideNotIncludedInputs);
document.addEventListener('change', hideNotIncludedInputs);
