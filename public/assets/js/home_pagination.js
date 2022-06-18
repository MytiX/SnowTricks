window.onload = () => {
    let view_more = document.getElementById("view-more")
    let loader = document.getElementById('loader')
    let trick_container = document.getElementById('trick-container')
    
    view_more.addEventListener('click', (e) => {
        e.preventDefault()
        
        let linkElement = view_more.firstElementChild
    
        page = linkElement.getAttribute('data-page')
        link = linkElement.getAttribute("href") + '?page=' + page
    
        loader.classList.toggle('none')
        view_more.classList.toggle('none')
    
        fetch(link, {
            method: "GET",
            headers: {
                'X-Requested-With': "XMLHttpRequest",
                'Content-Type': 'application/json'
            },
        }).then(
            response => response.json()
        ).then(data => {
            trick_container.innerHTML += data.content
    
            loader.classList.toggle('none')
    
            if (data.page != null) {
                linkElement.setAttribute('data-page', data.page)
                view_more.classList.toggle('none')
            }
            
        }).catch()
    })
}