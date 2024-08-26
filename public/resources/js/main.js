document.addEventListener('DOMContentLoaded', () => {
    fetchData();
});

async function fetchData() {
        const endpoint = 'http://localhost:8000/api/v1';

        const response = await fetch(endpoint)
            .then(res => res.json()) //in fetch api json() converts the response into a javascript object
            .then(data => populateTable(data));

    }


function populateTable(data) {
        const table = document.getElementById('url-table');
        const tbody = table.querySelector('tbody');

        tbody.innerHTML = '';

        if(data.length === 0) return "No data";

        console.log(data);
        data.forEach(element => {
            console.log(element.short_code) //element.short_code and element['element'] both works
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
