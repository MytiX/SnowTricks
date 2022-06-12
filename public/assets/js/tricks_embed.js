window.addEventListener("DOMContentLoaded", (event) => {
    const removeChoiceType = () => {
        document.querySelectorAll('.choice-type').forEach(choiceType => {
            choiceType.parentElement.remove()
        })
    }
    removeChoiceType()
    
    var stringToHTML = function (str, count) {
        str = str.replace(/__name__/g, count)
        var parser = new DOMParser();
        var doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };


    const addFormToCollection = (event) => {
        event.preventDefault()
        containerCollection = document.getElementById('container-' + event.currentTarget.dataset.collectionHolderClass);

            inputCollection = containerCollection
                .dataset
                .prototype
                .replace(
                    /__name__/g,
                    containerCollection.dataset.index
            );

            prototypeInput = stringToHTML(inputCollection)

            let choiceInput = prototypeInput.getElementsByClassName('choice-type')[0].parentElement
            let pictureInput = prototypeInput.getElementsByClassName('picture-type')[0].parentElement
            let embedInput = prototypeInput.getElementsByClassName('embed-type')[0].parentElement

            containerCollection.appendChild(choiceInput);

            choiceInput.addEventListener('change', (inputEvent) => {
                let valueInput = inputEvent.target.value

                if (valueInput == 'picture') {
                    containerCollection.appendChild(pictureInput)
                }

                if (valueInput == 'embed') {
                    containerCollection.appendChild(embedInput)
                }

                choiceInput.remove()
            })

            containerCollection.dataset.index++;
    };

    document.querySelectorAll('#add_item_media').forEach(btn => {
        btn.addEventListener("click", (event) => {
            addFormToCollection(event)
        })
    });
});


