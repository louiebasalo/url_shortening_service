

let rowsPerPage = 10;
let currentPage = 1;
let totalPages = 0;
let totalEntries = 0;

let pageSet = 5;
let pageSetStart = 1;
let pageSetEnd = (pageSetStart - 1)  + pageSet;

// const visiblePageButtons = 9; //number of visible page buttons between the 1 and the last page.



document.addEventListener('DOMContentLoaded', () => {
    fetchData(currentPage);
    paginate_controls();

});


async function fetchData (currentPage ) {
    // console.log(`currentPage :: ${currentPage} rows :: ${rowsPerPage}`);
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

        const view = document.createElement('button');
        view.classList.add('svg-action-icon');
        view.classList.add('svg-button');
        view.classList.add('table-action-view-button');
        view.id = `${element.short_code}`;

        td1.textContent = window.location.host + '/' + element.short_code;
        td2.textContent =element.clicks; 
        td3.appendChild(view);

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tbody.appendChild(tr)
    });
}

const shorten_url = () =>{
    const original_url = document.getElementById('original-url').value;
    const shorten_url = document.getElementById('shortened-url');

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

function createPaginationButton(text, page, isDisabled = false){
    const button = document.createElement('button');
    button.textContent = text;
    button.classList.add('controls');
    if(isDisabled){
        button.disabled = true;
    } else {
        button.onclick = () => {
            currentPage = page;
            fetchData(page);
        };
    };
    return button;
}

function createEllipsis(next, direction){
    const ellipsis = document.createElement('button');
    ellipsis.textContent = '...';
    ellipsis.classList.add('controls');
    ellipsis.onclick = () => {
        if(direction === 'right'){
            currentPage = next;
            pageSetStart = currentPage;
            pageSetEnd = (currentPage - 1) + pageSet;
        } else {
            currentPage = next;
            pageSetEnd = currentPage;
            pageSetStart = (pageSetEnd + 1) - pageSet;
        }

        paginate_controls();
        fetchData(currentPage);
    }
    return ellipsis;
}

function  paginate_controls(){

    console.log(`current page : ${currentPage}, pageSetStart: ${pageSetStart} and pageSetEnd is: ${pageSetEnd}`);

    const paginationControls = document.getElementById('paginate-buttons-div');
    paginationControls.innerHTML = '';    

    if(totalPages <= pageSet){
        //show all page buttons if total pages is less than the pageSet
        for(let i = 2; i <= totalPages; i++){
            paginationControls.appendChild(createPaginationButton(i, i, i === currentPage));
        }
    } else {
        //show 1st button
        paginationControls.appendChild(createPaginationButton(1, 1, currentPage === 1));

        if(currentPage === 1 || currentPage <= pageSet){
            pageSetStart = 1;
            pageSetEnd = pageSet;
        }

        if(currentPage === totalPages){
            pageSetStart = totalPages - (pageSet - 1);
            pageSetEnd = totalPages;
        }

        //ellipsis next to first  page
        if( (pageSetStart > pageSet || pageSetStart !== 1)){
            paginationControls.appendChild(createEllipsis(pageSetStart-1, 'left'));
        }

        //for-loop to show pages in sets of pageSet
        for(let i = pageSetStart; i <= pageSetEnd; i++){
            if(i === 1) continue;
            if(i === totalPages) break;
            paginationControls.appendChild(createPaginationButton(i, i, i === currentPage));
        }
        // put ellipsis next to last page
        if(pageSetEnd < totalPages){
            paginationControls.appendChild(createEllipsis(pageSetEnd+1, 'right'));
        }

        paginationControls.appendChild(createPaginationButton(totalPages, totalPages, currentPage === totalPages ));
    }


    document.getElementById('copy-button').addEventListener('click', () => {
        var copytext = document.getElementById('shortened-url');
        var copymsg = document.getElementById('copied-message');
        navigator.clipboard.writeText(copytext.value);

        copymsg.style.display = 'block';
        setTimeout(function(){
            copymsg.style.display = 'none';
        }, 5000);

    });

}

