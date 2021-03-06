let searchForm = document.getElementById('form_search')
let results = document.getElementById('results')
let submitButton = document.getElementById('form_submit')

const column = function (location) {
    let column = document.createElement('div')
    column.classList.add('column')
    column.innerHTML = `
    <div class="card">
        <header>
            ${location.rating ? `<span class="tag is-warning">${location.rating}</span>` : ""}
            <span class="card_name">${location.name}</span> ${location.category ? `<span>- ${location.category}</span>` : ""}
        </header>
        <div class="card-image">
        <figure class="image">
            <img src="${location.image}" alt="${location.name}">
        </figure>
        </div>
        ${location.description ? `<div class="card_description">${location.description}</div>` : ""}

        ${location.price ? `<span class="tag is-link">$${location.price}</span>` : ""}
                <a href="${location.link}">More on ${location.provider} ></a>
    </div>
 `
    return column
}

const render = (locations, error) => {
    results.innerHTML = "";
    
    if (error) {
        return console.error("Something is on fire")
    }
    
    if (locations.length === 0) {
        return console.info("The websites have nothing that matches your search")
    }
    let row = document.createElement('div')
    row.classList.add('columns')
    
    locations.map((location, index) => {
        row.appendChild(column(location))
    })
    results.appendChild(row)
}

const spinnerStart = (_) => {
    submitButton.classList.add('is-loading')
    return Promise.resolve(_)
}

const spinnerEnd = () => submitButton.classList.remove('is-loading')

searchForm.addEventListener('submit', function (e) {
    e.preventDefault()
    let formData = new FormData(e.target)
    let params = new URLSearchParams(formData).toString();
    let action = e.target.getAttribute('action');
    fetch(`${action}?${params}`)
        .then(_ => spinnerStart(_))
        .then(data => data.json())
        .then(json => render(json))
        .finally(_ => spinnerEnd())
})