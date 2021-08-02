import '../../styles/skill/skill-sort.css';
import {Sortable} from '@shopify/draggable';
import {postData} from "../http-client";

/**
 * @returns {boolean|*}
 * @constructor
 */
export default function SortableList() {

    const containerSelector = '.skill-sort-container';
    const containers = document.querySelectorAll(containerSelector);

    if (containers.length === 0) {
        return false;
    }

    const sortable = new Sortable(containers, {
        draggable: 'li.skill.draggable',
        mirror: {
            appendTo: containerSelector,
            constrainDimensions: true,
        },
    });

    sortable.on('sortable:sort', (evt) => {
        let sourceContainer = evt.dragEvent.sourceContainer;
        let overContainer = evt.dragEvent.overContainer;

        if (overContainer !== sourceContainer) {
            evt.cancel();

            const errorMessage = document.querySelector('.error-message');
            errorMessage.classList.remove('hidden');
            window.setTimeout(function () {
                errorMessage.classList.add('hidden');
            }, 5000)
        }
    });

    const saveButtonSelector = '.btn-primary.action-save';
    const saveButton = document.querySelector(saveButtonSelector);

    saveButton.addEventListener('click', function () {
        let resultList = [];

        containers.forEach(function (container) {
            let sortedList = container.querySelectorAll('.skill.draggable');

            sortedList.forEach(function (element, index) {
                let id = element.getAttribute('data-id');
                resultList.push({id: id, index: index});
            });
        });

        postData(this.getAttribute('data-action'), resultList)
            .then(data => {
                let message = 'Сохранение прошло успешно!';

                if (data.status !== 'success') {
                    message = 'Ошибка при сохранении: \n' + data.message;
                }

                alert(message)
            });
    });

    return sortable;
}

SortableList();