

let rowsPerPage = 10;
let currentPage = 1;
let totalPages = 10;
let totalEntries = 0;


document.addEventListener('DOMContentLoaded', () => {
    fetchData(currentPage, rowsPerPage);
    paginate_controls();
});


async function fetchData (currentPage, rowsPerPage ) {
    console.log(`currentPage :: ${currentPage} rows :: ${rowsPerPage}`);
        const endpoint = `http://localhost:8000/api/v1/paginate?page=${currentPage}&rows=${rowsPerPage}`;

        await fetch(endpoint)
            .then(res => res.json()) //in fetch api json() converts the response into a javascript object
            .then(data => {
                populateTable(data);
                totalPages = data['meta-data']['total_page'];
                totalEntries = data['meta-data']['total_entries'];
            });

        document.getElementById('total-entries-span').textContent = `Showing ${rowsPerPage} of ${totalEntries}`;
        paginate_controls();
    }

const populateTable = (data) => {
    const table = document.getElementById('url-table');
    const tbody = table.querySelector('tbody');

    tbody.innerHTML = '';

    if(data.length === 0) return "No data";

    data['collection'].forEach(element => {
        //element.short_code and element['short_code'] both works
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
    const original_url = document.getElementById('original-url').value;
    const shorten_url = document.getElementById('shorten-url');

    if(original_url.trim() === '' ){
        alert("original url mandatory");
        return;
    } else {
        const endpoint = 'http://localhost:8000/api/v1/create';
        const data = {
            long_url: original_url
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
                fetchData(currentPage, rowsPerPage )
            } catch (e) {
                console.error('Failed to parse JSON:', e);
            }
        })
        .catch(err => console.log(err));
    }
}

document.getElementById('shorten-button').addEventListener('click', shorten_url);

function  paginate_controls(){
    const paginationControls = document.getElementById('paginate-buttons-div');
    paginationControls.innerHTML = '';    

    if(totalPages > 1){

        //previouse button
        if(currentPage > 1){
            const prevButton = document.createElement('button');
            prevButton.textContent = '<';
            prevButton.onclick = () => {
                currentPage--;
                console.log(currentPage);
                fetchData(currentPage, rowsPerPage);
            }
            paginationControls.appendChild(prevButton);
        }
        //page numbers
        if(totalPages > 1){
            for(let i = 1; i <= totalPages; i++){
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                if (i === currentPage) {
                    pageButton.disabled = true;
                }
                pageButton.onclick = () => {
                    currentPage = i;
                    loadPage(currentPage);
                };
                paginationControls.appendChild(pageButton);
            }
        }
        //next button
        if(currentPage < totalPages){
            const nextButton = document.createElement('button');
            nextButton.textContent = '>';
            nextButton.onclick = () => {
                currentPage++;
                console.log(currentPage+" -- "+totalPages);
                fetchData(currentPage, rowsPerPage);
            }
            paginationControls.appendChild(nextButton);
        }
        
        
    }
}

