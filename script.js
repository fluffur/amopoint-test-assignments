const hideNotIncludedInputs = () => {

    const selectedType = document.querySelector('select[name="type_val"]').value;

    const inputs = document.querySelectorAll('input');


    inputs.forEach(input => {
        input.parentElement.style.display = 'none';
    })

    inputs.forEach(input => {
        if (input.name.endsWith(selectedType)) {
            input.parentElement.style.display = 'block';
        }
    })
}

document.addEventListener('DOMContentLoaded', hideNotIncludedInputs);
document.addEventListener('change', hideNotIncludedInputs);
