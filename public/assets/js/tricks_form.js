window.addEventListener("DOMContentLoaded", (event) => {

    const removeChoiceType = () => {
        document.querySelectorAll('.choice-type').forEach(choiceType => {
            choiceType.parentElement.remove()
        })
    }

    const removeAllEmptyInput = () => {
        let allEmptyInput = document.querySelectorAll('.empty-input')
    
        allEmptyInput.forEach(emptyInput => {
            emptyInput.parentElement.remove()
        })
    
        let tricksEmpty = document.getElementById('tricks_medias')
    
        if (tricksEmpty != null) {
            tricksEmpty.parentElement.remove()
        }
    }

    
    var stringToHTML = function (str, count) {
        str = str.replace(/__name__/g, count)
        var parser = new DOMParser();
        var doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };

    const errorEmptyPicture = function (event, parentContainer) {
        event.preventDefault(); 
        parentContainer.innerHTML = '<span class="text-danger">Vous devez avoir au moins une image.</span>';
    };

    const errorNoHeaderPicture = function (event, parentContainer) {
        event.preventDefault(); 

        let labelCheckboxHeader = document.querySelectorAll('.label-picture-header');

        labelCheckboxHeader.forEach(labelCheckbox => {
            labelCheckbox.classList.add('text-danger');
        }) 

        parentContainer.innerHTML = '<span class="text-danger">Vous devez mettre en avant au moins une image.</span>';
    };

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
        let allBtnDelete = document.querySelectorAll('.delete_media');
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
                            if (data.success) {
                                btnDelete.parentElement.parentElement.parentElement.remove();
                                alertMessageSuccess("L'élément a été supprimé avec succès");
                            }
                            else {
                                alertMessageError(data.error);
                            }
                        }).catch(e => {
                            console.log(e);
                        })
                    }                    
            })
        })
    }

    const getAllHeaderCheckbox = function () {
        let allHeaderCheckbox = document.querySelectorAll('.input-picture-header');

        allHeaderCheckbox.forEach(headerCheckbox => {
            headerCheckbox.addEventListener('click', (eventCheckbox) => {
                if (headerCheckbox.checked == true) {
                    allHeaderCheckbox.forEach(checkbox => {
                        checkbox.checked = false;
                    })
                    headerCheckbox.checked = true;
                }
            });
        });
    }

    const checkSubmittedForm = function () {
        let buttonSubmit = document.getElementById('tricks_submit');
        let divFormErrors = document.getElementById('form-errors');

        buttonSubmit.addEventListener('click', (event) => {
            let allHeaderCheckbox = document.querySelectorAll('.input-picture-header');
            
            if (allHeaderCheckbox.length == 0) {
                errorEmptyPicture(event, divFormErrors);
                return;
            }
            
            let valid = false;

            allHeaderCheckbox.forEach(headerCheckbox => {
                if (headerCheckbox.checked == true) {
                    valid = true;
                }
            })

            if (valid == false) {
                errorNoHeaderPicture(event, divFormErrors);                
            }
        })
    }

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
                    pictureInput.getElementsByTagName('input')[0].setAttribute('required', 'required');
                    containerCollection.appendChild(pictureInput)
                }

                if (valueInput == 'embed') {
                    embedInput.getElementsByTagName('input')[0].setAttribute('required', 'required');
                    containerCollection.appendChild(embedInput)
                }

                choiceInput.remove();
                getDeleteItem();
                getAllHeaderCheckbox();
            })

            containerCollection.dataset.index++;
    };

    const alertMessageSuccess = (message) => {
        let alertModal = document.getElementById("alert-js-success");

        alertModal.innerHTML = message;

        alertModal.classList.remove("d-none");

        setTimeout(() => {
            alertModal.classList.add("d-none");
        }, 5000);
    };

    const alertMessageError = (message) => {
        let alertModal = document.getElementById("alert-js-error");

        alertModal.innerHTML = message;

        alertModal.classList.remove("d-none");

        setTimeout(() => {
            alertModal.classList.add("d-none");
        }, 5000);
    };

    document.querySelectorAll('#add_item_media').forEach(btn => {
        btn.addEventListener("click", (event) => {
            addFormToCollection(event)
        })
    });

    checkSubmittedForm();
    getAllHeaderCheckbox();
    removeChoiceType();
    getAllBtnDelete();
    removeAllEmptyInput();
    getDeleteItem();
});


