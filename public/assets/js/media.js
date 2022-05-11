window.onload = () => {
    let links_delete = document.querySelectorAll("[data-delete]")
    let links_header = document.querySelectorAll("[data-header]")
    
    links_delete.forEach(link_delete => {
        link_delete.addEventListener("click", (e) => {
            e.preventDefault()
    
            if (confirm("Voulez-vous supprimer cette image ?")) {
                fetch(link_delete.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        'X-Requested-With': "XMLHttpRequest",
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({'_token': link_delete.getAttribute('data-token')})
                }).then(
                    response => response.json()
                ).then(data => {
                    if (data.success)
                        link_delete.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    })

    links_header.forEach(link_header => {
        link_header.addEventListener("click", (e) => {

            e.preventDefault()

            fetch(link_header.getAttribute("href"), {
                method: "PUT",
                headers: {
                    'X-Requested-With': "XMLHttpRequest",
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({'_token': link_header.getAttribute('data-token')})
            }).then(
                response => response.json()
            ).then(data => {
                if (data.success) {
                    if (data.old_media_id != link_header.getAttribute('data-media')) {
                        link_header.firstElementChild.classList.remove('bi-heart')
                        link_header.firstElementChild.classList.add('bi-heart-fill')
    
                        let medias = document.querySelectorAll("[data-media]")
    
                        for (media of medias) {
                            if (data.old_media_id == media.getAttribute('data-media')) {
                                media.firstElementChild.classList.remove('bi-heart-fill')
                                media.firstElementChild.classList.add('bi-heart')
                            }
                        }
                    }
                } else {
                    alert(data.error)
                }
            }).catch(e => alert(e))
        })
    })
}