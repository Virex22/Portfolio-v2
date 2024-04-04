import "../../styles/pages/projects.scss";
import TomSelect from 'tom-select';

/* Select part */
let elems  = document.querySelectorAll('.select-box input[type="checkbox"].options-view-button');

elems.forEach((elem) => {
    //on checked we remove checked of other checkboxes
    elem.addEventListener('change', function() {
        if (this.checked) {
            elems.forEach((el) => {
                if (el !== this) {
                    el.checked = false;
                }
            });
        }
    });
});

/* Selectize part */
const select = document.querySelectorAll('.tom-select');
select.forEach((elem) => {
    new TomSelect(elem, {
        mode: 'single',
    });
});