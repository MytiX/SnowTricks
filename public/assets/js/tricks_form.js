window.addEventListener("DOMContentLoaded", (event) => {

    const removeChoiceType = () => {
        document.querySelectorAll('.choice-type').forEach(choiceType => {
            choiceType.parentElement.remove()
        })
    }

    let allEmptyInput = document.querySelectorAll('.empty-input')

    allEmptyInput.forEach(emptyInput => {
        emptyInput.parentElement.remove()
    })

    let tricksEmpty = document.getElementById('tricks_medias')

    if (tricksEmpty != null) {
        tricksEmpty.parentElement.remove()
    }
    
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
                    embedInput.classList.add('d-none')
                    containerCollection.appendChild(embedInput)
                }

                if (valueInput == 'embed') {
                    containerCollection.appendChild(embedInput)
                    pictureInput.classList.add('d-none')
                    containerCollection.appendChild(pictureInput)
                }

                containerCollection.appendChild(embedInput)
                containerCollection.appendChild(pictureInput)
                choiceInput.remove()
                getDeleteItem()
            })

            containerCollection.dataset.index++;
    };

    document.querySelectorAll('#add_item_media').forEach(btn => {
        btn.addEventListener("click", (event) => {
            addFormToCollection(event)
        })
    });

    const getDeleteItem = function () {
        let allBtnDeleteItem = document.querySelectorAll('.delete_item')
        allBtnDeleteItem.forEach(btnDeleteItem => {
            btnDeleteItem.addEventListener('click', (event) => {
                event.preventDefault()
                btnDeleteItem.parentElement.parentElement.parentElement.remove()
            })
        })
    }
    
    const getAllBtnDelete = function () {
        let allBtnDelete = document.querySelectorAll('.delete_media')
        allBtnDelete.forEach(btnDelete => {
            btnDelete.addEventListener('click', (event) => {
                event.preventDefault()
                    if (confirm("Voulez-vous supprimer le média ?")) {
                        fetch(btnDelete.getAttribute("href"), {
                            method: "DELETE",
                            headers: {
                                'X-Requested-With': "XMLHttpRequest",
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({'_token': btnDelete.getAttribute('data-token')})
                        }).then(
                            response => response.json()
                        ).then(data => {
                            if (data.success)
                                btnDelete.parentElement.parentElement.parentElement.remove()
                            else
                                alert(data.error)
                        }).catch(e => alert(e))
                    }                    
            })
        })
    }

    removeChoiceType()
    getAllBtnDelete()
});


