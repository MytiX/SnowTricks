window.onload = () => {
    let view_more = document.getElementById("view-more")
    let loader = document.getElementById('loader')
    let comments_container = document.getElementById('comments-container')
    let tricks_id = comments_container.getAttribute('data-tricks')
    
    view_more.addEventListener('click', (e) => {
        e.preventDefault()
        
        let linkElement = view_more.firstElementChild
    
        page = linkElement.getAttribute('data-page')
        link = linkElement.getAttribute("href") + '?page=' + page + '&tricks_id=' + tricks_id
        
        console.log(link);
    
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
            comments_container.innerHTML += data.content
    
            loader.classList.toggle('none')
    
            if (data.page != null) {
                linkElement.setAttribute('data-page', data.page)
                view_more.classList.toggle('none')
            }
            
        }).catch()
    })
}