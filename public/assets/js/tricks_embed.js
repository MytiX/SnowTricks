window.onload = () => {

    var stringToHTML = function (str, count) {
        str = str.replace(/__name__/g, count)
        var parser = new DOMParser();
        var doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };
    
    let btnMoreMedia = document.getElementById('more_media')
    let tricksMedias = document.getElementById('tricks_tempMedias')

    let count = 0
    
    btnMoreMedia.addEventListener('click', (btnEvent) => {

        btnEvent.preventDefault()

        let inputProtype = stringToHTML(tricksMedias.getAttribute('data-prototype'), count)

        let inputSelectMedia = inputProtype.getElementsByClassName('medias_choice')[0]

        tricksMedias.appendChild(inputSelectMedia)

        inputSelectMedia.addEventListener('change', (inputEvent) => {
            let value = inputEvent.target.value
            
            let input = inputProtype.getElementsByClassName(value+'_element')[0]

            tricksMedias.appendChild(input)

            inputSelectMedia.remove()

            let btnDeleteMedia = document.querySelectorAll('.delete_media')

            btnDeleteMedia.forEach(btnDelete => {
                btnDelete.addEventListener('click', () => {
                    btnDelete.parentElement.remove()
                })
            });

        })
        count++
    })
}
