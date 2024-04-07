import "../../styles/pages/project/projects.scss";
import TomSelect from 'tom-select';

/* Selectize part */
const select = document.querySelectorAll('.tom-select');
select.forEach((elem) => {
    new TomSelect(elem, {
        mode: 'single',
        controlInput: null
    });
});

/* Handle facet filter */
const filters = [
    document.querySelector('.select-box.technology'),
    document.querySelector('.select-box.soft-skill')
];
const sortSelect = document.querySelector('.select-box.sort');

//handle all filters change but not the sort
const handleFilterChange = () => {
    const filtersValues = Array.from(filters).map((filter) => {
        return filter.querySelector('.item').getAttribute('data-value');
    }).filter((value) => {
        return value !== 'all';
    });

    const projectCards = document.querySelectorAll('.project-card');
    projectCards.forEach((card) => {
        const projectSkills = atob(card.getAttribute('data-skill')).split(',');

        const isMatch = filtersValues.every((filter) => {
            return projectSkills.includes(filter);
        });

        if (isMatch) {
            setTimeout(() => {
                card.style = null;
                //timeout to let the transition effect work (not NaN scale)
                setTimeout(() => {
                    card.classList.remove('hidden');
                }, 10);
            }, 90);
        } else {
            card.classList.add('hidden');
            setTimeout(() => {
                card.style.display = 'none';
            }, 90);
        }
    });
};

//handle sort change
const getDuration = (startDate, endDate) => {
    const millisecondsPerDay = 1000 * 60 * 60 * 24;
    const durationInMilliseconds = endDate - startDate;
    return Math.round(durationInMilliseconds / millisecondsPerDay);
}
const handleSortChange = () => {
    const sortValue = sortSelect.querySelector('.item').getAttribute('data-value');
    const projectCards = document.querySelectorAll('.project-card');
    let sortedCards = Array.from(projectCards);


    if (sortValue === 'pertinence') {
        projectCards.forEach((card) => {
            card.style.order = null;
        });
    } else {
        sortedCards.sort((a, b) => {
            const [aBeginDate, aEndDate] = a.getAttribute('data-date').split(',').map(dateString => new Date(dateString)); // Date de début et de fin de projet de la carte a
            const [bBeginDate, bEndDate] = b.getAttribute('data-date').split(',').map(dateString => new Date(dateString)); // Date de début et de fin de projet de la carte b

            if (sortValue === 'bdate-desc') {
                return bBeginDate - aBeginDate; // Tri par date de début décroissante
            } else if (sortValue === 'bdate-asc') {
                return aBeginDate - bBeginDate; // Tri par date de début croissante
            } else if (sortValue === 'edate-desc') {
                return bEndDate - aEndDate; // Tri par date de fin décroissante
            } else if (sortValue === 'edate-asc') {
                return aEndDate - bEndDate; // Tri par date de fin croissante
            } else if (sortValue === 'duration-desc') {
                return getDuration(bBeginDate, bEndDate) - getDuration(aBeginDate, aEndDate); // Tri par durée décroissante
            } else if (sortValue === 'duration-asc') {
                return getDuration(aBeginDate, aEndDate) - getDuration(bBeginDate, bEndDate); // Tri par durée croissante
            }
        });
    }

    sortedCards.forEach((card, index) => {
        card.style.order = index.toString();
    });
}

//handle all filters change
filters.forEach((filter) => {
    if (filter)
        filter.addEventListener('change', handleFilterChange);
});
sortSelect.addEventListener('change', handleSortChange);

