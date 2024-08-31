document.addEventListener('DOMContentLoaded', () => {
    fetchData();
});


async function fetchData () {
        const endpoint = 'http://localhost:8000/api/v1/paginate';

        await fetch(endpoint)
            .then(res => res.json()) //in fetch api json() converts the response into a javascript object
            .then(data => populateTable(data));

    }


const populateTable = (data) => {
    const table = document.getElementById('url-table');
    const tbody = table.querySelector('tbody');

    tbody.innerHTML = '';

    if(data.length === 0) return "No data";

    data.forEach(element => {
        //element.short_code and element['element'] both works
        const tr = document.createElement('tr');
        const td1 = document.createElement('td');
        const td2 = document.createElement('td');

        const td3 = document.createElement('td');
        td3.classList.add('td-action-group');

        const menu = document.createElement('object');
        menu.classList.add('svg-action-icon');
        menu.setAttribute('type', 'image/svg+xml');
        menu.setAttribute('data','resources/img/menu-dots-svgrepo-com.svg');
        menu.classList.add('svg-button');
        menu.classList.add('svg-button-menu-dot');

        td1.textContent = window.location.host + '/' + element.short_code;
        td2.textContent =element.clicks;
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        td3.appendChild(menu);
        tbody.appendChild(tr)
    });
}

const shorten_url = () =>{
    const original_url = document.getElementById('original-url');
    const shorten_url = document.getElementById('shorten-url');

    const endpoint = 'http://localhost:8000/api/v1/create';
    const data = {
        long_url: original_url.value
    };

    fetch(endpoint, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json"
        }
    })
    .then(res => {
        if(!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(msg => {
        if (Object.keys(msg).length === 0) {
            throw new Error('Empty response body');
        }
        try{
            shorten_url.value = window.location.host + '/' + msg.short_url;
            fetchData()
        } catch (e) {
            console.error('Failed to parse JSON:', e);
        }
    })
    .catch(err => console.log(err));


}

document.getElementById('shorten-button').addEventListener('click', shorten_url);
