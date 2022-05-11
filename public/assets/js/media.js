window.onload = () => {
    let links = document.querySelectorAll("[data-delete]")
    
    for (link of links) {

        link.addEventListener("click", (e) => {

            e.preventDefault()

            if (confirm("Voulez-vous supprimer cette image ?")) {
                fetch(link.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        'X-Requested-With': "XMLHttpRequest",
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({'_token': link.getAttribute('data-token')})
                }).then(
                    response => response.json()
                ).then(data => {
                    if (data.success)
                        link.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }
}