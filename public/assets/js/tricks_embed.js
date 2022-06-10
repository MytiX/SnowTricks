window.onload = () => {

    var stringToHTML = function (str, count) {
        str = str.replace(/__name__/g, count)
        var parser = new DOMParser();
        var doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };
    
    let btnMoreMedia = document.getElementById('more_media')
    let tricksMedias = document.getElementById('tricks_medias')

    let count = 0
    
    btnMoreMedia.addEventListener('click', (btnEvent) => {

        btnEvent.preventDefault()

        let inputPrototype = stringToHTML(tricksMedias.getAttribute('data-prototype'), count)
        
        // let inputSelectMedia = inputPrototype.getElementById('medias_choice')
        
        console.log(inputPrototype);

        // tricksMedias.appendChild(inputSelectMedia)

        // inputSelectMedia.addEventListener('change', (inputEvent) => {
        //     let value = inputEvent.target.value
            
        //     let input = inputPrototype.getElementsByClassName(value+'_element')[0]

        //     tricksMedias.appendChild(input)

        //     inputSelectMedia.remove()

        //     let btnDeleteMedia = document.querySelectorAll('.delete_media')

        //     btnDeleteMedia.forEach(btnDelete => {
        //         btnDelete.addEventListener('click', () => {
        //             btnDelete.parentElement.remove()
        //         })
        //     });

        // })
        count++
    })
}
