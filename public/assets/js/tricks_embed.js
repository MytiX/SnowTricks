// let btnMoreEmbed = document.getElementById('more_embed')

// let prototype = document.getElementById('tricks_embeds')

// let inputProtype = prototype.getAttribute('data-prototype')

// let parentProtype = prototype.parentElement

// inputProtype = inputProtype.replace('__name__label__', 'Youtube')

// btnMoreEmbed.addEventListener('click', (e) => {
    
//     let test = document.querySelectorAll('[data_embed]')

//     let tempInputPrototype = inputProtype.replace(/__name__/g, test.length)

//     parentProtype.innerHTML += tempInputPrototype 
// })

let btnMoreMedia = document.getElementById('more_media')
let btnDeleteMedia = document.querySelectorAll('.delete_media')
let prototype = document.getElementById('tricks_medias')
let inputProtype = prototype.getAttribute('data-prototype')
// let embed = inputProtype.getElementsByClassname('embed_element')
// let picture = inputProtype.getElementsByClassname('picture_element')
let parentProtype = prototype.parentElement

btnMoreMedia.addEventListener('click', (e) => {
    e.preventDefault()

    parentProtype.innerHTML += inputProtype 
    updateBtnDelete()
})


function updateBtnDelete()
{
    btnDeleteMedia = document.querySelectorAll('.delete_media')
    btnDeleteMedia.forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault()
            element.parentElement.remove()
        })
    })
}