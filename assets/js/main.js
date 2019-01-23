
let searchForm = document.getElementById('form_search')


searchForm.addEventListener('submit', function (e) {
    e.preventDefault()
    let formData = new FormData(searchForm)
    
    console.log(formData)
    // fetch(searchForm.getAttribute('action'))
})